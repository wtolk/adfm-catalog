<?php

namespace App\Models\Adfm\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Adfm\Traits\AttachmentTrait;
use App\Models\Adfm\Traits\Sluggable;
use App\Models\Adfm\File;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Sluggable;
    use AttachmentTrait;

    protected $casts = [
        'meta' => 'array',
    ];

    protected $fillable = [
        'title',
        'slug',
        'price',
        'content',
        'article',
        'meta'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable')
            ->where('model_relation', '=', 'files')->orderBy('sort');
    }
}
