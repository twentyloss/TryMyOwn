<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        Auth::user()->markAsRead();
      $notifications=Auth::user()->notifications()->paginate(20);
      return view('notifications.index',compact('notifications'));
    }
}