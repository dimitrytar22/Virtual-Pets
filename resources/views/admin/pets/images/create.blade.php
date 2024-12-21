@extends('admin.layout')

@section('title')
    Create Images
@endsection

@section('content')
    <x-pets-submenu></x-pets-submenu>

    <div class="content">
        <h2>Create New Pet Image</h2>
        <form class="space-y-6" method="POST" action="{{route('admin.pets.images.store')}}" enctype="multipart/form-data">
            @csrf
            @method('POST')


            <div class="space-y-2">
                <span class="text-lg font-medium text-black">Selected Image:</span>
                <div class="rounded-md">
                    <img id="imagePreview" src="#" style="width: 400px; display: none" class="w-full max-w-md rounded-lg shadow-md" alt="Image Preview">
                </div>
            </div>

            <div class="space-y-2">
                <label for="image" class="block text-sm font-medium text-gray-700">Choose an image:</label>
                <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png,.bmp,.gif,.svg,.webp" required class="block w-full text-sm text-gray-700 bg-gray-50 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 file:px-4 file:py-2 file:border-0 file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200">
            </div>

            <div class="space-y-2">
                <label for="category_id" class="block text-sm font-medium text-gray-700">Choose category:</label>
                <select name="category_id" id="category_id">
                    @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->title}}</option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-2">
                <button type="submit" class="w-full py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Save Pet Image
                </button>
            </div>
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
