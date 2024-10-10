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
            <input type="text" list="category_id" name="category_id" />
            <datalist id="category_id">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                @endforeach
            </datalist>

            <button type="submit">Save Pet Name</button>
        </form>
    </div>
@endsection
