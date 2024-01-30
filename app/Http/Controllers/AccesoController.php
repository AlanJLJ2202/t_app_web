<?php 

namespace App\Http\Controllers;


class AccesoController extends Controller
{
    public function login(Request $request){
        
		\Log::info('Request', $request->all());
		\DB::beginTransaction();
		try {
				$rules = array(
					'email' => 'required|email',
					'password' => 'required',

				);

				$validator = Validator::make($request->all(), $rules);

				if($validator->fails())
				{
					$alert = array(
						'estatus' => 'warning',
						'mensaje' => 'Fields are required'
					);
					return redirect()->back()
					->with('alert', $alert)
					->withInput();
				}

				\Log::info('Success', $request->all());

				$email = $request->input('email');
				$password = $request->input('password');
				$credentials = array('email' => $email, 'password' => $password);

				if (Auth::attempt($credentials))
				{
					$alert = array(
						'estatus' => 'success',
						'mensaje' => 'Welcome'
					);
					\DB::commit();

					\Log::info('Success', $alert);

					return redirect()->route('view_admin')
					->with('alert', $alert)
					->withInput();
				}

				$alert = array(
					'mensaje' => 'There is no user with that data',
					'estatus' => 'warning',
				);

				\Log::info('Error', $alert);

				return redirect()->back()
				->with('alert', $alert)
				->withInput();
			
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

}