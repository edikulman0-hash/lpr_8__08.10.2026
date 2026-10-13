@extends('layouts.app')

@section('content')
    <h1>{{ $title }}</h1>

    <form method="POST" class="col-lg-8"
          action="{{ $game->exists ? route('games.update', $game) : route('games.store') }}">
        @csrf
        @if ($game->exists) @method('PUT') @endif

        <label class="form-label">Разработчик</label>
        <select name="developer_id" class="form-select mb-2 @error('developer_id') is-invalid @enderror">
            @foreach ($developers as $developer)
                <option value="{{ $developer->id }}" @selected(old('developer_id', $game->developer_id) == $developer->id)>
                    {{ $developer->name }}
                </option>
            @endforeach
        </select>
        @error('developer_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror

        <label class="form-label">Название</label>
        <input name="title" value="{{ old('title', $game->title) }}"
               class="form-control @error('title') is-invalid @enderror">
        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror

        <label class="form-label mt-2">Описание</label>
        <textarea name="description" rows="3"
                  class="form-control @error('description') is-invalid @enderror">{{ old('description', $game->description) }}</textarea>
        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror

        <label class="form-label mt-2">Год выпуска</label>
        <input type="number" name="release_year" value="{{ old('release_year', $game->release_year) }}"
               class="form-control @error('release_year') is-invalid @enderror">
        @error('release_year') <div class="invalid-feedback">{{ $message }}</div> @enderror

        <label class="form-label mt-2">Цена, ₽</label>
        <input type="number" step="0.01" name="price" value="{{ old('price', $game->price) }}"
               class="form-control @error('price') is-invalid @enderror">
        @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror

        <label class="form-label mt-2">Рейтинг (0–10)</label>
        <input type="number" step="0.1" name="rating" value="{{ old('rating', $game->rating) }}"
               class="form-control @error('rating') is-invalid @enderror">
        @error('rating') <div class="invalid-feedback">{{ $message }}</div> @enderror

        <div class="form-check my-2">
            <input type="checkbox" name="is_multiplayer" value="1" class="form-check-input"
                   @checked(old('is_multiplayer', $game->is_multiplayer))>
            <label class="form-check-label">Мультиплеер</label>
        </div>

        <button class="btn btn-primary">Сохранить</button>
        <a href="{{ route('games.index') }}" class="btn btn-link">Отмена</a>
    </form>
@endsection
