@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Mon Profil</h1>

    {{-- Informations utilisateur --}}
    <div class="bg-white p-6 rounded shadow mb-6">
        <h2 class="text-lg font-semibold mb-4">Informations</h2>
        <p><span class="font-medium">Nom :</span> {{ Auth::user()->name }}</p>
        <p><span class="font-medium">Email :</span> {{ Auth::user()->email }}</p>
    </div>

    {{-- Gestion des cookies --}}
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-semibold mb-4">Préférences cookies</h2>

        <p class="mb-4">
            Statut actuel :
            @if(Auth::user()->cookies_status == 'accepted')
                <span class="text-green-600 font-semibold">Acceptés</span>
            @elseif(Auth::user()->cookies_status == 'refused')
                <span class="text-red-600 font-semibold">Refusés</span>
            @else
                <span class="text-gray-500 font-semibold">Non défini</span>
            @endif
        </p>

        <form method="POST" action="{{ route('profile.cookies.update') }}" class="flex gap-3">
            @csrf
            <button type="submit" name="cookies_status" value="accepted"
                    style="background-color: #16a34a;"
                    class="hover:bg-green-700 text-white px-4 py-2 rounded">
                Accepter les cookies
            </button>
            <button type="submit" name="cookies_status" value="refused"
                    style="background-color: #dc2626;"
                    class="hover:bg-red-700 text-white px-4 py-2 rounded">
                Refuser les cookies
            </button>
        </form>
    </div>
</div>
@endsection