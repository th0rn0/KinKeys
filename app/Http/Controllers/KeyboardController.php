<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\Keyboard;
use App\KeyboardImage;

use Session;
use Auth;

class KeyboardController extends Controller
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
        $keyboards = Keyboard::all()->sortBy(function($keyboard)
        {
            return (int) (
                $keyboard->votes()->where([['negative', true], ['positive', false]])->count()
                - 
                $keyboard->votes()->where([['negative', false], ['positive', true]])->count()
            );
        });
        return view('keyboards.index')->with('keyboards', $keyboards);
    }

    /**
     * Show the create keyboard form.
     *
     * @var \Illuminate\Http\Response
     */
    public function create()
    {
        return view('keyboards.create');
    }

    /**
     * Show the edit keyboard form.
     *
     * @var \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $keyboard = Keyboard::where('slug', $slug)->first();
        if(Auth::id() != $keyboard->user_id){
            return Redirect::to('keyboards/' . $keyboard->slug);
        }
        return view('keyboards.edit')->with('keyboard', $keyboard);
    }

    
    /**
     * Store the Keyboard.
     * 
     * @param  Request $request->name
     * @param  Request $request->desc_short
     * @param  Request $request->desc_long
     * 
     * @return [type]
     */
    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'We need to know the name of your keyboard!',
            'name.unique' => 'Keyboard name must be unique!',
            'desc_short.required' => 'We need a short description about your keyboard!',
            'desc_long.required' => 'We need a description about your keyboard!',

        ];

        $this->validate($request, [
            'name' => 'required|unique:keyboards|max:255',
            'desc_short' => 'required',
            'desc_long' => 'required',
            'images.*' => 'image|mimes:jpg,jpeg,bmp,png',
        ], $messages);


        $keyboard = new Keyboard;
        $keyboard->name = $request->name;
        $keyboard->desc_short = $request->desc_short;
        $keyboard->desc_long = $request->desc_long;
        $keyboard->user_id = auth()->user()->id;

        $keyboard->save();

        $image_feature = true;
        foreach($request->images as $image){
            $keyboard->images()->create([
                'path'      => str_replace(
                    'public/', '', $image->store(
                        'public/images/' . $this->slugify(auth()->user()->name) . '/' . $keyboard->slug
                        )
                    ),
                'feature'   => $image_feature,
            ]);
            $image_feature = false;
        }

        Session::flash('message', 'Successfully submitted keyboard!');
        return Redirect::to('keyboards/' . $keyboard->slug);
    }

    public function show($slug)
    {
        $keyboard = Keyboard::where('slug', $slug)->first();
        return view('keyboards.show')->with('keyboard', $keyboard);
    }

    public function update(Request $request, $slug)
    {
        $keyboard = Keyboard::where('slug', $slug)->first();

        $messages = [
            'name.required' => 'We need to know the name of your keyboard!',
            'name.unique' => 'Keyboard name must be unique!',
            'desc_short.required' => 'We need a short description about your keyboard!',
            'desc_long.required' => 'We need a description about your keyboard!',

        ];
        $rules = [
            'name' => 'required|max:255',
            'desc_short' => 'required',
            'desc_long' => 'required',
        ];

        $this->validate($request, $rules, $messages);

        $keyboard->slug = null;
        $keyboard->name = $request->name;
        $keyboard->desc_short = $request->desc_short;
        $keyboard->desc_long = $request->desc_long;

        $keyboard->save();

        foreach($request->images as $image_id => $image_details){
            $image = $keyboard->images()->where('id', $image_id)->first();
            $image->name = $image_details['name'];
            $image->desc = $image_details['desc'];
            $image->save();
        }

        Session::flash('message', 'Successfully saved keyboard!');
        return Redirect::to('keyboards/' . $keyboard->slug);
    }

    public function vote(Request $request, $slug)
    {
        $messages = [
            'vote.required' => 'A Vote must be cast',
            'vote.in' => 'A Vote must be either Up or Down',
        ];

        $this->validate($request, [
            'vote' => 'required|in:up,down'
        ], $messages);

        $vote_up = false;
        $vote_down = false;
        if($request->vote == 'up'){
            $vote_up = true;
        }
        if($request->vote == 'down'){
            $vote_down = true;
        }

        $keyboard = Keyboard::where('slug', $slug)->first();

        // Check for same vote
        $vote = $keyboard->votes()->where([
            ['user_id', Auth::id()],
            ['positive', $vote_up],
            ['negative', $vote_down]
        ])->first();

        if($vote != null){
            Session::flash('message', 'You have already case a {{ $request->vote }} vote!');
            return Redirect::to('keyboards/');
        }

        // Check for opposite vote
        $vote = $keyboard->votes()->where([
            ['user_id', Auth::id()],
            ['positive', $vote_down],
            ['negative', $vote_up]
        ])->first();

        if($vote != null){
            Session::flash('message', 'Successfully case vote!');
            $vote->delete();
            return Redirect::to('keyboards/' . $keyboard->slug);
        }

        // No vote present
        $keyboard->votes()->create([
            'user_id'   => Auth::id(),
            'positive'  => $vote_up,
            'negative'  => $vote_down,
        ]);
        Session::flash('message', 'Successfully case vote!');
        return Redirect::to('keyboards/' . $keyboard->slug);
    }






    public function slugify($text)
    {
      // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        return $text;
    }
}
