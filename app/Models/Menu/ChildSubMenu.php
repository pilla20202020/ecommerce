<?php

namespace App\Models\Menu;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class ChildSubMenu extends Model
{use Sluggable;

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
    protected $fillable = [
        'slug',
        'sub_menu_id',
        'name',
        'url',
        'order',
        'icon'
    ];
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
//            return;
//        }
//
//        $this->attributes['slug'] = $slug;
//    }

    public function subMenus()
    {
        return $this->belongsTo(SubMenu::class);
    }

    public function delete(array $options = array())
    {
        if ($this->image)
            $this->image->delete();

        /** @noinspection PhpMethodParametersCountMismatchInspection */
        return parent::delete($options);
    }
}

