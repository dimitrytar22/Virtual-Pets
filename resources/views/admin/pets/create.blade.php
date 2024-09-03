@extends('admin.layout')


@section('title')
    Create Pets
@endsection

@section('content')
    <x-pets-submenu></x-pets-submenu>

    <main>
        <section id="pets">
            <h2>Virtual Pets - Manage Pets</h2>
            <form class="form" method="POST" action="{{ route('admin.pets.store') }}">
                @csrf
                @method('POST')
                <label for="name_id">Pet Name:</label>

                <input type="text" list="name" name="name" />
                <datalist id="name">
                    @foreach ($pet_names as $pet_name)
                        <option value="{{ $pet_name->title }}">{{ $pet_name->title }}</option>
                    @endforeach
                </datalist>


                <label for="petStrength">Pet Strength:</label>
                <input type="number" id="petStrength" name="strength" required>

                <label for="petLevel">Pet Experience:</label>
                <input type="number" id="petLevel" name="experience" required>

                <label for="rarity_id">Pet Rarity:</label>
                <select type="text" id="petRarity" name="rarity_id" required>
                    @foreach ($pet_rarities as $pet_rarity)
                        <option value="{{ $pet_rarity->id }}">{{ $pet_rarity->title }}</option>
                    @endforeach
                </select>


                <label for="chat_id">Pet User:</label>
                <select type="text" id="petUser" name="chat_id" required>
                    @foreach ($users as $user)
                        <option value="{{ $user->chat_id }}">{{ $user->name }} - {{ $user->chat_id }}</option>
                    @endforeach
                </select>

                <button type="submit">Save Pet</button>
            </form>
        </section>


    </main>
@endsection
