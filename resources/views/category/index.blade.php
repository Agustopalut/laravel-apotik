{{-- ini di ambil dari dashboard  --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Categories') }}
            </h2>
            <a href="{{ route('admin.categories.create') }}" class="py-3 px-5 rounded-full font-bold text-white bg-indigo-600">Add Category</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white flex flex-col gap-y-5 overflow-hidden shadow-sm sm:rounded-lg p-10">

                @forelse ($categories as $category)
                    <div class="item-card flex flex-row justify-between items-center">
                        <img src="{{ Storage::url($category->icon) }}" alt="" class="w-[50px] h-[50px]">
                        <h3 class="text-2xl font-bold">{{ $category->name }}</h3>
                        <div class="flex flex-row items-center gap-x-3">
                            <a href="{{ route('admin.categories.edit',$category) }}" class="py-3 px-5 rounded-full text-white bg-indigo-600">Edit</a>
                            <form method="POST" action="{{ route('admin.categories.destroy',$category) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-5 py-2 rounded-full text-white bg-red-600">Delete</button>

                            </form>
                        </div>
                    </div>
                @empty
                    
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>
