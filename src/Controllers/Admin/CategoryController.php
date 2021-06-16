<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Screens\CategoryScreen;
use Illuminate\Http\Request;
use App\Models\Adfm\Catalog\Category;

class CategoryController extends Controller
{

    public function index()
    {
        CategoryScreen::index();
    }

    public function create()
    {
        CategoryScreen::create();
    }

    /**
     * Создание
     */
    public function store(Request $request)
    {
        $item = new Category();
        $item->fill($request->all()['category'])->save();
        return redirect()->route('adfm.categories.index');
    }

    /**
     * Форма редактирования
     */
    public function edit($id)
    {
        CategoryScreen::edit();
    }

    /**
     * Обновление
     */
    public function update(Request $request, $id)
    {
        $item = Category::findOrFail($id);
        $item->fill($request->all()['category'])->save();
        return redirect()->route('adfm.categories.index');
    }

    /**
     * Удаляем в корзину
     */
    public function destroy($id)
    {
        Category::destroy($id);
        return redirect()->route('adfm.categories.index');
    }
}
