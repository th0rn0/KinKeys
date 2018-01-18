<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Cviebrock\EloquentSluggable\Sluggable;


class KeyboardVote extends Authenticatable
{
    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'keyboard_votes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'keyboard_id', 'user_id', 'positive', 'negative'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * Vote belongs to Keyboard
     */
    public function keyboard()
    {
        return $this->belongsTo('App\Keyboard');
    }

    /**
     * Vote belongs to User
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
