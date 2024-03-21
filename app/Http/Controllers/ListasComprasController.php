<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Balance;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ListasComprasController extends Controller
{

    public function view_listas(){
        return view('listas_compras');
    }



    public function get_listas(){
        try {

            $user = Auth::user();
            \Log::info($user);

            //$transactions = Transaction::where('user_id', Auth::user()->id)->get();
            $listas = ListaCompra::where('user_id', Auth::user()->id)->with('productos')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc') // Luego, si son del mismo día, ordenamos por 'created_at' en orden descendente
            ->get();

            $data = [
                'status' => 'success',
                'listas' => $listas
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


}