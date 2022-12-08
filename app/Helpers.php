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

function getTableHtml($object, $type, $editRoute = null, $deleteRoute = null, $printRoute = null, $viewRoute = null,$checklist = null,$billRoute = null, $invoiceRoute = null)
{
    switch ($type) {
        case 'actions':
            return view('backend.general.table-actions', compact('editRoute','deleteRoute','viewRoute','printRoute','checklist','billRoute','invoiceRoute'));
            break;

        case 'availability':
            return '<span class="badge-boxed' . getLabel($object->availability) . '">' . $object->availability_text . '</span>';
            break;
        case 'visibility':
            return '<span class="badge-boxed' . getLabel($object->visibility) . '">' . $object->visibility_text . '</span>';
            break;
        case 'status':
            return '<span class="badge-boxed' . getLabel($object->status) . '">' . $object->status_text . '</span>';
            break;
        case 'is_main':
            return '<span class="badge-boxed' . getLabel($object->is_main) . '">' . $object->main_text . '</span>';
            break;
        case 'is_default':
            return '<span class="badge-boxed' . getLabel($object->is_default) . '">' . $object->main_text . '</span>';
            break;
        case 'image':
            return view('general.lightbox', compact('object'));
            break;
    }
}


function getLabel($status)
{
    $badge = '';
    switch ($status) {
        case 'yes':
            $badge = 'badge-primary';
            break;

        case 'no':
            $badge = 'badge-danger';
            break;
        case 'available':
            $badge = 'badge-success';
            break;

        case 'not_available':
            $badge = 'badge-danger';
            break;
        case 'visible':
            $badge = 'badge-success';
            break;
        case 'in-visible':
            $badge = 'badge-success';
            break;

        case 'active':
            $badge = 'badge-primary';
            break;
        case 'inactive':
            $badge = 'badge-danger';
            break;
    }

    return $badge;
}

