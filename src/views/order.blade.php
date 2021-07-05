@section('meta-title', 'какой-то загловок')

@section('content')
<div class="section_order">
    <form class="form" method="POST" action="{{route('adfm.order.store')}}">
        <div class="order__form">
            @csrf
            <div class="field"><label>Имя<input type="text" name="fields[client_name]" required="required"></label></div>
            <div class="field"><label>Номер телефона<input type="tel" name="fields[phone]" required="required"></label></div>
            <div class="field"><label>Адрес доставки<input type="text" name="fields[address]" required="required"></label></div>
            <div class="field"><label>Примечание<textarea name="fields[note]"></textarea></label></div>
        </div>
        <div class="order__cart">
            <livewire:order-list />
        </div>
    </form>
</div>
@endsection
