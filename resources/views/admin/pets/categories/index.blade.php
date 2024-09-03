@extends('admin.layout')

@section('title')
    Categories
@endsection

@section('content')
    <x-pets-submenu></x-pets-submenu>

    <main>  

        <section id="existing-categories">
            <h2>Virtual Pets - Existing Categories</h2>
            <div class="new-pet"><a href="{{route('admin.pets.categories.create')}}">Create New Category</a></div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>

                            <td>{{ $category->id }}</td>
                            <td>{{ $category->title }}</td>
                            <td> <a href="{{route('admin.pets.categories.edit', ['category' => $category->id])}}">Edit</a> </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </main>
@endsection         