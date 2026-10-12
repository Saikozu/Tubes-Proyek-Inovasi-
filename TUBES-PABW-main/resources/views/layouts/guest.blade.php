<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'Sahabat Warga') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex items-center justify-center
             bg-gradient-to-br from-purple-600 via-purple-700 to-indigo-800">

    <div class="w-full max-w-md bg-white dark:bg-gray-900
                p-8 rounded-2xl shadow-2xl">

        <!-- Title -->
        <h1 class="text-3xl font-bold text-center text-purple-600 mb-2">
            {{ config('app.name', 'Sahabat Warga') }}
        </h1>
        <p class="text-center text-gray-500 mb-6">
            Welcome, please sign in or create account
        </p>

        {{ $slot }}

    </div>

</body>
</html>
