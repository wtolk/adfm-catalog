<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Screens\OrderScreen;
use App\Models\Adfm\Order;
use Illuminate\Http\Request;
use App\Models\Adfm\Page;

class OrderController extends Controller
{

    public function index()
    {
        OrderScreen::index();
    }

    public function show($id)
    {
        OrderScreen::show();
    }

    public function destroy($id)
    {
       Order::destroy($id);
       return redirect()->route('adfm.orders.index');
    }
}
