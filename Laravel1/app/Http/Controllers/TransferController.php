<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Wallet;
use App\Transfer;
use App\Http\Requests;

class TransferController extends Controller
{
    public function getTransfer()
    {
        $wl = DB::table('wallets')->where('user_id', Auth::user()->id)->get();
        $wl1 = Wallet::all();
        return view('wallet.transfer', compact('wl'));
    }

    public function postTransfer(Request $request)
    {
        $id_from = $request->sltFrom;
        $id_to =   $request->sltTo;
        $wl1 = Wallet::find($id_from);
        $wl2 = Wallet::find($id_to);
        $amount = str_replace(',','',$request->txtAmount);
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

        return redirect()->route('wallet.index')->with(['flash-level'=>'success', 'flash-message' => 'You have been tranfered successfuly']);
    }
}
