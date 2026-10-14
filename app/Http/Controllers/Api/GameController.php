<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GameApiRequest;
use App\Http\Resources\GameResource;
use App\Models\Game;
use App\Support\ApiFormat;
use Illuminate\Http\Request;

class GameController extends Controller
{
    // GET /api/games?q=&sort=-price&per_page=6
    public function index(Request $request)
    {
        $request->validate([
            'sort'     => ['sometimes', 'in:title,-title,price,-price'],    // белый список полей сортировки
            'per_page' => ['sometimes', 'integer', 'between:1,50'],
        ]);

        $query = Game::with('developer');
        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->query('q') . '%');
        }

        $sort = $request->query('sort');                       // "-" в начале — по убыванию
        $sort
            ? $query->orderBy(ltrim($sort, '-'), str_starts_with($sort, '-') ? 'desc' : 'asc')
            : $query->orderBy('title');                        // SORT по умолчанию: по названию А→Я

        $games = $query->paginate($request->integer('per_page', 6));    // PER_PAGE

        return ApiFormat::success(GameResource::collection($games), 200, [
            'pagination' => [
                'current_page' => $games->currentPage(),
                'last_page'    => $games->lastPage(),
                'per_page'     => $games->perPage(),
                'total'        => $games->total(),
            ],
        ]);
    }

    // POST /api/games
    public function store(GameApiRequest $request)
    {
        $game = Game::create($request->validated())->load('developer');

        return ApiFormat::success(new GameResource($game), 201)
            ->header('Location', route('api.games.show', $game));
    }

    // GET /api/games/{game}
    public function show(Game $game)
    {
        return ApiFormat::success(new GameResource($game->load('developer')));
    }

    // PUT/PATCH /api/games/{game}
    public function update(GameApiRequest $request, Game $game)
    {
        $game->update($request->validated());

        return ApiFormat::success(new GameResource($game->load('developer')));
    }

    // DELETE /api/games/{game}
    public function destroy(Game $game)
    {
        $game->delete();

        return response()->noContent();                        // 204
    }
}
