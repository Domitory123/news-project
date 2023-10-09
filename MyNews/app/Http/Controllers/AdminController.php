<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegistrationRequest;
use App\Services\AuthService; 
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminController extends Controller
{
      /**
     * 
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $News = News::orderBy('created_at', 'desc')->paginate(2);

        return view('admin/index',compact('News'));
        //return redirect()->route('index');
    }


}
