@extends('admin.layout')

@section('title')
    User's pets
@endsection

@section('content')
    <x-users-submenu></x-users-submenu>

    <div class="user-pets">
        <h2>Select User to View Pets</h2>
        <!-- Форма для выбора пользователя -->
        <select id="userSelect">
            @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
            @endforeach
        </select>
        <button id="searchButton">Search</button>

        <!-- Здесь будет отображаться таблица с питомцами -->
        <div id="petsTable"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('searchButton').addEventListener('click', function() {

                const userId = document.getElementById('userSelect').value;

                // Отправляем AJAX-запрос на сервер
                fetch(`/admin/users/pets/search?user_id=${userId}`)
                    .then(response => response.json())
                    .then(data => {
                        let petsHtml = '<table><thead><tr><th>ID</th><th>Name</th><th>Category</th><th>Rarity</th><th>Image</th><th>Strength</th><th>Experience</th><th>Action</th></tr></thead><tbody>';

                        data.pets.forEach(pet => {
                            petsHtml += `
                                <tr>
                                    <td>${pet.id}</td>
                                    <td>${pet.name.title}</td>
                                    <td>${pet.name.category.title}</td>
                                    <td>${pet.rarity.title}</td>
                                    <td><img width='100px' src='/images/${pet.image.title}'></td>
                                    <td>${pet.strength}</td>
                                    <td>${pet.experience}</td>
                                    <td>
                                        <a href='/admin/pets/${pet.id}/edit' class='btn-custom btn-edit'>Edit</a>
                                        <form action='/admin/pets/${pet.id}' method='POST' style='display:inline-block;'>
                                            @csrf
                                            @method('DELETE')
                                            <button type='submit' class='btn-custom' onclick='return confirm("Are you sure you want to delete this pet?")'>Delete</button>
                                        </form>
                                    </td>
                                    </tr>
                            `;
                        });

                        petsHtml += '</tbody></table>';

                        // Вставляем таблицу с питомцами на страницу
                        document.getElementById('petsTable').innerHTML = petsHtml;
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
        </script>


@endsection
