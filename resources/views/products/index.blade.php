{{-- ini di ambil dari dashboard  --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Product') }}
            </h2>
            <a href="{{ route('admin.products.create') }}" class="py-3 px-5 rounded-full font-bold text-white bg-indigo-600">Add new Product</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white flex flex-col gap-y-5 overflow-hidden shadow-sm sm:rounded-lg p-10">

                @forelse ($products as $product)
                    <div class="item-card flex flex-row justify-between items-center">
                        <div class="flex items-center gap-x-3">
                            <img src="{{ Storage::url($product->photo) }}" alt="" class="w-[50px] h-[80px]">
                            <div>
                                <h3 class="text-2xl font-bold">{{ $product->name }}</h3>
                                <p class="text-base text-slate-500">Rp.{{ $product->price }}</p>
                            </div>
                        </div>
                        <p class="text-base text-slate-500">{{$product->category->name }}</p>
                        <div class="flex flex-row items-center gap-x-3">
                            <a href="{{ route('admin.products.edit',$product) }}" class="py-3 px-5 rounded-full text-white bg-indigo-600">Edit</a>
                            <form method="POST" action="{{ route('admin.products.destroy',$product) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-5 py-2 rounded-full text-white bg-red-600">Delete</button>
                            </form>
                        </div>
                    </div>
                @empty
                    {{-- jika data kosong / empty --}}
                    <p>Data belum di input oleh pemilikm apotik </p>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>
