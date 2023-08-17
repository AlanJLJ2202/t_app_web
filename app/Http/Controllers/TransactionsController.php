<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Balance;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionsController extends Controller
{

    public function get_transactions(){
        try {
            $transactions = Transaction::where('user_id', Auth::user()->id)->get();

            $data = [
                'status' => 'success',
                'transactions' => $transactions
            ];

            return response()->json($data, 200);
        } catch (\Exception $e) {
            $data = [
                'status' => 'error',
                'error' => $e->getMessage()
            ];

            return response()->json($data, 500);
        }
    }


    public function register_transaction(Request $request){
        try {
            $request->validate([
                'amount' => 'required|numeric',
            ]);

            DB::beginTransaction();

            // Get user authenticated
            $user = User::find(Auth::user()->id);
            // Create transaction
            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->category_id = $request->category_id;
            $transaction->type = $request->type;
            $transaction->amount = $request->amount;
            $transaction->date = $request->date;
            $transaction->description = $request->description;
            $transaction->save();
            //Create new balance
            $balance = new Balance();
            $balance->user_id = $user->id;
            $balance->amount = $request->type == 'income' ? 
                               $user->balance + $request->amount : 
                               $user->balance - $request->amount;
            $balance->save();
            // Update user balance
            $user->balance = $balance->amount;
            $user->save();

            DB::commit();

            $data = [
                'status' => 'success',
                'transaction' => $transaction,
                'balance' => $balance
            ];

            return response()->json($data, 201);
        } catch (\Exception $e) {
            DB::rollback();

            $data = [
                'status' => 'error',
                'error' => $e->getMessage()
            ];

            return response()->json($data, 500);
        }
    }



}