<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TrendingTour extends Model {
    protected $fillable = ['title','image','destination_id'];
    public function destination() {
        return $this->belongsTo(Destination::class);
    }
}