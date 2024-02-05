<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class AccesoController extends Controller
{
    public function login(Request $request){
        
		\Log::info('Request', $request->all());
		try {

				//if method is post
				if ($request->isMethod('POST')) {


					\Log::info('1');

					$validator = Validator::make($request->all(), [
						'email' => 'required',
						'password' => 'required'
					]);

					\Log::info('2');

					if ($validator->fails()) {
						$alert = array(
							'estatus' => 400,
							'msg' => 'Los campos son requeridos'
						);
						return redirect()->back()->with('alert', $alert)->withInput();
					}

					\Log::info('3');

					$credentials = $request->only('email', 'password');
					if (Auth::attempt($credentials)) {
						// Authentication passed...
						\Log::info('4');
						$alert = array(
							'estatus' => 200,
							'msg' => 'Welcome to the system'
						);
						return redirect()->route('dashboard')->with('alert', $alert);
					} else {
						\Log::info('5');
						$alert = array(
							'estatus' => 400,
							'msg' => 'El usuario o la contraseña son incorrectos'
						);
						return redirect()->back()->with('alert', $alert)->withInput();
					}
				}

				return view('login');

			
		} catch (\Exception $e) {
			\DB::rollback();
            $alert = array(
                'estatus' => 500,
				'msg' => 'An error occurred, please try again',
				'error' => $e->getMessage(),
				'line' => $e->getLine(),
				'trace' => $e->getTrace()
            );
			\Log::info('Error', $alert);
            return redirect()->back()->with('alert', $alert)->withInput();
		}
    }

	public function view_index(){
		//Auth::logout();
		return view('layout');
	}

	public function logout(){
		Auth::logout();
		return redirect()->route('login');
	}

}