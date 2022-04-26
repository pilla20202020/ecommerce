<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\StoreMenu;
use Illuminate\Http\Request;
use App\Models\Menu\Menu;
use App\Models\Page\Page;
use App\Models\Menu\SubMenu;

class MenuController extends Controller
{
    protected $menu;

    /**
     * @return \Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        $menus = Menu::with('subMenus')->orderBy('order')->get();

        $model1 = Page::published()->primary(false)->get();

        $pages = collect($model1);

        return view('backend.menu.index', compact('menus', 'pages'));
    }


    /**
     * @param StoreMenu $request
     * @return mixed
     */
    public function store(StoreMenu $request)
    {
        $menu = Menu::create($request->menuFillData());

        return back()->withSuccess(trans('messages.create_success', ['entity' => 'Menu']))->with('collapse_in', $menu->id);
    }

    /**
     * @param StoreMenu $request
     * @param Menu $menu
     * @return mixed
     */
    public function storeSubMenu(StoreMenu $request, Menu $menu)
    {
        SubMenu::create($request->subMenuFillData());

        return back()->withSuccess(trans('messages.create_success', ['entity' => 'Sub Menu']))->with('collapse_in', $menu->id);
    }

    /**
     * @param StoreMenu $request
     * @param Menu $menu
     * @return mixed
     */
    // public function storeChildSubMenu(StoreMenu $request, SubMenu $subMenu)
    // {
    //     ChildSubMenu::create($request-> childsubMenuFillData($subMenu));

    //     return back()->withSuccess(trans('message.create_success', ['entity' => 'Child Sub Menu']))->with('collapse_in', $subMenu->id);
    // }


    /**
     * @param Request $request
     * @return mixed
     */
    public function update(Request $request)
    {
        foreach ($request->get('order') as $order => $menuId)
        {
            $menu = Menu::find($menuId);

            $menu->update(['order' => $order]);
        }

        if ($request->has('sub_menu_order'))
        {
            foreach ($request->get('sub_menu_order') as $menuId => $subMenuOrder)
            {
                foreach ($subMenuOrder as $order => $subMenuId)
                {
                    $subMenu = SubMenu::find($subMenuId);

                    $subMenu->update(['order' => $order]);
                }
            }
        }

        // if ($request->has('child_sub_menu_order'))
        // {
        //     foreach ($request->get('child_sub_menu_order') as $subMenuOrder => $childsubMenuOrder )
        //     {
        //         foreach ($childsubMenuOrder as $order => $childsubMenuId)
        //         {
        //             $childsubMenu = ChildSubMenu::find($childsubMenuId);

        //             $childsubMenu->update(['order' => $order]);
        //         }
        //     }
        // }

        return back()->withSuccess(trans('messages.update_success', ['entity' => 'Menu Order']));
    }

    /**
     * @param Menu $menu
     * @return \Illuminate\View\View
     */
    public function subMenuModal(Menu $menu)
    {
        $model1 = Page::published()->primary(false)->get();

        $model3 = Menu::published()->get();

        $collect = collect($model1);

        $pages = $collect->merge($model3);

        return view('backend.menu.partials.subMenuModal', compact('menu', 'pages'));
    }

    /**
     * @param Menu $menu
     * @return \Illuminate\View\View
     */
    // public function childsubMenuModal(SubMenu $subMenu)
    // {

    //     $model1 = Page::published()->primary(false)->get();

    //     $model3 = Menu::published()->get();

    //     $collect = collect($model1);

    //     $pages = $collect->merge($model3);

    //     return view('backend.menu.partials.childsubMenuModal', compact('subMenu', 'pages'));
    // }

    /**
     * @param Menu $menu
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Menu $menu)
    {
        if ($menu->delete())
        {
            return response()->json([
                'Result' => 'OK',
                'Menu'   => true
            ]);
        }

        return response()->json([
            'Result' => 'Error'
        ], 500);
    }

    /**
     * @param Menu $menu
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroySubMenu(Menu $menu, SubMenu $subMenu)
    {
        if ($subMenu->delete())
        {
            return response()->json([
                'Result' => 'OK',
                'Menu'   => false,
                'SubMenu' => true
            ]);
        }

        return response()->json([
            'Result' => 'Error'
        ], 500);
    }

    /**
     * @param Menu $menu
     * @return \Illuminate\Http\JsonResponse
     */
    // public function destroyChildSubMenu(Menu $menu, SubMenu $subMenu,ChildSubMenu $childSubMenu)
    // {
    //     if ($childSubMenu->delete())
    //     {
    //         return response()->json([
    //             'Result' => 'OK',
    //             'SubMenu'   => false,
    //             'Menu'   => false,
    //             'ChildSubMenu' => true
    //         ]);
    //     }

    //     return response()->json([
    //         'Result'    => 'Error'
    //     ], 500);
    // }
}
