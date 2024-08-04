@extends('admin.layout')


@section('title')
    Virtual Pets Manage Users
@endsection

@section('content')
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
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example row -->
                    <tr>
                        <td>1</td>
                        <td>John Doe</td>
                        <td>john@example.com</td>
                        <td>
                            <button>Edit</button>
                        </td>
                    </tr>
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
