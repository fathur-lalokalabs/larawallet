<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CreditTransfer;
use App\Models\CreditTransferRequest;

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
        
        // 2. Transfer request completed

        $this->completeCreditTransfer($transfer_request);

        return redirect()->route('credit_transfers.index')->with('success', 'Credit successfully transferred');
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
