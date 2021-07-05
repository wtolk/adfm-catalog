<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AddToCartButton extends Component
{
    protected $listeners = ['getProductCount'];

    public $product_id;
    public $product_count;

    public function getProductCount()
    {
        $this->product_count = 0;
        if(session('products') != null){
            foreach(session('products') as $key => $product){
                if($product['id'] == $this->product_id){
                    $this->product_count = $product['count'];
                }
            }
        }
    }
    
    public function mount($productid)
    {
        $this->product_id = $productid;
        $this->getProductCount();
    }
    
    public function render()
    {
        return <<<'blade'
            <div wire:click="$emitTo('cart', 'addProduct', {{$this->product_id}})" class="add-cart add-basket" data-id="{{$this->product_id}}">
                @if($this->product_count > 0)
                <i class="fas fa-cart-plus"></i> <span class="add-basket__text">В корзину ({{$this->product_count}})</span>
                @else
                <i class="fas fa-cart-arrow-down"></i> <span class="add-basket__text">В корзину</span>
                @endif
            </div>
        blade;
    }
}
