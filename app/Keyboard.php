<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Cviebrock\EloquentSluggable\Sluggable;


class Keyboard extends Authenticatable
{
    use Notifiable;
    use Sluggable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'keyboards';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'image_feature', 'image_thumbnail', 'image', 'desc_short', 'desc_long'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    /**
     * Keyboard belongs to User
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Keyboard belongs to Feature
     */
    public function feature()
    {
        return $this->belongsTo('App\KeyboardFeature');
    }

    /**
     * Keyboard has many Images
     */
    public function images()
    {
        return $this->hasMany('App\KeyboardImage');
    }

    /**
     * Keyboard has many Votes
     */
    public function votes()
    {
        return $this->hasMany('App\KeyboardVote');
    }

    /**
     * Get Keyboard Feature Image
     */
    public function getFeatureImage()
    {
        foreach($this->images as $image){
            if($image->feature == true){
                return $image->path;
            }
        }
        return null;
    }

    /**
     * Get Keyboard vote count
     */
    public function getVoteCount()
    {
        $negative = $this->votes()->where([['negative', true], ['positive', false]])->count();
        $positive = $this->votes()->where([['negative', false], ['positive', true]])->count();
        return (int) $positive - $negative;
    }
}
