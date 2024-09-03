@extends('admin.layout')

@section('title')
    Create Category
@endsection

@section('content')
    <x-pets-submenu></x-pets-submenu>

    <main>

        <section id="categories">
            <h2>Virtual Pets - Create category</h2>
            <form class="form" method="POST" action="{{ route('admin.pets.categories.store') }}">
                @csrf
                @method('POST')
                <label for="title">Category title:</label>




                <input type="text" id="title" name="title" required>



                <button type="submit">Save Category</button>
            </form>
        </section>
    </main>
@endsection
