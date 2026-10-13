@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h1>{{ $title }}</h1>
        <a href="{{ route('games.create') }}" class="btn btn-success align-self-center">+ Добавить</a>
    </div>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-auto"><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Название..."></div>
        <div class="col-auto"><button class="btn btn-secondary">Найти</button></div>
    </form>

    <table class="table table-striped align-middle">
        <tr><th>#</th><th>Название</th><th>Разработчик</th><th>Год</th><th>Цена</th><th>Рейтинг</th><th></th></tr>
        @foreach ($games as $game)
            <tr>
                <td>{{ $game->id }}</td>
                <td>{{ $game->title }}</td>
                <td>{{ $game->developer->name }}</td>
                <td>{{ $game->release_year }}</td>
                <td>{{ $game->price }} ₽</td>
                <td>{{ $game->rating }}</td>
                <td class="text-end">
                    <a href="{{ route('games.edit', $game) }}" class="btn btn-sm btn-outline-primary">Изменить</a>
                    <form method="POST" action="{{ route('games.destroy', $game) }}" class="d-inline"
                          onsubmit="return confirm('Удалить запись?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Удалить</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    {{ $games->links() }}
@endsection
