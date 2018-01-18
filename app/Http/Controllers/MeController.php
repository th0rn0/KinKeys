<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\Keyboard;
use Session;
use Auth;

class MeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the keyboard dashboard.
     *
     * @var \Illuminate\Http\Response
     */
    public function index()
    {
        $keyboards = keyboard::where('user_id', Auth::id())->get();
        return view('me.index')->with('keyboards', $keyboards);
    }

}
