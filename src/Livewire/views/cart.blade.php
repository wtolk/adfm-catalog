<div class="cart @if($isopen) show @endif ">
    <div class="cart-mini @if (count($products)>0) show-mini @endif" wire:click="$emit('open')">
        <i class="fas fa-shopping-cart"></i>
        <span class="cart__count">{{count($products)}}</span>
    </div>
    <div class="cart__container">
        <div class="cart__header">
            <span>Корзина</span>
            <i class="fas fa-times cart__button-close" wire:click="$emit('close')"></i>
        </div>
        <div class="cart__body">
            <div class="cart__list">
                @if (count($products)>0)
                @php(uasort($products, function ($item1, $item2) {
                    return $item2['position'] <=> $item1['position'];
                }))
                @foreach ($products as $key => $product)
                <div class="cart__item">
                    <div class="item__image">
                        @if (isset($product['img_url']))
                        <img src="{{$product['img_url']}}">
                        @endif
                    </div>
                    <div class="item__info">
                        <div class="item__name">{{$product['title']}}</div>
                        <div class="item__price">{{$product['price']}} руб.</div>
                        <div class="item__price item__price_total">Сумма: {{$product['price'] * $product['count']}} руб.</div>
                    </div>
                    <div class="item__controls">
                        <div wire:click="$emit('removeProduct', {{$key}})" class="item__remove" data-id="{{$key}}">
                            <i class="fas fa-times"></i>
                        </div>
                        <div class="item__counter">
                            <div class="counter__name">Количество</div>
                            <div class="counter__group">
                                <div wire:click="$emit('decrement', {{$key}})" class="counter__button counter__button_prepend">
                                    <span>-</span>
                                </div>
                                <input readonly="readonly" name="count" class="counter__input" value="{{$product['count']}}">
                                <div wire:click="$emit('increment', {{$key}})" class="counter__button counter__button_append">
                                    <span>+</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="cart__empty">
                    <span>Корзина пуста</span>
                </div>
                @endif                
            </div>
        </div>
        <div class="cart__footer">
            @if (count($products)>0)
            <a href="{{route('adfm.show.ordering')}}" class="cart__button button">
                <span>Оформить заказ</span>
                @if ($cost>0)
                    <div class="cart__cost">{{$cost}} Руб.</div>
                @endif
            </a>
            @endif
        </div>
    </div>
</div>
