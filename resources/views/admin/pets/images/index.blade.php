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
                        <tr>
                            <td>{{ $image->id }}</td>
                            <td>{{ $image->title }}</td>
                            <td>{{ $image->category->title }}</td>
                            <td>
                                <img src="{{ asset("images/".$image->title) }}" alt="{{ $image->title }}" style="width: 100px;">
                            </td>
                            <td>
                                <a href="{{route('admin.pets.images.edit', ['image' => $image->id])}}">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </main>
@endsection
