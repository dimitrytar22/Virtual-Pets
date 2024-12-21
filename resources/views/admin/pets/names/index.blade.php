@extends('admin.layout')

@section('title')
    Names
@endsection

@section('content')
    <x-pets-submenu></x-pets-submenu>

    <main>
        <section id="existing-pet-names">
            <h2>Pet Names - Existing Names</h2>

            <div class="new-image"><a href="{{ route('admin.pets.names.create') }}">Add New Name</a></div>
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($pet_names as $name)
                    <tr class="row">
                        <td>{{ $name->id }}</td>
                        <td>{{ $name->title }}</td>
                        <td>{{ $name->category->title }}</td>
                        <td class="flex flex-col gap-2">
                            <a href="{{route('admin.pets.names.edit', ['name' => $name->id])}}"
                               class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 text-center">Edit</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{$pet_names->links()}}
        </section>
    </main>
@endsection
