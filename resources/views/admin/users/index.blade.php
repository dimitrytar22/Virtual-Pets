@extends('admin.layout')


@section('title')
    Manage Users
@endsection

@section('content')
    <x-users-submenu></x-users-submenu>
    <main>
        <section id="manage-users" class="container">
            <h2>Virtual Pets - Existing Users</h2>
            <div class="new-user">
                <a href="{{ route('admin.users.create') }}">Create New User</a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Chat ID</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example row -->

                    @foreach ($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->chat_id}}</td>
                            <td>
                                <button>Edit</button>
                            </td>
                        </tr>
                    @endforeach
                    <!-- Additional user rows -->
                </tbody>
            </table>
            <div class="pagination">
                <button>Previous</button>
                <button>Next</button>
            </div>
        </section>
    </main>
@endsection
