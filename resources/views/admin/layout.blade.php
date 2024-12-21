<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual Pets - @yield('title')</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="icon" href="/logo.png" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body>
<header>
    <h1>Virtual Pets Admin Panel</h1>
    <nav>
        <ul class="nav-links">
            <li><a href="{{route('admin.pets.index')}}">Manage Pets</a></li>
            <li><a href="{{route('admin.users.index')}}">Manage Users</a></li>
            <li><a href="{{route('admin.fortune_wheel.index')}}">Manage Fortune Wheel</a></li>

        </ul>

        <div class="logout-link">
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>

        </div>

    </nav>
</header>
@yield('content')
<footer>

    <p>&copy; {{date('Y')}} Virtual Pets</p>
</footer>

@yield('scripts')
<script src="{{asset('js/script.js')}}"></script>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

</body>
</html>
