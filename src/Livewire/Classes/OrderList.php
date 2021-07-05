<?php

namespace App\Http\Livewire;

use Livewire\Component;

class OrderList extends Cart
{
    public function decrement($product_id)
    {
        $product_count = session('products')[$product_id]['count'];
        if($product_count > 1){
            if($product_count <= 1){
                $this->emit('removeProduct', $product_id);
            }
            else{
                $product_count--;
                session('products')[$product_id]['count'] = $product_count;
                $this->emit('updateCart');
            }
        }
    }
    
    public function render()
    {
        return view('livewire.order-list');
    }
}
