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

    public function view_dashboard(){
        return view('dashboard');
    }

    public function get_transactions(){
        try {

            $user = Auth::user();
            \Log::info($user);

            //$transactions = Transaction::where('user_id', Auth::user()->id)->get();
            $transactions = Transaction::where('user_id', Auth::user()->id)->with('category')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc') // Luego, si son del mismo día, ordenamos por 'created_at' en orden descendente
            ->get();

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

            \Log::error($e->getMessage());

            return response()->json($data, 500);
        }
    }


    public function register_transaction(Request $request){

        \Log::info($request->all());

        try {
            $request->validate([
                'amount' => 'required|numeric',
            ]);

            DB::beginTransaction();

            // Get user authenticated
            $user = Auth::user();
            // Create transaction

            if($request->id != null && $request->id > 0){
                $transaction = Transaction::find($request->id);
                $transaction->category_id = $request->category_id;
                $transaction->type = $request->type;
                $transaction->amount = $request->amount;
                $transaction->date = $request->date;
                $transaction->description = $request->description;
                $transaction->save();

                $balance = Balance::where('user_id', $user->id)->first();
                $balance->amount = $request->type == 'abono' ? 
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
            }else{
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
                $balance->amount = $request->type == 'abono' ? 
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
            }

            
        } catch (\Exception $e) {
            DB::rollback();

            $data = [
                'status' => 'error',
                'error' => $e->getMessage()
            ];

            \Log::error($e->getMessage());

            return response()->json($data, 500);
        }
    }



}