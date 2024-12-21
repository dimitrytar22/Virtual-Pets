@extends('admin.layout')

@section('title')
    Images
@endsection

@section('content')
    <x-pets-submenu></x-pets-submenu>

    <main>
        <section id="existing-pet-images">
            <h2>Pet Images - Existing Images</h2>

            <div class="new-image"><a href="{{ route('admin.pets.images.create') }}">Add New Image</a></div>
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($pet_images as $image)
                    <tr class="row">
                        <td>{{ $image->id }}</td>
                        <td>{{ $image->title }}</td>
                        <td>{{ $image->category->title }}</td>
                        <td>
                            <img src="{{ asset("images/".$image->title) }}" alt="{{ $image->title }}"
                                 style="width: 100px;">
                        </td>
                        <td class="flex flex-col gap-2">
                            <a href="{{ route('admin.pets.images.edit', ['image' => $image->id]) }}"
                               class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 text-center">
                                Edit
                            </a>
                            <form id="delete-form-{{ $image->id }}"
                                  action="{{ route('admin.pets.images.destroy', ['image' => $image->id]) }}"
                                  method="POST" style="display: none;">
                                @method("DELETE")
                                @csrf
                            </form>
                            <a href="#"
                               onclick="event.preventDefault(); document.getElementById('delete-form-{{ $image->id }}').submit();"
                               class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 text-center">
                                Delete
                            </a>

                        </td>


                    </tr>
                @endforeach
                </tbody>
            </table>
            {{$pet_images->links()}}
        </section>
    </main>
@endsection
