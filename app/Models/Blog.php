<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'author', 'content', 'image'
    ];

    public function destinations()
    {
        return $this->belongsToMany(Destination::class, 'blog_destination', 'blog_id', 'destination_id');
    }
}
