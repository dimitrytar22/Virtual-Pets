<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <div>
        <img src="{{asset('images/login-logo.jpg')}}" alt="Logo or Pet Image" class="header-image" width="300px" style="margin: 20px">

    </div>
    <div>

        <h1>Virtual Pets Admin Panel</h1>
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div>
