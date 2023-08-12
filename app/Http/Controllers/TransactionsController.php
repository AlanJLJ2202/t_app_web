<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccessController extends Controller
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
}