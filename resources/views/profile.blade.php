@php
    $layout = match (Auth::user()->role) {
        'admin' => 'components.layouts.main',
        'dokter' => 'components.layouts.dok',
        'resepsionis' => 'components.layouts.index',
        default => 'components.layouts.app',
    };
@endphp

<x-dynamic-component :component="$layout">
    @livewire('auth.user-profile')
</x-dynamic-component>
