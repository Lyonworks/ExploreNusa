<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Destination extends Model {
    use HasFactory;

    protected $fillable = ['name','slug','location','description','facilities','image'];

    protected $casts = [
        'facilities' => 'array',
    ];

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        $path = parse_url($this->image, PHP_URL_PATH) ?: $this->image;
        $bucket = trim((string) config('filesystems.disks.s3.bucket'), '/');
        $dashboardPrefix = "/storage/files/buckets/{$bucket}/";

        if ($bucket !== '' && Str::contains($path, $dashboardPrefix)) {
            $objectPath = Str::after($path, $dashboardPrefix);

            return rtrim((string) config('filesystems.disks.s3.url'), '/') . '/' . ltrim($objectPath, '/');
        }

        return filter_var($this->image, FILTER_VALIDATE_URL)
            ? $this->image
            : Storage::disk('public')->url($this->image);
    }

    public function reviews() 
    {
        return $this->hasMany(Review::class);
    }

    public function getAverageRatingAttribute() 
    {
        return $this->reviews()->avg('rating');
    }

    protected static function booted() 
    {
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
