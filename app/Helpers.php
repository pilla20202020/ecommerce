<?php

use App\Models\Service;
use App\Models\ColocationComponent;
use App\Models\CoLocationOrder;
use App\Models\CoLocationRenewal;
use App\Models\Country;
use App\Models\Customer;
use App\Models\CustomOrder;
use App\Models\CustomRenewal;
use App\Models\DomainOrder;
use App\Models\DomainRenewal;
use App\Models\EmailComponent;
use App\Models\EmailOrder;
use App\Models\EmailProvision;
use App\Models\EmailRenewal;
use App\Models\EndpointSecurityOrder;
use App\Models\EndpointSecurityRenewal;
use App\Models\Ip;
use App\Models\LicenseOrder;
use App\Models\LicenseRenewal;
use App\Models\Menu\Menu;
use App\Models\Order;
use App\Models\Page\Page;
use App\Models\Branch;
use App\Models\Gallery\Gallery;
use App\Models\Rate;
use App\Models\Receipt;
use App\Models\ServiceUpdate;
use App\Models\Setting\Setting;
use App\Models\SslOrder;
use App\Models\SslRenewal;
use App\Models\User;
use App\Models\VpsComponent;
use App\Models\VpsOrder;
use App\Models\VpsProvision;
use App\Models\VpsRenewal;
use App\Models\WebComponent;
use App\Models\WebOrder;
use App\Models\WebProvision;
use App\Models\WebRenewal;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

/**
 * @param $value
 * @param string $dash
 * @return string
 */
function display($value, $dash = 'NA')
{
    if (empty($value))
    {
        return $dash;
    }

    return $value;
}

/**
 * @param $width
 * @param null $username
 * @return mixed
 * @internal param $guard
 */
function user_avatar($width, $username = null)
{
    if ($username)
    {
        $user = \App\Models\User::whereUsername($username)->first();
    }
    else
    {
        $user = auth()->user();
    }

    if ($image = $user->image)
    {
        return asset($image->thumbnail($width, $width));
    }
    else
    {
        return asset(config('paths.placeholder.avatar'));
    }
}

/**
 * @param $width
 * @param null $entity
 * @return mixed
 */
function thumbnail($width, $entity = null)
{
    if ( ! is_null($entity))
    {
        if ($image = $entity->image)
        {
            return asset($image->thumbnail($width, $width));
        }
    }

    return asset(config('paths.placeholder.default'));
}

/**
 * @param $query
 * @return mixed
 */
function setting($query)
{
    $setting = Setting::fetch($query)->first();

    return $setting ? $setting->value : null;
}

/**
 * @param $id
 * @return mixed
 */
function getUserName($id)
{
    $user = User::find($id)->name;

    return $user;
}

/* Collection of menu items */
function menus()
{
    return Menu::orderBy('order','ASC')->get();
}

function services()
{
    $services = Service::whereIsPublished(1)
        ->limit(7)
        ->get();
    return $services;

}

function footermenu()
{
    $menu = Menu::where('is_primary', 0)
        ->limit(5)
        ->get();
    return $menu;
}

function footer()
{
    $footer = Page::where('slug','about-us')->get();
    return $footer;
}

function cover()
{
    $cover = Gallery::where('view', 'Cover')->where('is_published', 1)->orderBy('id', 'DESC')->get();
    return $cover;
}

function member()
{
    $member = Branch::where('is_published', 1)->get();
    return $member;
}

