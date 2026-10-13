<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use App\Http\Requests\GameRequest;
use App\Models\Developer;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Game::with('developer');                  // жадная загрузка связи

        if ($search = $request->query('q')) {
            $query->where('title', 'like', "%{$search}%");
        }

        $query->orderBy('title');                          // SORT: по названию А→Я

        return view('games.index', [
            'title' => 'Игры',
            'games' => $query->paginate(6)->withQueryString(),   // PER_PAGE = 6
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('games.form', [
            'title'      => 'Новая игра',
            'game'       => new Game(),
            'developers' => Developer::orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GameRequest $request)
    {
        $game = Game::create($request->validated());          // только проверенные поля

        return redirect()->route('games.index')
            ->with('status', "Добавлено: {$game->title} (id {$game->id})");
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game)                          // запись найдена по {game} автоматически
    {
        return view('games.form', [
            'title'      => 'Редактирование',
            'game'       => $game,
            'developers' => Developer::orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GameRequest $request, Game $game)
    {
        $game->update($request->validated());

        return redirect()->route('games.index')->with('status', 'Изменения сохранены.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        $game->delete();

        return redirect()->route('games.index')->with('status', "Удалено: {$game->title}");
    }
}
