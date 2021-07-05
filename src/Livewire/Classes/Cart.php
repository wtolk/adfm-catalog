<?php

namespace App\Http\Livewire;

use Barryvdh\Debugbar\Facade;
use Livewire\Component;
use App\Models\Adfm\Catalog\Product;

class Cart extends Component
{
    protected $listeners = ['addProduct', 'removeProduct', 'updateCart', 'open', 'close', 'increment', 'decrement'];

    public $isopen = false;
    public $products = [];
    public $cost;

    public function open()
    {
        $this->isopen = true;
    }

    public function close()
    {
        $this->isopen = false;
    }

    public function addProduct($product_id)
    {
        $session_products = [];

        if(session('products') != null){
            foreach(session('products') as $key => $product) {
                $session_products[$key] = $product;
            }
        }

        if (isset($session_products[$product_id])) {
            $session_products[$product_id]['count'] = $session_products[$product_id]['count']+1;
        } else {
            $session_products[$product_id] = Product::find($product_id);
            $session_products[$product_id]['count'] = 1;
            $session_products[$product_id]['position'] = count($session_products)+1;
            if(count($session_products[$product_id]->files) > 0){
                $session_products[$product_id]['img_url'] = \ImageCache::get($session_products[$product_id]->files[0], ['w' => 90, 'h' => 90, 'fit' => 'crop'])->url;
            }
            unset($session_products[$product_id]['files']);
        }

        session()->put('products', $session_products);
        $this->emitSelf('updateCart');

    }

    public function removeProduct($product_id)
    {
        $products = session()->pull('products', []);
        unset($products[$product_id]);

        $products = $this->setProductPosition($products);
        
        session()->put('products', $products);
        $this->emit('updateCart');
    }

    public function increment($product_id)
    {
        $product_count = session('products')[$product_id]['count'];
        $product_count++;
        session('products')[$product_id]['count'] = $product_count;
        $this->emit('updateCart');
    }

    public function decrement($product_id)
    {
        $product_count = session('products')[$product_id]['count'];
        if($product_count <= 1){
            $this->emit('removeProduct', $product_id);
        }
        else{
            $product_count--;
            session('products')[$product_id]['count'] = $product_count;
            $this->emit('updateCart');
        }
    }

    public function updateCart()
    {
        $this->products = session('products');
        $this->calculateCost();
        $this->emitTo('add-to-cart-button', 'getProductCount');
    }

    public function calculateCost()
    {
        $this->cost = 0;
        if(session('products')){
            foreach(session('products') as $product){
                $this->cost+= $product['price'] * $product['count'];
            }
        }
    }

    public function getCost(){
        $this->calculateCost();
        return $this->cost;
    }

    public function setProductPosition($products)
    {
        $positions_products = [];
        $positon = 1;
        foreach($products as $key => $product){
            $product['position'] = $positon;
            $positions_products[$key] = $product;
            $positon++;
        }
        return $positions_products;
    }

    public function mount()
    {
        if(session('products')){
            $this->products = session('products');
            $this->calculateCost();
        }
    }

    public function render()
    {
        if(url()->current() != route('adfm.show.ordering')){
            return view('livewire.cart');
        }
        else{
            return '';   
        }
    }
}
