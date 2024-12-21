@extends('admin.layout')

@section('title')
    Manage Pets
@endsection

@section('content')
    <x-pets-submenu></x-pets-submenu>
    <main>

        <section id="existing-pets">
            <h2>Virtual Pets - Existing Pets</h2>
            <div class="new-pet"><a href="{{ route('admin.pets.create') }}">Create New Pet</a></div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pet Name</th>
                        <th>Pet Image</th>
                        <th>Strength</th>
                        <th>Experience</th>
                        <th>Rarity</th>
                        <th>Hunger</th>
                        <th>Owner</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pets as $pet)
                        <tr class="row">

                            <td>{{ $pet->id }}</td>
                            <td>{{ $pet->name->title }}</td>
                            <td><img src="{{ asset('images/'. $pet->image->title) }}" alt="image" style="width: 100px"></td>
                            <td>{{ $pet->strength }}</td>
                            <td>{{ $pet->experience }}</td>
                            <td>{{ $pet->rarity->title }}</td>
                            <td>{{ $pet->hunger_index }}</td>
                            <td> {{ '@' }}{{ $pet->user->name }} ({{ $pet->user->chat_id }})</td>
                            <td> <a href="{{ route('admin.pets.edit', $pet->id) }}">Edit</a> </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{$pets->links()}}
        </section>
    </main>
@endsection
