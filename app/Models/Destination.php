<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Destination extends Model {
    use HasFactory;

    protected $fillable = ['name','slug','location','description','image'];

    public function facilities() {
        return $this->hasMany(Facility::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function getAverageRatingAttribute() {
        return $this->reviews()->avg('rating');
    }

    protected static function booted() {
        static::creating(function($model){
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
        static::updating(function($model){
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'blog_destination', 'destination_id', 'blog_id');
    }
}
