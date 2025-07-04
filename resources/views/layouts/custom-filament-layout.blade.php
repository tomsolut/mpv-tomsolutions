<x-filament::layouts.app>
    {{-- Custom Header --}}
    <x-slot name="header">
        <div class="bg-white shadow p-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-primary-700">🚀 Custom Admin Header</h1>
            <div>
                {{-- You can insert icons, search bars, or widgets here --}}
                <livewire:my-custom-header-widget />
            </div>
        </div>
    </x-slot>

    {{ $slot }}
</x-filament::layouts.app>
