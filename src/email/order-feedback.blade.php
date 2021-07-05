<div>Имя клиента: {{$order->client_name}}</div><br>
<div>Телефон: {{$order->phone}}</div><br>
<div>Адрес: {{$order->address}}</div><br>
<div>Примечание: {{$order->note}}</div><br>
<div>Список товаров:<br>
    <table>
        <tr>
            <th>Наименованте</th>
            <th>Цена</th>
            <th>Количество</th>
            <th>Сумма</th>
        </tr>
        @foreach ($order->cart['products'] as $product)
        <tr>
            <td>{{$product['title']}}</td>
            <td>{{$product['price']}}</td>
            <td>{{$product['count']}}</td>
            <td>{{$product['price'] * $product['count']}}</td>
        </tr>
        @endforeach
    </table>
</div><br>
<div>Общаяя сумма заказа: {{$order->cart['summ']}}</div>
