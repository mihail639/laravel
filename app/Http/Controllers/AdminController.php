<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
class AdminController extends Controller{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('isAdmin');
    }
   /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
   public function index()
   {
       dd( Auth::guard('admin')->user());
   }
}
