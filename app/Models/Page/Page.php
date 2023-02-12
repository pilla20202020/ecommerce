<?php

namespace App\Models\Page;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use Sluggable;

    protected $path = 'uploads/page';
    protected $banner_path = 'uploads/banner_image';

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'title',
        'meta_description',
        'content',
        'image',
        'banner_image',
        'url',
        'view',
        'is_featured',
        'is_published',
    ];


    protected $appends = [
        'thumbnail_path', 'image_path', 'banner_path'
    ];
    /**
     * The attributes that should be typecast into boolean.
     *
     * @var array
     */
    protected $casts = [
        'is_published' => 'boolean'
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Set the title attribute and the slug.
     *
     * @param string $value
     */
//    public function setTitleAttribute($value)
//    {
//        $this->attributes['title'] = $value;
//
//        if ( ! $this->exists)
//        {
//            $this->setUniqueSlug($value, '');
//        }
//    }

    /**
     * Recursive routine to set a unique slug.
     *
     * @param string $title
     * @param mixed $extra
     */
//    protected function setUniqueSlug($title, $extra)
//    {
//        $slug = Str::slug($title . '-' . $extra);
//
//        if (static::whereSlug($slug)->exists())
//        {
//            $this->setUniqueSlug($title, $extra + 1);
//
//            return;
//        }
//
//        $this->attributes['slug'] = $slug;
//    }


//    public function setTitleNpAttribute($value)
//    {
//        $this->attributes['title_np'] = $value;
//
//        if ( ! $this->exists)
//        {
//            $this->setUniqueSlugNp($value, '');
//        }
//    }
//
//    /**
//     * Recursive routine to set a unique slug.
//     *
//     * @param string $title
//     * @param mixed $extra
//     */
//    protected function setUniqueSlugNp($titlenp, $extra)
//    {
//        $slug = Str::slug($titlenp . '-' . $extra);
//
//        if (static::whereSlug($slug)->exists())
//        {
//            $this->setUniqueSlugNp($titlenp, $extra + 1);
//
//            return;
//        }
//
//        $this->attributes['slug_np'] = $slug;
//    }

    /**
     * @param $query
     * @param bool $type
     * @return mixed
     */
    public function scopePublished($query, $type = true)
    {
        return $query->where('is_published', $type);
    }

    /**
     * @param $query
     * @param bool $type
     * @return mixed
     */
    public function scopePrimary($query, $type = true)
    {
        return $query->where('is_primary', $type);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
//    public function image()
//    {
//        return $this->morphOne(Image::class, 'imageable');
//    }
//
//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
//     */
//    public function banner()
//    {
//        return $this->morphOne(Banner::class, 'bannerable');
//    }

    /**
     * @param array $options
     * @return bool|null|void
     * @throws \Exception
     */
//    public function delete(array $options = array())
//    {
//        if ($this->image)
//            $this->image->delete();
//
//        /** @noinspection PhpMethodParametersCountMismatchInspection */
//        return parent::delete($options);
//    }

    function getImagePathAttribute()
    {
        return $this->path . '/' . $this->image;
    }

    function getThumbnailPathAttribute()
    {
        return $this->path . '/thumb/' . $this->image;
    }

    function getBannerPathAttribute()
    {
        if ($this->banner_image) {
            return $this->banner_path . '/' . $this->banner_image;
        } else {
            return 'assets/images/reliance/Background.jpg';
        }
    }
}

