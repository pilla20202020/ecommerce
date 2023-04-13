<?php

namespace App\Models\Product;

use App\Models\Category\Category;
use Illuminate\Database\Eloquent\Model;
use App\Models\Brand\Brand;
use App\Models\SubCategory\SubCategory;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model
{

use Sluggable;

    protected $path ='uploads/product';

    public function sluggable(): array{
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    protected $fillable = ['id', 'title', 'slug', 'category_id', 'subcategory_id', 'brand_id','keywords','description', 'specification','price','is_featured','is_trending','status','best_seller', 'image1', 'image2', 'image',
    'banner_image','stock'];

    protected $casts = [
        'is_trending' => 'boolean',
        'is_featured' => 'boolean',
        'status' => 'boolean',
        'best_seller' => 'boolean',
    ];

    protected $appends = [
        'thumbnail_path', 'image_path', 'banner_path',  'image_path1', 'image_path2'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeFeatured($query, $type = true)
    {
        return $query->where('is_featured', $type);
    }

    public function scopeTrending($query, $type = true)
    {
        return $query->where('is_trending', $type);
    }

    public function scopeStatus($query, $type = true)
    {
        return $query->where('status', $type);
    }
    public function scopeBestseller($query, $type = true)
    {
        return $query->where('best_seller', $type);
    }


    function getImagePathAttribute()
    {
        return $this->path . '/' . $this->image;
    }

    function getBannerPathAttribute()
    {

        return $this->path . '/' . $this->banner_image;
    }

    function getImagePath1Attribute(){
        return $this->path.'/'. $this->image1;
    }

    function getImagePath2Attribute(){
        return $this->path.'/'. $this->image2;
    }

    function getThumbnailPathAttribute(){
        return $this->path.'/thumb/'. $this->image1;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }



}
