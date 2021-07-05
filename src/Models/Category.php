<?php

namespace App\Models\Adfm\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Adfm\Traits\Sluggable;
use Illuminate\Support\Facades\URL;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Sluggable;

    protected $fillable = [
        'title',
        'slug',
        'parent_id',
        'description',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function getLinkAttribute($value)
    {
        $url = new URL();
        $r = $url->getFacadeRoot()->getRequest();
        return $r->getScheme().'://'.$r->getHost().'/catalog/category/'.$this->slug;
    }

    public static function getData()
    {
        $uri = request()->getPathInfo();
        $links = Category::get();
        $tree = [];
        foreach ($links as $link) {
            if ($uri == '/'.$link['link']) {
                $link['status'] = 'active';
            }
            $tree[$link['parent_id']][] = $link;
        }
        return $tree;
    }
}
