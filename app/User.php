<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * User has many Keyboards
     */
    public function keyboards()
    {
        return $this->hasMany('App\Keyboard');
    }

    /**
     * User has many Votes
     */
    public function votes()
    {
        return $this->hasMany('App\KeyboardVotes');
    }
}
