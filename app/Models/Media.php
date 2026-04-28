<?php

namespace App\Models;

use App\Http\Requests\MediaFormRequest;
use App\Http\Resources\BaseResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'path', 'name', 'mime_type', 'disk', 'extension', 'size', 'user_id'
    ];

    protected $appends = [
        'url'
    ];

    /**
     * Get the api resource.
     *
     * @return string
     */
    protected static function getApiResourceClass(): string
    {
        return BaseResource::class;
    }

    /**
     * Get the api resource.
     *
     * @return string
     */
    protected static function getFormRequestClass(): string
    {
        return MediaFormRequest::class;
    }

    /**
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return string
     */
    public function getUrlAttribute()
    {
        if ($this->disk == 's3') {
            return 'https://'.config('services.aws_bucket').'.s3.amazonaws.com/'.$this->path;
        }

        // Handle both 'public' disk and 'local' disk
        if ($this->disk == 'public' || $this->disk == 'local') {
            return asset('storage/' . $this->path);
        }

        // Fallback for other disks
        return '/storage/'.$this->path;
    }
}
