{{-- ini di ambil dari dashboard  --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ Auth::user()->hasRole('owner') ?  __('Apotik Orders') : __('My Transaction')  }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white flex flex-col gap-y-5 overflow-hidden shadow-sm sm:rounded-lg p-10">
                    <div class="item-card flex flex-row justify-between items-center">
                        <div class="flex items-center gap-x-3">
                            <div>
                                <p class="text-base text-slate-500">
                                    Total Transaksi 
                                </p>
                                <h3 class="text-xl font-bold">
                                    Rp. 18.000.000
                                </h3>
                            </div>
                        </div>
                        <div>
                            <p class="text-base text-slate-500">
                                Date 
                            </p>
                            <h3 class="text-xl font-bold">
                                25 Januari 2024 
                            </h3>
                        </div>
                        <span class=" py-1 px-3 rounded-full text-white text-sm bg-orange-400 ">
                            <p>Pending</p>
                        </span>
                        <div class="flex flex-row items-center gap-x-3">
                            <a href="{{ route('product-transaction.show',1) }}" class="py-3 px-5 rounded-full text-white bg-indigo-600">View Details</a>
                        </div>
                    </div>

                    <hr class="my-3">
                    <div class="item-card flex flex-row justify-between items-center">
                        <div class="flex items-center gap-x-3">
                            <div>
                                <p class="text-base text-slate-500">
                                    Total Transaksi 
                                </p>
                                <h3 class="text-xl font-bold">
                                    Rp. 18.000.000
                                </h3>
                            </div>
                        </div>
                        <div>
                            <p class="text-base text-slate-500">
                                Date 
                            </p>
                            <h3 class="text-xl font-bold">
                                25 Januari 2024 
                            </h3>
                        </div>
                        <span class=" py-1 px-3 rounded-full text-white text-sm bg-orange-400 ">
                            <p>Pending</p>
                        </span>
                        <div class="flex flex-row items-center gap-x-3">
                            <a href="{{ route('product-transaction.show',1) }}" class="py-3 px-5 rounded-full text-white bg-indigo-600">View Details</a>
                        </div>
                    </div>

                    <hr class="my-3">
                    <div class="item-card flex flex-row justify-between items-center">
                        <div class="flex items-center gap-x-3">
                            <div>
                                <p class="text-base text-slate-500">
                                    Total Transaksi 
                                </p>
                                <h3 class="text-xl font-bold">
                                    Rp. 18.000.000
                                </h3>
                            </div>
                        </div>
                        <div>
                            <p class="text-base text-slate-500">
                                Date 
                            </p>
                            <h3 class="text-xl font-bold">
                                25 Januari 2024 
                            </h3>
                        </div>
                        <span class=" py-1 px-3 rounded-full text-white text-sm bg-orange-400 ">
                            <p>Pending</p>
                        </span>
                        <div class="flex flex-row items-center gap-x-3">
                            <a href="{{ route('product-transaction.show',1) }}" class="py-3 px-5 rounded-full text-white bg-indigo-600">View Details</a>
                        </div>
                    </div>

                    <hr class="my-3">


            </div>
        </div>
    </div>
</x-app-layout>
