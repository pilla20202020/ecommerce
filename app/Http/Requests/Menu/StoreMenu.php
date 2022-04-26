<?php

namespace App\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Menu\Menu;
use App\Models\Page\Page;
use App\Models\Menu\SubMenu;

class StoreMenu extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
//            'page' => 'required'
        ];
    }

    /**
     * @return array
     */
    public function subMenuFillData()
    {
        $page = Page::whereSlug($this->get('page'))->first();

        $first_sub_menu_order = $this->menu->subMenus->sortByDesc('order')->first();

            $inputs = [
                'menu_id' => $this->menu->id,
                'name' => $this->get('name') ? $this->get('name') : $page->title,
                'url' => isset($page) ? $page->slug : ($this->get('custom_url') ? $this->get('custom_url') : '#'),
                'order' => $first_sub_menu_order ? $first_sub_menu_order->order + 1 : 0,
            ];

      
        return $inputs;
    }

    /**
     * @return array
     */
    public function childsubMenuFillData()
    {
        $page = Page::whereSlug($this->get('page'))->first();
        // if ($page == null) {
        //     $page = timeline::whereSlug($this->get('page'))->first();
        //     if ($page == null) {
        //         $page = event::whereSlug($this->get('page'))->first();
        //     }
        // }

        $first_child_sub_menu_order = $this->subMenu->childsubMenus->sortBydesc('order')->first();

        $input = [
            'sub_menu_id' => $this->subMenu->id,
            'name' => $this->get('name') ? $this->get('name') : $page->title,
//            'name_np'           => $this->get('name_np') ? $this->get('name_np') : $page->title_np,
            'url' => isset($page) ? $page->slug : ($this->get('custom_url') ? $this->get('custom_url') : '#'),
            'order' => $first_child_sub_menu_order ? $first_child_sub_menu_order->order + 1 : 0,
            'is_published' => ($this->get('is_published') ? $this->get('is_published') : '') == 'on' ? '1' : '0',
            'is_featured' => ($this->get('is_featured') ? $this->get('is_featured') : '') == 'on' ? '1' : '0'
        ];

        return $input;
    }

    /**
     * @return array
     */
    public function menuFillData()
    {
        $page = Page::whereSlug($this->get('page'))->first();
        // if ($page == null) {
        //     $page = timeline::whereSlug($this->get('page'))->first();
        //     if($page == null){
        //         $page = event::whereSlug($this->get('page'))->first();
        //     }
        // }

        $inputs = [
            'name' => $this->get('name') ? $this->get('name') : $page->title,
//            'name_np'    => $this->get('name_np') ? $this->get('name_np') : $page->title_np,
//            'url'        => route('page.show', $page->slug) ,
            'url' => isset($page) ? $page->slug : ($this->get('custom_url') ? $this->get('custom_url') : '#'),

            // 'order' => Menu::orderBy('order', 'desc')->first()->order + 1,
        ];

        return $inputs;
    }
}
