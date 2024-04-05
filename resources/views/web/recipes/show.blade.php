@extends('layouts.app')

@section('content')
    <div class="grid items-start grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="w-full lg:sticky top-0 sm:flex gap-2">
            <img src="{{ $recipe->image }}" class="w-full rounded object-cover" />
        </div>
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800">
                {{ $recipe->name }}
            </h1>
            @if (optional($recipe->ingredients)->isNotEmpty())
                <div class="mt-8">
                    <h2 class="text-lg font-bold text-gray-800">
                        {{ __('Ingredientes') }}
                    </h2>
                    <ul class="space-y-3 list-disc mt-4 pl-4 text-sm text-gray-800">
                        @foreach ($recipe->ingredients as $ingredient)
                            <li>
                                {{ $ingredient->pivot->amount }}
                                {{ $ingredient->name }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="mt-8">
                <h2 class="text-lg font-bold text-gray-800">
                    {{ __('Receta') }}
                </h2>
                <div class="prose">
                    @markdown($recipe->description)
                </div>
            </div>
        </div>
    </div>
@endsection