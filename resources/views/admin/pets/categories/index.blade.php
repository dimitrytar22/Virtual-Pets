@extends('admin.layout')

@section('title')
    Categories
@endsection

@section('content')
    <x-pets-submenu></x-pets-submenu>

    <main>

        <section id="message">{{session()->get('message')}}</section>
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
                    <tr class="row">

                        <td>{{ $category->id }}</td>
                        <td>{{ $category->title }}</td>
                        <td class="flex flex-col justify-center gap-1 h-full">
                            <a href="{{route('admin.pets.categories.edit', ['category' => $category->id])}}"
                               class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 text-center">
                                Edit
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{$categories->links()}}
        </section>
    </main>
@endsection
