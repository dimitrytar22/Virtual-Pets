@extends('admin.layout')


@section('title')
    Create Name
@endsection

@section('content')
    <x-pets-submenu></x-pets-submenu>

    <div class="content">
        <h2>Create New Pet Name</h2>
        <form class="form" method="POST" action="{{ route('admin.pets.names.store') }}" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>

            
            <label for="category">Category:</label>
            <select id="category" name="category_id" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                @endforeach
            </select>

            <button type="submit">Save Pet Name</button>
        </form>
    </div>
@endsection
