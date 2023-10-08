<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegistrationRequest;
use App\Services\AuthService; 
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
      /**
     * registration
     *
     * @param  App\Http\Requests\RegistrationRequest
     * @return \Illuminate\Http\Response
     */
    public function postSigUp(RegistrationRequest $request)
    { 
        $data = $request->validated();
        AuthService::postSigUp($data,$request);

        return redirect()->route('index');
    }

    /**
     * authorization
     *
     * @param  App\Http\Requests\AuthRequest
     * @return \Illuminate\Http\Response
     */
    public function postSigin(AuthRequest $request)
    {
        $request->validated();

        if (AuthService::postSigin($request)) {
            return redirect()->back()->withInput($request->only('email'))->withErrors([
                'email' => 'Неправильна електронна адреса або пароль',]); 
        }
        
        return redirect()->route('index');
    }

    /**
     * authorization page
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function getSigin()
    {
        return view('user/login');
    }

    public function logout()
    {
       
        Auth::logout();
        return redirect()->route('index');
    }
   
   /**
     * registration page
     *
     * @param 
     * @return \Illuminate\Http\Response
     */
    public function getSigUp()
    {
        return view('user/registration');
    }
}
