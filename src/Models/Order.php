<?php

namespace App\Models\Adfm\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Adfm\Traits\Sluggable;

class Order extends Model
{
    use HasFactory;
    use Sluggable;

    protected $casts = [
        'cart' => 'array',
    ];

    protected $fillable = [
        'client_name',
        'phone',
        'address',
        'note',
        'cart'
    ];

    public function setCartAttribute($cart)
    {
        // $cart['products'] = session('products');
        $summ = 0;
        foreach($cart['products'] as $product){
            $summ+=$product['price'];
        }
        $cart['summ'] = $summ;
        $this->attributes['cart'] = json_encode($cart);
    }
    
}
