<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Balance;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\ListaCompra;
use App\Models\ProductoCategoria;
use App\Models\Producto;

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

    public function get_categorias(){
        try {

            $categorias = ProductoCategoria::all();

            $data = [
                'status' => 'success',
                'categorias' => $categorias
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

    public function get_productos(){
        try {

            $productos = Producto::all();

            $data = [
                'status' => 'success',
                'productos' => $productos
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

    public function register_lista(Request $request){
        try {

            $user = Auth::user();

            $lista = new ListaCompra();
            $lista->user_id = $user->id;
            $lista->date = $request->date;
            $lista->save();

            $data = [
                'status' => 'success',
                'lista' => $lista
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

    public function register_producto(Request $request){
        try {

            \Log::info($request->all());

            $user = Auth::user();

            $producto = new Producto();
            $producto->nombre = $request->nombre;
            $producto->cantidad = $request->cantidad;
            $producto->unidad = $request->unidad;
            $producto->precio_unidad = $request->precio_unidad;
            $producto->categoria_id = $request->categoria_id;
            $producto->save();

            $data = [
                'status' => 'success',
                'producto' => $producto
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



    public function update_producto(Request $request){
        try {

            \Log::info($request->all());

            $user = Auth::user();

            $producto = Producto::find($request->id);
            $producto->nombre = $request->nombre;
            $producto->cantidad = $request->cantidad;
            $producto->unidad = $request->unidad;
            $producto->precio_unidad = $request->precio_unidad;
            $producto->categoria_id = $request->categoria_id;
            $producto->save();

            $data = [
                'status' => 'success',
                'producto' => $producto
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