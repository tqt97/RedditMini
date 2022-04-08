<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class Community extends Model
{
    use HasFactory, SoftDeletes, Sluggable;

    protected $fillable = ['user_id', 'name', 'description', 'slug'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function topics()
    {
        return $this->belongsToMany(Topic::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
