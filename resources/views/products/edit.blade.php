{{-- ini di ambil dari dashboard  --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Product ') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10">

                @if ($errors->any())
                    @foreach ($errors->all() as $error)

                    <div class="py-3 px-4 rounded-circle w-full bg-red-600 text-white">
                        {{ $error }}
                    </div>

                    @endforeach
                @endif

                <form method="POST" action="{{ route('admin.products.update',$product->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ $product->name }}" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    {{-- price --}}
                    <div>
                        <x-input-label for="price" :value="__('price')" />
                        <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" value="{{ $product->price }}" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>

                    {{-- Category id --}}
                    <div>
                        <x-input-label for="price" :value="__('category id')" />
                        <select name="category_id" id="category_id" class="py-2 w-full rounded-xl border border-slate-300">
                            @forelse ($categories as $category)
                                @if ($category->id == $product->category->id)
                                    <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
        
                                @else
                                    <option value="{{ $category->id }}" >{{ $category->name }}</option>
                                @endif
            
                            @empty
                                
                            @endforelse
                        </select>
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>

                    {{-- about --}}
                    <div>
                        <x-input-label for="about" :value="__('about')" />
                        <textarea name="about" id="about" cols="30" rows="5" class="border border-slate-300 w-full rounded-2xl">{{ $product->about }}</textarea>
                        <x-input-error :messages="$errors->get('about')" class="mt-2" />
                    </div>
            
                    <!-- Photo image-->
                    <div class="mt-4">
                        <x-input-label for="Photo" :value="__('Photo')" />
                        <img src="{{ Storage::url($product->photo) }}" alt="" class="w-[50px] h-[80px]">
                        <x-text-input id="Photo" class="block mt-1 w-full" type="file" name="photo" autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            {{-- input file untuk input icon  --}}
                    </div>
            
                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ms-4">
                            {{ __('Update Product') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
