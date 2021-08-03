<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Make Payment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <h1 class="text-xl font-bold">View Payment - REF # {{ $payment->id }}</h1>

                    @include('layouts.partials.alert')

                    @include('payments.partials.payment_info')

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
