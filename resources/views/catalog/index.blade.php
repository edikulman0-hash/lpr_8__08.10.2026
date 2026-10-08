@extends('layouts.app')

@section('content')
    <h1>{{ $title }}</h1>

    <form method="GET" action="{{ route('catalog.index') }}" class="row g-2 mb-3">
        <div class="col-auto">
            <input type="text" name="q" value="{{ $search }}" class="form-control" placeholder="Название...">
        </div>
        <div class="col-auto">
            <select name="sort" class="form-select">
                <option value="title" @selected($sort === 'title')>По названию</option>
                <option value="release_year" @selected($sort === 'release_year')>По году</option>
                <option value="price" @selected($sort === 'price')>По цене</option>
            </select>
        </div>
        <div class="col-auto"><button class="btn btn-secondary">Найти</button></div>
    </form>

    <table class="table">
        <tr><th>№</th><th>Название</th><th>Разработчик</th><th>Год</th><th>Рейтинг</th><th></th></tr>
        @forelse ($games as $game)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td><a href="{{ route('catalog.show', ['id' => $game['id']]) }}">{{ $game['title'] }}</a></td>
                <td><a href="{{ route('catalog.developer', $game['developer']) }}">{{ $game['developer'] }}</a></td>
                <td>{{ $game['release_year'] }}</td>
                <td>{{ number_format($game['rating'], 1, ',', ' ') }}</td>
                <td>@if ($game['is_multiplayer']) <span class="badge bg-primary">Мультиплеер</span> @endif</td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-muted">Ничего не найдено.</td></tr>
        @endforelse
    </table>
@endsection 
