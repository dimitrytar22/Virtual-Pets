    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title')</title>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    </head>

    <body>
        <div class="wrapper">
            <header id="header">
                <h1>Virtual Pets Admin Panel</h1>
            </header>
            <nav id="navbar">
                <ul>
                    <li><a href="{{ route('admin.index') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.pets.index') }}">Manage Pets</a></li>
                    <li><a href="manage_users.html">Manage Users</a></li>
                    <li><a href="settings.html">Settings</a></li>
                </ul>
            </nav>

            @yield('content')
            <footer>
                <p>&copy; 2024 Virtual Pets</p>
            </footer>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const navbar = document.getElementById('navbar');
                const headerHeight = document.querySelector('header').offsetHeight;

                function stickNavbar() {
                    if (window.scrollY > headerHeight) {
                        navbar.classList.add('fixed');
                    } else {
                        navbar.classList.remove('fixed');
                    }
                }

                window.addEventListener('scroll', stickNavbar);
            });
        </script>
    </body>


    </html>
