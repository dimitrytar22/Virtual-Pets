@extends('admin.layout')

@section('title')
    Create Images
@endsection

@section('content')
    <x-pets-submenu></x-pets-submenu>

    <div class="content">
        <h2>Create New Pet Image</h2>
        <form class="form" method="POST" action="{{ route('admin.pets.images.store') }}" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>

            <label for="image">Image:</label>
            <input type="file" id="image" name="image" accept=".jpg,.jpeg, .png, .bmp, .gif, .svg, .webp" required>
            <img id="imagePreview" src="#" width="300px" alt="Image Preview"
                style="display:none; margin-top: 10px; max-width: 100%; height: auto;">

            <label for="category">Category:</label>
            <select id="category" name="category_id" required>
                @foreach ($pet_categories as $category)
                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                @endforeach
            </select>

            <button type="submit">Save Pet Image</button>
        </form>
    </div>

    <script>
        document.getElementById('image').addEventListener('change', function(event) {
            const [file] = event.target.files;
            if (file) {
                const preview = document.getElementById('imagePreview');
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
            }
        });
    </script>
@endsection
