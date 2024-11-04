@extends('admin.layout')


@section('title')
    Users`s Registration Applications
@endsection

@section('content')
    <x-users-submenu></x-users-submenu>
    <main>
        <section id="manage-users" class="container">
            <h2>Registration Applications</h2>


            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Chat ID</th>
                    <th>Password</th>
                    <th>Claimed Role</th>
                    <th>Actions</th>
                </tr>
                </thead>
                @if($registration_applications->isEmpty())
                    <tbody>
                    </tbody>
                    </table>
                    <h1>
                        <div style="color:red">There aren't applications</div>
                    </h1>
                @else



                    @foreach ($registration_applications as $application)
                    <form method="POST" action="{{route('admin.users.registration_applications.update', $application->id)}}" id="approveForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="user_id" value="{{$application->user_id}}">
                        <input type="hidden" name="password" value="{{$application->password}}">
                        <input type="hidden" name="role_id" value="{{$application->role_id}}">
                    </form>

                    <form method="POST" action="{{route('admin.users.registration_applications.destroy', $application->id)}}" id="rejectForm">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="application_id" value="{{$application->id}}">
                    </form>
                        <tr>
                            <td>{{$application->id}}</td>
                            <td>{{$application->user->name}}</td>
                            <td>{{$application->user->chat_id}}</td>
                            <td>{{$application->password}}</td>
                            <td>{{$application->role->title}}</td>
                            <td>
                                <button onclick="submitApproveForm()" style="background-color: lawngreen; border: none; width: 80px; height: 25px">Approve</button>
                                <button onclick="submitRejectForm()" style="background-color: #e66161; border: none;  width: 80px; height: 25px">Reject</button>
                            </td>
                        </tr>
                    @endforeach


                    </tbody>
                    </table>
            @endif
        </section>
    </main>
@endsection

@section('scripts')
    <script>
        function submitApproveForm() {
            document.getElementById("approveForm").submit();
        }
        function submitRejectForm() {
            document.getElementById("rejectForm").submit();
        }
    </script>
@endsection
