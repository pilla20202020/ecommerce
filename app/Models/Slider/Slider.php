<?php

namespace App\Models\Slider;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $path ='uploads/slider';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['title', 'caption', 'link_url','image', 'link_caption','is_published'];

    protected $appends = [
        'thumbnail_path', 'image_path'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
//    public function image()
//    {
//        return $this->morphOne(Image::class, 'imageable');
//    }

    /**
     * @param $query
     * @return mixed
     */

    public function scopePublished($query)
    {
        return $query->where('is_published', 1);
    }

//    public function delete(array $options = array())
//    {
//        if ($this->image)
//            $this->image->delete();
//
//        /** @noinspection PhpMethodParametersCountMismatchInspection */
//        return parent::delete($options);
//    }

    function getImagePathAttribute(){
        return $this->path.'/'. $this->image;
    }

    function getThumbnailPathAttribute(){
        return $this->path.'/thumb/'. $this->image;
    }
}
