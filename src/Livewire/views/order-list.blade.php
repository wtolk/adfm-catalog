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
    <div class="order__cost">
        <span>Итого: {{$cost}} Руб.</span>
    </div>
    <div class="order__submit-button">
        <button type="submit" class="button">Оформить заказ</button>
    </div>
    @else
    <div class="cart__empty">
        <span>Корзина пуста</span>
    </div>
    @endif
</div>
