<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Wallet;
use App\Transfer;
use App\Http\Requests;
use App\Http\Requests\TransferRequest;
use Log;

class TransferController extends Controller
{
    public function getTransfer()
    {
        $wl = DB::table('wallets')->where('user_id', Auth::user()->id)->get();
        $wl1 = Wallet::all();
        return view('wallet.transfer', compact('wl'));
    }

    public function postTransfer(TransferRequest $request)
    {
        $id_from = $request->sltFrom;
        $id_to =   $request->sltTo;
        $wl1 = Wallet::find($id_from);
        $wl2 = Wallet::find($id_to);
        $amount = str_replace(',','',$request->txtAmount);
        
        if($wl1->amount < $amount)
        {
            return back()->with(['flash-level' => 'danger', 'flash-message'=>'You cant do this, the balance of gift wallet < transfer amount']);
        }

        $wl1->amount = ($wl1->amount - $amount);
        $wl2->amount = ($wl2->amount + $amount);

        $wl1->save();
        $wl2->save();

        $transfer = new Transfer;
        $transfer->id_from = $id_from;
        $transfer->id_to = $id_to;
        $transfer->user_id = Auth::user()->id;
        $transfer->amount_transfer = $amount;
        $transfer->save();

        $to = Auth::user()->phone;
        if($amount >= 100000000)
        {
            return redirect()->route('send_message', $to);
        }

        return redirect()->route('wallet.index')->with(['flash-level'=>'success', 'flash-message' => 'You have been tranfered successfuly']);
    }

    public function history_transfer(){
        $data = DB::table('transfers')->where('user_id', Auth::user()->id)->get();
        return view('wallet.transfer.list_history_transfer', compact('data'));
    }

    public function delete_history_transfer($id){
        $transfer = Transfer::find($id);
        $transfer->delete();
        return back()->with(['flash-level' => 'success', 'flash-message'=>'You have been deleted transfer successfuly']);
    }

    public function sendMessage(\Nexmo\Client $nexmo, $to){
        $message = $nexmo->message()->send([
            'to' => $to,
            'from' => '84961915162',
            'text' => '[WARNING] You have sent > 100.000.000 dong several minutes ago, please check again to sure that you have just sent money to another wallet'
        ]);
        Log::info('sent message: ' . $message['message-id']);
        
    }
}
