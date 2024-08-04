@extends('admin.layout')

@section('title')
    Virtual Pets Manage Pets
@endsection

@section('content')
    <main>

        <section id="existing-pets">
            <h2>Virtual Pets - Existing Pets</h2>
            <div class="new-pet"><a href="{{ route('admin.pets.create') }}">Create New Pet</a></div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pet Name</th>
                        <th>Strength</th>
                        <th>Experience</th>
                        <th>Hunger</th>
                        <th>Owner</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pets as $pet)
                        <tr>

                            <td>{{ $pet->id }}</td>
                            <td>{{ $pet->name->title }}</td>
                            <td>{{ $pet->strength }}</td>
                            <td>{{ $pet->experience }}</td>
                            <td>{{ $pet->hunger_index }}</td>
                            <td> {{'@'}}{{ $pet->user->name }} ({{$pet->user->chat_id}})</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </main>
@endsection
