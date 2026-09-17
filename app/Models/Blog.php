<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'author', 'content', 'image'
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

    public function destinations()
    {
        return $this->belongsToMany(Destination::class, 'blog_destination', 'blog_id', 'destination_id');
    }
}
