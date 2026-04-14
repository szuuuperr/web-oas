<x-dashboard-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold text-on-surface">Welcome, {{ Auth::user()->name }}</h1>
        <p class="text-on-surface-variant">You are logged in as {{ str_replace('_', ' ', Auth::user()->role) }}</p>
    </div>
</x-dashboard-layout>