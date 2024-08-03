@extends('admin.layout')

@section('title')
    Manage Virtual Pets
@endsection

@section('content')
    <main>
        <section id="pets">
            <h2>Manage Pets</h2>
            <form id="add-pet-form">
                <label for="pet-name">Pet Name:</label>
                <input type="text" id="pet-name" name="pet-name">
                <label for="pet-strength">Pet Strength:</label>
                <input type="number" id="pet-strength" name="pet-strength">
                <label for="pet-level">Pet Level:</label>
                <input type="number" id="pet-level" name="pet-level">
                <label for="pet-hunger">Pet Hunger:</label>
                <input type="number" id="pet-hunger" name="pet-hunger">
                <label for="pet-user">Pet User:</label>
                <input type="text" id="pet-user" name="pet-user">
                <button type="submit">Add Pet</button>
            </form>
            <div id="pet-list">
                <h3>Current Pets</h3>
                <ul>
                    <!-- List of pets will be dynamically added here -->
                </ul>
            </div>
        </section>
    </main>
@endsection
