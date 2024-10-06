@extends('admin.layout')

@section('title')
    Edit Pet
@endsection

@section('content')
    <x-pets-submenu></x-pets-submenu>

    <div class="container">
        <h2>Edit Pet</h2>
        <form class="form" method="POST" action="{{ route('admin.pets.update', $pet->id) }}">
            @csrf
            @method('PUT')

            <label for="name">Pet Name:</label>
            <input type="text" list="name" name="name" value="{{ $pet->name->title }}" required />
            <datalist id="name">
                @foreach ($pet_names as $pet_name)
                    <option value="{{ $pet_name->title }}">{{ $pet_name->title }}</option>
                @endforeach
            </datalist>

            <label for="petStrength">Pet Strength:</label>
            <input type="number" id="petStrength" name="strength" value="{{ $pet->strength }}" required>

            <label for="petLevel">Pet Experience:</label>
            <input type="number" id="petLevel" name="experience" value="{{ $pet->experience }}" required>

            <label for="rarity_id">Pet Rarity:</label>
            <select id="petRarity" name="rarity_id" required>
                @foreach ($pet_rarities as $pet_rarity)
                    <option value="{{ $pet_rarity->id }}" {{ $pet->rarity_id == $pet_rarity->id ? 'selected' : '' }}>
                        {{ $pet_rarity->title }}
                    </option>
                @endforeach
            </select>

            <label for="user_id">Pet User:</label>
            <select id="petUser" name="user_id" required>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ $pet->chat_id == $user->chat_id ? 'selected' : '' }}>
                        {{ $user->name }} - {{ $user->chat_id }}
                    </option>
                @endforeach
            </select>
            @php
                $url = url()->previous();
                $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
            @endphp
            <input type="hidden" name="previous_page" value="{{$route}}">
            <button type="submit">Save Pet</button>
        </form>
    </div>
@endsection
