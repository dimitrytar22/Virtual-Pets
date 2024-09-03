<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual Pets - @yield('title')</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>
<body>
    <header>
        <h1>Virtual Pets Admin Panel</h1>
        <nav>
            <ul class="nav-links">
                <li><a href="{{route('admin.pets.index')}}">Manage Pets</a></li>
                <li><a href="{{route('admin.users.index')}}">Manage Users</a></li>
            </ul>
            <div class="language-select">
                <div class="select-container">
                    <!-- Выбранный элемент -->
                    <div class="select-selected">
                        <img src="https://upload.wikimedia.org/wikipedia/en/thumb/a/a4/Flag_of_the_United_States.svg/20px-Flag_of_the_United_States.svg.png" alt="English Flag" class="flag-img">
                        <span>Select Language</span>
                    </div>
                    <!-- Список опций -->
                    <div class="select-items select-hide">
                        <div class="select-item" data-value="en" data-img="https://upload.wikimedia.org/wikipedia/en/thumb/a/a4/Flag_of_the_United_States.svg/20px-Flag_of_the_United_States.svg.png">
                            English
                        </div>
                        <div class="select-item" data-value="ru" data-img="https://upload.wikimedia.org/wikipedia/en/thumb/f/f3/Flag_of_Russia.svg/20px-Flag_of_Russia.svg.png">
                            Русский
                        </div>
                        <div class="select-item" data-value="uk" data-img="https://upload.wikimedia.org/wikipedia/commons/thumb/4/49/Flag_of_Ukraine.svg/20px-Flag_of_Ukraine.svg.png">
                            Українська
                        </div>
                    </div>
                    <!-- Скрытый селект -->
                    <select id="language" name="language" style="display: none;">
                        <option value="en">English</option>
                        <option value="ru">Русский</option>
                        <option value="uk">Українська</option>
                    </select>
                </div>
            </div>
            
        </nav>
    </header>
    
    

            @yield('content')
            <footer>
                <p>&copy; 2024 Virtual Pets</p>
            </footer>
        </div>
    <script src="{{asset('js/script.js')}}"></script>
    
</body>
</html>
