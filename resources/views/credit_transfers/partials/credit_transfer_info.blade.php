<div class="mt-10 bg-yellow-100 p-4 rounded-lg flex flex-col space-y-8">

    <div class="flex flex-col space-y-4">
        <label class="font-semibold text-xl" for="">Transfer To</label>
        <div class="flex items-center">
            <div class="flex-shrink-0 h-10 w-10">
                <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60" alt="">
            </div>
            <div class="ml-4">
                <div class="text-sm font-medium text-gray-900">
                    {{ $credit_transfer_request->toUser->name }}
                </div>
                <div class="text-sm text-gray-500">
                    {{ $credit_transfer_request->toUser->email }}
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col space-y-4">
        <label class="font-semibold text-xl" for="">Amount</label>
        <div class="text-2xl font-bold text-red-800">
            {{ $credit_transfer_request->amount }} credits
        </div>
    </div>

    <div class="flex flex-col space-y-4">
        <label class="font-semibold text-xl" for="">Status</label>
        <div class="text-sm font-medium text-gray-900 uppercase">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 uppercase">
                                  {{ $credit_transfer_request->status }}
                                </span>
        </div>
    </div>

    <div class="flex flex-col space-y-4">
        <label class="font-semibold text-xl" for="">Created At</label>
        <div class="text-sm font-medium text-gray-900 uppercase">
            {{ $credit_transfer_request->created_at }}
        </div>
    </div>

    <div class="flex flex-col space-y-4">
        <label class="font-semibold text-xl" for="">Verified At</label>
        <div class="text-sm font-medium text-gray-900 uppercase">
            {{ $credit_transfer_request->verified_at }}
        </div>
    </div>
</div>