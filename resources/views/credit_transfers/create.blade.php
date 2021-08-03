<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transfer Credit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <h1 class="text-xl font-bold">Transfer Credit</h1>

                    <form action="{{ route('credit_transfers.store') }}" method="POST" @submit.prevent="submitForm($event)">

                        @csrf

                        <div
                            class="mt-10 bg-yellow-100 border border-yellow-300 p-4 rounded-lg flex flex-col space-y-8">

                            <div class="flex flex-col space-y-4">
                                <label class="font-semibold text-xl" for="">Transfer To</label>
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full"
                                            src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60"
                                            alt="">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $receiver->name }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $receiver->email }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col space-y-4">
                                <label class="font-semibold text-xl" for="">Amount</label>
                                <div class="text-2xl font-bold text-red-600">
                                    100 credits
                                </div>

                                <input type="hidden" name="to_user_id" id="to_user_id" value="{{ $receiver->id }}">
                                <input type="hidden" name="amount" id="amount" value="100">

                            </div>

                            <div class="text-center space-y-2">
                                <button type="submit" class="btn-verify-payment rounded-lg px-4 py-2 bg-purple-600 text-white text-xl font-bold">Submit</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>