@extends('admin.layout')

@section('title')
    Edit name: {{$name->id}}
@endsection

@section('content')
<x-pets-submenu></x-pets-submenu>

<div class="container">
    <h2>Edit name</h2>
    <form class="form" method="POST" action="{{ route('admin.pets.names.update', $name->id) }}">
        @csrf
        @method('PUT')

        <label for="title">Title:</label>
        <input type="text" list="title" name="title" value="{{ $name->title}}" required />

        <label for="category">Category:</label>
            <select id="category" name="category_id" required>
                @foreach ($pet_categories as $category)
                    <option value="{{ $category->id }}"
                        {{$name->category->title == $category->title ? "selected" : "" }}>{{ $category->title }}</option>
                @endforeach
            </select>

        <div class="success-message">{{ session()->get('message') }}</div>

        <button type="submit">Save Name</button>
    </form>
</div>
@endsection
