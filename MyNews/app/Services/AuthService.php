<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService 
{   
    /**
     *  registration
     *
     * @param 
     * @return 
     */
    public static function postSigUp($data,$request)
    {
        $data['password'] = bcrypt($data['password']);
        User::create($data);

        if (!Auth::attempt($request->only(['email', 'password']), $request->has('remember'))) {
            return redirect()->back();
        }
        
       return $data;
    }

    /**
     *  authorization
     *
     * @param \Illuminate\Http\Request
     * @return 
     */
   public static function  postSigin($request)
    {
        if (!Auth::attempt($request->only(['email','password']),$request->has('remember')))
         return true;
        
       return false;
    }
   
   
}
