<div id="verify_payment_modal" class="modal fade hidden" tabindex="-1" aria-labelledby="verifyPaymentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">

        <div class="modal-content modal-block">

            <!-- submit overlay -->

            <div x-show="form_submitting"
                class="absolute bg-white w-full h-full flex justify-center items-center opacity-80 z-10 rounded-sm p-4">
                <h2 class="text-gray-600 text-5xl text-center inline-flex items-center">

                    <span x-text="form_submitting_text"></span>

                    <svg class="animate-spin h-10 w-10 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                </h2>
            </div>

            <!-- end submit overlay -->

            <div class="modal-header">
                <h5 class="font-semibold modal-title" id="verifyPaymentModalLabel">
                    Proceed to Payment Verification with GETOTP
                </h5>
                <button type="button" data-bs-dismiss="modal" aria-label="Close" class="link-cool-gray p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="modal-body" id="modal_body">

                <!-- form content -->
                <div class="space-y-6">
                    <div class="space-y-2 bg-purple-100 border border-purple-300 rounded-lg p-4 text-gray-600">

                        <p class="font-bold text-xl">Note:</p>

                        <p>In order <span class="font-bold">to make it easier</span> for visitors to test our demo, we
                            allow visitors to
                            input their own email / mobile number.</p>

                        <p>In a real application, the developer should use the current authenticated user email or
                            mobile number.</p>

                        <p>We will not store the phone and email address data that you use for this demo except in you
                            browser's local
                            storage, to
                            avoid you having to re-enter the data multiple times.</p>

                    </div>

                    <!-- error message -->
                    <div x-show="validation_errors.length > 0"
                        class="space-y-2 bg-red-100 border border-red-300 rounded-lg p-4">
                        <p class="font-bold">Error</p>

                        <ul class="list-disc list-inside">
                            <template x-for="validation_error in validation_errors">
                                <div>
                                    <template x-for="error_message in validation_error">
                                        <li x-html="error_message"></li>
                                    </template>
                                </div>
                            </template>
                        </ul>
                    </div>
                    <!-- end error message -->

                    <div class="">
                        <div x-show="showEmailField()">
                            <div class="flex flex-col space-y-4">
                                <label class="font-semibold text-xl" for="">Email</label>

                                <p class="text-sm font-light">OTP verification will be send to this email address. Enter
                                    valid email address to test Email OTP</p>

                                <input type="text" x-model="formData.custom_email" class="rounded-md " value=""
                                    name="custom_email" placeholder="{{ auth()->user()->email }}">

                            </div>
                        </div>

                        <div class="mt-4" x-show="showPhoneField()">
                            <div class="flex flex-col space-y-4">
                                <label class="font-semibold text-xl" for="">Mobile
                                    Number</label>

                                <p class="text-sm font-light">OTP verification will be send to this mobile number. Enter
                                    valid mobile number
                                    (including country code) to test SMS /
                                    Voice OTP.</p>

                                <input type="number" x-model="formData.custom_phone" class="rounded-md " value=""
                                    name="custom_phone" placeholder="{{ auth()->user()->mobile_number }}">


                            </div>
                        </div>

                        <div class="mt-4">
                            <div class="flex flex-col space-y-4">
                                <label class="font-semibold text-xl" for="">Captcha</label>

                                <div class="flex">
                                    <div id="captcha_container">
                                        {!! captcha_img('flat') !!}
                                    </div>

                                    <button
                                        class="border border-pink-300 bg-pink-100 rounded-md py-1 px-2 ml-2 font-bold"
                                        type="button" @click="reloadCaptcha()">Reload</button>

                                </div>

                                <input type="text" x-model="formData.captcha" class="rounded-md " value=""
                                    name="captcha" placeholder="" autocomplete="off">


                            </div>
                        </div>



                    </div>

                </div>
                <!-- end form content -->

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-cool-gray btn-md mr-1" data-bs-dismiss="modal">Cancel</button>
                <button type="submit"
                    class="ml-4 bg-purple-600 text-white py-1 px-2 rounded-md font-bold">Proceed</button>
            </div>
        </div>

    </div>
</div>