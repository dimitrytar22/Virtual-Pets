@extends('admin.layout')

@section('title')
    Edit category: {{$category->id}}
@endsection

@section('content')
<x-pets-submenu></x-pets-submenu>

<div class="container">
    <h2>Edit category</h2>
    <form class="form" method="POST" action="{{ route('admin.pets.categories.update', $category->id) }}">
        @csrf
        @method('PUT')

        <label for="title">Title:</label>
        <input type="text" list="title" name="title" value="{{ $category->title}}" required />
       

        <div class="success-message">{{ session()->get('message') }}</div>

        <button type="submit">Save Category</button>
    </form>
</div>
@endsection
