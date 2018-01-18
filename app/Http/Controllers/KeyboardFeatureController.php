<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\Keyboard;
use App\KeyboardImage;
use App\KeyboardFeature;

use Session;
use Auth;

class KeyboardFeatureController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the keyboard dashboard.
     *
     * @var \Illuminate\Http\Response
     */
    public function index()
    {
        $keyboards = KeyboardFeature::all();
        return view('features.index')->with('keyboards', $keyboards);
    }

}
