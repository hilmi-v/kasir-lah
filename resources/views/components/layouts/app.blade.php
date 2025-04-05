<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title.' - '.config('app.name') : config('app.name') }}</title>
    <script type="text/javascript"
        src="https://cdn.jsdelivr.net/gh/robsontenorio/mary@0.44.2/libs/currency/currency.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
    <script>
        flatpickr.localize(flatpickr.l10ns.id);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen font-sans antialiased bg-base-100">

    {{-- NAVBAR mobile only --}}
    <x-nav sticky class="lg:hidden">
        <x-slot:brand>
            <x-app-brand />
        </x-slot:brand>
        <x-slot:actions>
            <label for="main-drawer" class="lg:hidden me-3">
                <x-icon name="o-bars-3" class="cursor-pointer" />
            </label>
        </x-slot:actions>
    </x-nav>

    {{-- MAIN --}}
    <x-main>
        {{-- SIDEBAR --}}
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100 lg:bg-inherit">

            {{-- BRAND --}}
            <x-app-brand class="px-5 pt-4" />

            {{-- MENU --}}
            <x-menu activate-by-route active-bg-color="text-white bg-success hover:text-white">
                <x-menu-item title="Dashboard" icon="bi.grid" link="/" class="py-3 my-1" />
                <x-menu-item title="Transaksi" icon="bi.cart" link="{{ route('transactions.index') }}"
                    class="py-3 my-1" />
                <x-menu-item title="Produk" icon="bi.box" link="{{ route('products.index') }}" class="py-3 my-1" />
                <x-menu-item title="Kategori" icon="bi.boxes" link="{{ route('categories.index') }}"
                    class="py-3 my-1" />
                <x-menu-item title="Stok" icon="bi.cart-plus" link="{{ route('stock.index') }}" class="py-3 my-1" />
                <x-menu-item title="Laporan" icon="bi.file-earmark-arrow-down" link="{{ route('report') }}"
                    class="py-3 my-1" />

                <x-menu-sub title="Settings" icon="o-cog-6-tooth" class="py-4 my-2">
                    <x-menu-item title="Theme" icon="o-swatch" @click="$dispatch('mary-toggle-theme')" />
                    <x-menu-item title="Logout" icon="o-power" link="{{ route('logout') }}" />
                    <x-theme-toggle class="hidden" />
                </x-menu-sub>
            </x-menu>
        </x-slot:sidebar>

        {{-- The `$slot` goes here --}}
        <x-slot:content class="bg-base-200">
            {{ $slot }}
        </x-slot:content>
    </x-main>

    {{-- TOAST area --}}
    <x-toast />
</body>

</html>