<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    {{-- SECURITY NOTE:
         No CSP, no security headers → intentional vulnerabilities !!!!!!!!!!!! n--}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sandbox</title>

    {{-- Tailwind (from Breeze build) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

{{-- Top navigation bar --}}
<nav class="bg-white shadow mb-6">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between">

        <div class="flex space-x-4">
            <a href="{{ route('ideas.index') }}" class="font-bold">Ideas</a>
            <a href="{{ route('logs.index') }}">Logs</a>
            <a href="{{ route('redirect.vulnerable', ['url' => 'https://google.com']) }}">
                Open Redirect Test
            </a>
            <a href="{{ route('charte.show') }}">Charte</a>
        </div>

        <div class="flex space-x-4">
            @auth
                <button class="font-medium hover:text-blue-700">
                    <a href="{{ route('profile.show') }}">{{ auth()->user()->name }}</a>
                </button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-red-600">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endauth
        </div>

    </div>
</nav>

{{-- Main content section --}}
<main class="max-w-7xl mx-auto px-4">
    @yield('content')*

    {{-- Popup after login --}}

    @if(session('show_popup') && Auth::user()->cookies_status == null)
        <div id="popup" class="fixed inset-0 flex items-center justify-center" style = "backdrop-filter:blur(2px);">
            <div class="bg-white p-6 rounded shadow-lg">
                <h2 class="text-xl font-bold mb-4">Cookie</h2>
                <p class="mb-4">Veuillez accepter ou refuser les cookies pour continuer.</p>
                <form method="POST" class="flex gap-3">
                    @csrf
                    <button type="submit" formaction="{{ route('ideas.acceptation') }}" style="background-color: #16a34a;" class="hover:bg-green-700 text-white px-4 py-2 rounded">Accepter les cookies</button>
                    <button type="submit" formaction="{{ route('ideas.refusal') }}" style="background-color: #dc2626;" class="hover:bg-red-700 text-white px-4 py-2 rounded">Refuser les cookies</button>
                </form>
            </div>
        </div>
    @endif
</main>

</body>
</html>
