@extends('admin.layout')

@section('title')
    User's inventories
@endsection




@section('content')
    <x-users-submenu></x-users-submenu>

    <div class="user-pets">
        <h2>Select User to View Inventory</h2>
        <h3>Selected User: <b><span id="selected-user"></span></b></h3>
        <div class="new-item">
            <a href="{{route('admin.users.inventories.create')}}">Create New Item</a>
        </div>

        <select id="userSelect">
            @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->chat_id }})</option>
            @endforeach
        </select>
        <button id="searchButton">Search</button>

        <div id="petsTable"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('searchButton').addEventListener('click', function() {

                const userId = document.getElementById('userSelect').value;

                fetch(`/admin/users/inventories/search?user_id=${userId}`)
                    .then(response => response.json())
                    .then(data => {
                        let inventoriesHtml = '<table><thead><tr><th>ID</th><th>Title</th><th>Amount</th><th>Action</th></tr></thead><tbody>';
                        let selectedOption = userSelect.options[userSelect.selectedIndex].text;
                        let selected_user = "NULL";
                        if(data.inventory[0] == null){
                            selected_user = "@"+selectedOption.split(' (')[0];
                            inventoriesHtml = selected_user + '`s inventory is empty!';
                        }else{
                            data.inventory.forEach(itemUser => {
                                selected_user = "@" + itemUser.user.name;
                                inventoriesHtml += `
                                    <tr>
                                        <td>${itemUser.id}</td>
                                        <td>${itemUser.item.title}</td>
                                        <td>${itemUser.amount}</td>
                                        <td>
                                            <a href='/admin/users/inventories/${itemUser.id}/edit' class='btn-custom btn-edit'>Edit</a>
                                            <form action='/admin/users/inventories/${itemUser.id}' method='POST' style='display:inline-block;'>
                                                @csrf
                                @method('DELETE')
                                <button type='submit' class='btn-custom' onclick='return confirm("Are you sure you want to delete this pet?")'>Delete</button>
                            </form>
                        </td>
                        </tr>
    `;
                            });
                        inventoriesHtml += '</tbody></table>';
                        }


                        document.getElementById('petsTable').innerHTML = inventoriesHtml;
                        document.getElementById('selected-user').innerHTML = selected_user;
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    </script>


@endsection
