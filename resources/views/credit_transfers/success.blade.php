<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Credit Transfer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="bg-green-300 border border-green-400 px-2 py-1">
                        <h1 class="text-xl font-bold">Success Credit Transfer - REF # {{ $credit_transfer_request->id }}</h1>
                    </div>

                    @include('layouts.partials.alert')

                    @include('credit_transfers.partials.credit_transfer_info')

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
