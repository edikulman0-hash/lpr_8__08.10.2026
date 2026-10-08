<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CatalogController extends Controller
{
    // Временное хранилище: в ЛПР № 9 его заменит база данных
    private function games(): array
    {
        return [
            ['id' => 1, 'code' => 'WIT-03150', 'title' => 'Ведьмак 3: Дикая Охота', 'developer' => 'CD Projekt Red',
             'release_year' => 2015, 'price' => 1299.00, 'rating' => 9.3, 'is_multiplayer' => false],
            ['id' => 2, 'code' => 'CYB-20770', 'title' => 'Cyberpunk 2077', 'developer' => 'CD Projekt Red',
             'release_year' => 2020, 'price' => 1999.00, 'rating' => 8.6, 'is_multiplayer' => false],
            ['id' => 3, 'code' => 'POR-00020', 'title' => 'Portal 2', 'developer' => 'Valve',
             'release_year' => 2011, 'price' => 599.00, 'rating' => 9.5, 'is_multiplayer' => true],
            ['id' => 4, 'code' => 'LEF-00044', 'title' => 'Left 4 Dead 2', 'developer' => 'Valve',
             'release_year' => 2009, 'price' => 499.00, 'rating' => 9.0, 'is_multiplayer' => true],
            ['id' => 5, 'code' => 'ELD-02022', 'title' => 'Elden Ring', 'developer' => 'FromSoftware',
             'release_year' => 2022, 'price' => 3499.00, 'rating' => 9.4, 'is_multiplayer' => true],
            ['id' => 6, 'code' => 'DAR-03016', 'title' => 'Dark Souls III', 'developer' => 'FromSoftware',
             'release_year' => 2016, 'price' => 1799.00, 'rating' => 8.9, 'is_multiplayer' => true],
        ];
    }

    // GET /catalog?q=...&sort=...
    public function index(Request $request)
    {
        $games = collect($this->games());
        $search = $request->query('q');

        if ($search) {
            $games = $games->filter(fn ($g) => mb_stripos($g['title'], $search) !== false);
        }

        $sort = $request->query('sort', 'title');
        if (in_array($sort, ['title', 'release_year', 'price'])) {
            $games = $games->sortBy($sort);
        }

        return view('catalog.index', [
            'title'  => 'Каталог игр',
            'games'  => $games,
            'search' => $search,
            'sort'   => $sort,
        ]);
    }

    // GET /catalog/3
    public function show(int $id)
    {
        $game = collect($this->games())->firstWhere('id', $id);
        abort_if(! $game, 404);

        return view('catalog.show', ['title' => $game['title'], 'game' => $game]);
    }

    // GET /catalog/code/WIT-03150
    public function byCode(string $code)
    {
        $game = collect($this->games())->firstWhere('code', $code);
        abort_if(! $game, 404);

        return view('catalog.show', ['title' => $game['title'], 'game' => $game]);
    }

    // GET /catalog/developer/Valve  или  /catalog/developer
    public function byDeveloper(?string $developer = null)
    {
        $games = collect($this->games());

        if ($developer) {
            $games = $games->where('developer', $developer);
        }

        return view('catalog.index', [
            'title'  => $developer ? "Игры: {$developer}" : 'Все разработчики',
            'games'  => $games,
            'search' => null,
            'sort'   => 'title',
        ]);
    }
}
