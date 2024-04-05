@extends('layouts.base')

@section('body')
    <div class="min-h-full">
        <x-navigation/>

        <div class="py-10">
            <main>
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    @yield('content')

                    @isset($slot)
                        {{ $slot }}
                    @endisset
                </div>
            </main>
        </div>
    </div>
@endsection
