<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CreditTransfer;
use App\Models\CreditTransferRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CreditTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $credit_transfers = CreditTransferRequest::query()
            ->where('user_id', auth()->id())
            ->with('toUser')
            ->latest()
            ->paginate();

        return view('credit_transfers.index', compact('credit_transfers'));
    }
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // get random user (except current user) to transfer payment. for demo only

        $receiver = $this->getRandomReceiver();

        return view('credit_transfers.create', compact('receiver'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // 1. Create transfer request

        $amount = $request->amount;
        $from_user_id = auth()->id();
        $to_user_id = $request->to_user_id;
        
        $payload = [
            'user_id' => $from_user_id,
            'to_user_id' => $to_user_id,
            'amount' => $amount,
            'status' => 'initial',
        ];

        $transfer_request = CreditTransferRequest::create($payload);
        
        // 2. Call GETOTP endpoint, if success redirect user to SMS OTP form provided by GETOTP

        try {

            $transfer_ref = $transfer_request->id;

            $otp_mobile_number = '+' . auth()->user()->mobile_number; //+60123456789

            $getotp_payload = [
                'callback_url' => route("credit_transfers.callback"),
                'success_redirect_url' => route("credit_transfers.success", $transfer_ref),
                'fail_redirect_url' => route("credit_transfers.failed", $transfer_ref),
                'channel' => 'sms',
                'phone_sms' => $otp_mobile_number,
            ];

            $api_key = config('getotp.api_key');
            $api_token = config('getotp.api_token');
            $api_endpoint = config('getotp.endpoint');

            $response = Http::withBasicAuth($api_key, $api_token)
                ->post($api_endpoint, $getotp_payload);

            $response_json = $response->json();
            
            Log::info($response_json);

            if ($response->successful()) {

                // set the otp_id and otp_secret of the transfer request

                $transfer_request_payload = [
                    'otp_id' => $response_json['otp_id'],
                    'otp_secret' => $response_json['otp_secret'],
                ];

                $transfer_request->update($transfer_request_payload);

                // redirect to otp verification page

                return redirect()->to($response_json['link']);
            }
            else {
                // you can log the error here

                $error_list = $response_json;

                return redirect()->route('payments.show', $transfer_request->id)->with('otp_errors', $error_list);
            }
        } catch (\Exception $e)
        {
            Log::error($e->getMessage());
            
            return redirect()->route('credit_transfers.show', $transfer_request->id)->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CreditTransferRequest  $credit_transfer_request
     * @return \Illuminate\Http\Response
     */
    public function show(CreditTransferRequest $credit_transfer_request)
    {
        $credit_transfer_request->load('toUser');

        return view('credit_transfers.show', compact('credit_transfer_request'));
    }

    // callback endpoint used by GETOTP
    public function otpCallback(Request $request) {

        /* 
        callback payload example
        {'otp_id': 'C077Khu1yH', 'auth_status': 'verified', 'phone_number': '+60123456789'}
        {'otp_id': 'ABC77Khu1yH', 'auth_status': 'not_verified', 'phone_number': '+60123456789'}
        */

        $otp_id = $request->otp_id;
        $otp_status = strtolower($request->auth_status);

        $transfer_request = CreditTransferRequest::where('otp_id', $otp_id)->first();

        if ($otp_status === 'verified') {
            $this->completeCreditTransfer($transfer_request);
        }
        else {
            $this->failedCreditTransfer($transfer_request);
        }
    }

    // success page for GETOTP redirect  
    public function otpSuccess(Request $request) {
        echo "success page";
    }

    // failed page for GETOTP redirect
    public function otpFailed(Request $request) {
        echo "failed page";
    }

    private function completeCreditTransfer($transfer_request) {
        
        $from_user_id = $transfer_request->user_id;
        $to_user_id = $transfer_request->to_user_id;
        $amount = $transfer_request->amount;
        
        // 1. Update credit balance for user

        $from_user = User::find($from_user_id);

        $from_user->wallet()->decrement('credit', $amount);

        // 2. Update credit balance for receiver

        $to_user = User::find($to_user_id);

        $to_user->wallet()->increment('credit', $amount);

        // 3. update transfer request status

        $transfer_request->update(['status' => 'success', 'verified_at' => now()]);

        // 4. Store the transfer record

        $transfer_payload = [
            'user_id' => $from_user_id,
            'credit_transfer_request_id' => $transfer_request->id,
        ];

        $credit_transfer = CreditTransfer::create($transfer_payload);

        return $credit_transfer;
    }

    // handle failed Credit Transfer Request 
    private function failedCreditTransfer($transfer_request) {
        $transfer_request->update(['status' => 'failed', 'verified_at' => now()]);

        // extra business logic
    }

    // get random user (except current user) to transfer credit. for demo only
    private function getRandomReceiver() {

        $receiver = User::query()
            ->where('id', '!=', auth()->id())
            ->inRandomOrder()
            ->first();

        if (!$receiver) {
            $receiver = auth()->user();
        }

        return $receiver;
    }
}
