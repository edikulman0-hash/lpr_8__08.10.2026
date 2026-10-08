@extends('layouts.app')

@section('content')
    <h1>{{ $game['title'] }}</h1>

    <dl class="row">
        <dt class="col-sm-3">Код</dt>          <dd class="col-sm-9">{{ $game['code'] }}</dd>
        <dt class="col-sm-3">Разработчик</dt>  <dd class="col-sm-9">{{ $game['developer'] }}</dd>
        <dt class="col-sm-3">Год выпуска</dt>  <dd class="col-sm-9">{{ $game['release_year'] }}</dd>
        <dt class="col-sm-3">Цена</dt>
        <dd class="col-sm-9">{{ number_format($game['price'], 2, ',', ' ') }} ₽</dd>
        <dt class="col-sm-3">Рейтинг</dt>
        <dd class="col-sm-9">{{ number_format($game['rating'], 1, ',', ' ') }}</dd>
        <dt class="col-sm-3">Мультиплеер</dt>
        <dd class="col-sm-9">{{ $game['is_multiplayer'] ? 'Да' : 'Нет' }}</dd>
    </dl>

    <a href="{{ route('catalog.index') }}">&larr; К каталогу</a>
@endsection
