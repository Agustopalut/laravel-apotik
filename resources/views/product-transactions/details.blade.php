{{-- ini di ambil dari dashboard  --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Details ') }}
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
                                Rp. {{ $transaction->total_amount }}
                            </h3>
                        </div>
                    </div>
                    <div>
                        <p class="text-base text-slate-500">
                            Date
                        </p>
                        <h3 class="text-xl font-bold">
                            {{ $transaction->created_at }}
                        </h3>
                    </div>

                    @if ($transaction->is_paid)
                        <span class=" py-1 px-3 rounded-full text-white text-sm bg-green-400 ">
                            <p>Success</p>
                        </span>
                    @else
                        <span class=" py-1 px-3 rounded-full text-white text-sm bg-orange-400 ">
                            <p>Pending</p>
                        </span>
                    @endif
                </div>
                <hr class="my-3">


                <h3 class="text-xl font-bold">
                    List of Items
                </h3>

                {{-- list of items --}}

                <div class="grid grid-cols-4 gap-y-3 gap-x-10">
                    {{-- item card list data & details of delivery --}}
                    <div class="flex flex-col gap-y-5 col-span-2">
                        @forelse ($transaction->transaction_details as $details)
                            {{-- melakukan looping terhadap transaction details yang berelasi ke product transaction --}}
                            <div class="item-card flex flex-row justify-between items-center">
                                <div class="flex items-center gap-x-3">
                                    <img src="{{ Storage::url($details->product->photo) }}" alt=""
                                        class="w-[50px] h-[80px]">
                                    <div>
                                        <h3 class="text-2xl font-bold">
                                            {{ $details->product->name }}
                                        </h3>
                                        <p class="text-base text-slate-500">
                                            Rp. {{ $details->product->price }}
                                        </p>
                                    </div>
                                </div>
                                <p class="text-base text-slate-500">
                                    {{ $details->product->category->name }}
                                </p>
                            </div>

                        @empty
                        @endforelse

                        {{-- detail of delivery  --}}
                        <h3 class="text-xl font-bold">
                            Details of delivery
                        </h3>
                        <div class="item-card flex flex-row justify-between items-center">
                            <p class="text-base text-slate-500">
                                Address
                            </p>
                            <h3 class="text-xl font-bold">
                                {{ $transaction->address }}
                            </h3>
                        </div>
                        <div class="item-card flex flex-row justify-between items-center">
                            <p class="text-base text-slate-500">
                                city
                            </p>
                            <h3 class="text-xl font-bold">
                                {{ $transaction->city }}
                            </h3>
                        </div>
                        <div class="item-card flex flex-row justify-between items-center">
                            <p class="text-base text-slate-500">
                                post code
                            </p>
                            <h3 class="text-xl font-bold">
                                {{ $transaction->post_code }}
                            </h3>
                        </div>
                        <div class="item-card flex flex-row justify-between items-center">
                            <p class="text-base text-slate-500">
                                phone number
                            </p>
                            <h3 class="text-xl font-bold">
                                {{ $transaction->phone_number }}
                            </h3>
                        </div>
                        <div class="item-card flex flex-col items-start">
                            <p class="text-base text-slate-500">
                                Notes
                            </p>
                            <h3 class="text-xl font-bold">
                                {{ $transaction->note }}
                            </h3>
                        </div>
                    </div>

                    {{-- bukti pembayaran --}}
                    <div class="flex flex-col gap-y-5 col-span-2 items-end">
                        <h3 class="text-lg font-bold">
                            Proof payment
                        </h3>
                        {{-- ini untuk bukti pembayaran --}}
                        <img src="{{ Storage::url($transaction->proof) }}" alt=""
                            class="w-[300px] h-[400px] bg-red-300">
                    </div>



                </div>
                <hr class="my-3">

                @if (!$transaction->is_paid)
                    {{-- jika status masih pending/ belum di approve, munculkan --}}
                    {{-- jika sudah approve, hilangkan --}}
                    @role('owner')
                    <form method="POST" action="{{ route('product-transaction.update', $transaction) }}">
                        {{-- melakukam update status pembayaran  --}}
                        @csrf
                        @method('PUT')
                        <button type="submit" class="px-5 py-2 rounded-full text-white bg-indigo-500">
                            Approve Order
                        </button>
                    </form>
                    @endrole
                @else
                    <a href="" class="px-5 py-2 rounded-full text-white bg-indigo-500 w-fit">Contact Admin </a>
                @endif
                {{-- class w-fit, lebar nya se content  --}}
            </div>
        </div>
    </div>
</x-app-layout>
