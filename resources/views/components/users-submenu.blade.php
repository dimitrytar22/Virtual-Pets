<nav class="submenu">
    <ul class="nav-links">
        <li><a href="{{route('admin.users.pets.index')}}">User's Pets</a></li>
        <li><a href="{{route('admin.users.inventories.index')}}">User's Inventories</a></li>
        <li><a href="{{route('admin.users.registration_applications.index')}}">User's Registration Application <sup><span style="color: #ff0000">{{\App\Models\RegistrationApplication::all()->count()}}</span></sup></a></li>

    </ul>
</nav>
