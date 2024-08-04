@extends('admin.layout')

@section('title')
Virtual Pets Manage Pets
@endsection

@section('content')
    <main>
       
        <section id="existing-pets">
            <h2>Virtual Pets - Existing Pets</h2>
            <div class="new-pet"><a href="{{route('admin.pets.create')}}">Create New Pet</a></div>
            <table>
                <thead>
                    <tr>
                        <th>Pet Name</th>
                        <th>Strength</th>
                        <th>Level</th>
                        <th>Hunger</th>
                        <th>Owner</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Existing pet rows will be dynamically inserted here -->
                </tbody>
            </table>
        </section>
    </main>
@endsection
