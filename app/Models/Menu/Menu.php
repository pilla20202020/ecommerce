<?php

namespace App\Models\Menu;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Str;
use App\Models\Menu\SubMenu;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use Sluggable;

    public function sluggable(): array{
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['slug', 'name', 'name_np', 'url', 'icon', 'order',  'is_featured',
    'is_published',];

    /**
     * Set the name attribute and the slug.
     *
     * @param string $value
     */
//    public function setNameAttribute($value)
//    {
//        $this->attributes['name'] = $value;
//
//        if ( ! $this->exists)
//        {
//            $this->setUniqueSlug($value, '');
//        }
//    }

    /**
     * Recursive routine to set a unique slug.
     *
     * @param string $name
     * @param mixed $extra
     */
//    protected function setUniqueSlug($name, $extra)
//    {
//        $slug = Str::slug($name . '-' . $extra);
//
//        if (static::whereSlug($slug)->exists())
//        {
//            $this->setUniqueSlug($name, $extra + 1);
//
//            return back()->withSuccess(trans('messages.create_success', ['entity' => 'Menu']))->with('collapse_in', $name);;
//        }
//
//        $this->attributes['slug'] = $slug;
//    }

//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
//     */
//    public function image()
//    {
//        return $this->morphOne('App\Models\Image', 'imageable');
//    }
//
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
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
    public function scopeFeatured($query, $type = true)
    {
        return $query->where('is_featured', $type);
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

    public function subMenus()
    {
        return $this->hasMany(SubMenu::class)->with('childsubMenus');
    }

    public function delete(array $options = array())
    {
        if ($this->image)
            $this->image->delete();

        /** @noinspection PhpMethodParametersCountMismatchInspection */
        return parent::delete($options);
    }
}
