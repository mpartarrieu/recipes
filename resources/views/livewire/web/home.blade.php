<div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6"
        x-data="{
            ingredients: {{ collect($this->ingredients)->toJson() }},
            ingredientesOpen: false,
            ingredientsOptions: function () {
                if (this.ingredientesSearch) {
                    return this.ingredients.filter((item) => item.label.toLowerCase().indexOf(this.ingredientesSearch.toLowerCase()) >= 0);
                }

                return this.ingredients;
            },
            ingredientesSearch: null,
            ingredientsToggle: function (ingredientId) {
                $wire.toggleIngredient(ingredientId);
                this.ingredientesSearch = null;
                this.ingredientesOpen = false;
            },
            search: @if (Arr::get($filters, 'search')) `{{ $filters['search'] }}` @else null @endif
        }"
    >
        <div class="relative flex flex-1">
            <svg class="pointer-events-none absolute inset-y-0 left-2.5 h-full w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd"></path>
            </svg>
            <input type="search" x-model="search" x-on:search="$wire.set('filters.search', search);" class="block h-full w-full py-3 pl-10 pr-2 text-gray-900 placeholder:text-gray-400 border border-gray-300 rounded" placeholder="{{ __('Buscar plato') }}..." >
        </div>
        <div class="relative inline-block text-left"
            x-on:click.away="ingredientesOpen = false"
        >
            <svg class="pointer-events-none absolute inset-y-0 left-2.5 h-full w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 13.5V3.75m0 9.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 3.75V16.5m12-3V3.75m0 9.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 3.75V16.5m-6-9V3.75m0 3.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 9.75V10.5" />
            </svg>
            <input type="search" x-model="ingredientesSearch" class="block h-full w-full py-3 pl-10 pr-2 text-gray-900 placeholder:text-gray-400 border border-gray-300 rounded" placeholder="{{ __('Buscar ingrediente') }}..." x-on:focus="ingredientesOpen = true" />
            <div class="absolute left-0 right-0 z-10 mt-1 w-full"
                x-show="ingredientesOpen" 
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
            >
                <div class="max-h-48 overflow-y-auto border border-gray-300 rounded">
                    <template x-for="item in ingredientsOptions">
                        <button type="button" class="text-gray-700 block px-4 py-1 text-sm hover:text-gray-900" 
                            x-text="item.label"
                            x-on:click="ingredientsToggle(item.id)"
                        ></button>
                    </template>
                </div>
            </div>
        </div>
        @if ($selectedIngredients)
            <div>
                @foreach ($selectedIngredients as $ingredient)
                    <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10 mr-3 mb-2">
                        {{ Arr::get($ingredient, 'label') }}
                        <button class="ml-1 text-red-300 hover:text-red-600" x-on:click="ingredientsToggle({{ Arr::get($ingredient, 'id') }})">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </span>
                @endforeach
            </div>
        @endif
    </div>

    @if ($recipes->isEmpty())
        <div class="rounded-md bg-blue-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3 flex-1 md:flex md:justify-between">
                    <p class="text-sm text-blue-700">No se encontraron recetas.</p>
                </div>
            </div>
        </div>
    @else
        <ul role="list" class="grid grid-cols-1 gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @foreach ($recipes as $recipe)
                <li class="col-span-1 flex flex-col divide-y divide-gray-200 rounded-lg bg-indigo-50 text-center shadow-md">
                    <div class="flex flex-1 flex-col p-8">
                        <img src="{{ $recipe->image }}" class="h-32 object-cover rounded">
                        <h3 class="mt-6 font-medium text-gray-900">{{ $recipe->name }}</h3>
                        <dl class="mt-1 flex flex-grow flex-col justify-between">
                            <dd class="text-sm text-gray-500">{{ $recipe->ingredients->implode('name', ', ') }}</dd>
                        </dl>
                    </div>
                    <div>
                        <a href="{{ $recipe->url }}" class="block text-center rounded bg-indigo-600 px-2 py-3 font-semibold text-white hover:bg-indigo-500">
                            {{ __('Ver receta') }}
                        </a>
                    </div>
                </li>
            @endforeach
        </ul>
        {{ $recipes->links() }}
    @endif
</div>
