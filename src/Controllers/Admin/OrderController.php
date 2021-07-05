<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Screens\OrderScreen;
use App\Models\Adfm\Catalog\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
        OrderScreen::index();
    }

    public function store(Request $request)
    {
        $order = new Order();

        $order_content = $request->all()['fields'];
        $order_content['cart']['products'] = session('products');
        $order->fill($order_content)->save();
        session()->forget('products');

        \Illuminate\Support\Facades\Mail::send('adfm::email.order-feedback', ['order' => $order], function($message)
        {
            $message->from('info@mail-robot.wtolk.ru', 'Почтовый робот');
            $message->to('blwoalf@wtolk.ru')->subject('Заказ');
        });
        
        return redirect()->route('adfm.success.ordering');
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
