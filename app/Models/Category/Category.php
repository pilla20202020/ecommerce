<?php

namespace App\Models\Category;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Sluggable;

    protected $path ='uploads/category';

    public function sluggable(){
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }



    protected $fillable = [
        'slug',
        'title',
        'meta_description',
        'image',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $appends = [
        'thumbnail_path', 'image_path'
    ];

    function getImagePathAttribute(){
        return $this->path.'/'. $this->image;
    }

    function getThumbnailPathAttribute(){
        return $this->path.'/thumb/'. $this->image;
    }
}
