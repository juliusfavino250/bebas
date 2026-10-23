<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - PKL Management</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 border border-slate-200">
        <!-- Logo & Title Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 bg-indigo-600 text-white rounded-2xl font-bold text-2xl shadow-lg mb-3">
                PKL
            </div>
            <h1 class="text-2xl font-bold text-slate-800">PKL Management</h1>
            <p class="text-sm text-slate-500 mt-1">Sistem Informasi PKL Siswa SMK</p>
        </div>

        @yield('content')
    </div>
</body>
</html>