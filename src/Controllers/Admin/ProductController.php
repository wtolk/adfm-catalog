<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Adfm\Dev;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Screens\ProductScreen;
use Illuminate\Http\Request;
use App\Models\Adfm\Catalog\Product;
use Illuminate\Support\Facades\Artisan;

class ProductController extends Controller
{

    public function index()
    {
        ProductScreen::index();
    }

    public function create()
    {
        ProductScreen::create();
    }

    /**
     * Создание
     */
    public function store(Request $request)
    {
        $item = new Product();
        $item->fill($request->all()['product'])->save();
        return redirect()->route('adfm.products.index');
    }

    /**
     * Форма редактирования
     */
    public function edit($id)
    {
        ProductScreen::edit();
    }

    /**
     * Обновление
     */
    public function update(Request $request, $id)
    {
        $item = Product::findOrFail($id);
        $item->fill($request->all()['product'])->save();
        return redirect()->route('adfm.products.index');
    }

    /**
     * Удаляем в корзину
     */
    public function destroy($id)
    {
        Product::destroy($id);
        return redirect()->route('adfm.products.index');
    }
}
