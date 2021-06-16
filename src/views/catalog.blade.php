@extends('adfm::public.layout')
{{-- @section('meta-title', $catalog->title) --}}

@section('content')
<section class="section section_page section__catalog">
    <div class="container">
        <div class="section__header">
            <h1 class="h1-header h1-header-page">Продукция</h1>
        </div>
        <div class="secton__content">
            <div class="row">
                @foreach ($catalog as $product)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="product">
                        <div class="product__info">
                            <div class="product__name">{{$product->title}}</div>
                            <div class="product__price">{{$product->price}} руб.</div>
                            <a href="{{route('adfm.show.product', $product)}}"><button class="button product__button">Подробнее</button></a>
                        </div>
                        <div class="product__image">
                            @if (count($product->files) > 0)
                                {!! ImageCache::get($product->files[0], ['w' => 157, 'h' => 190, 'fit' => 'crop']); !!}
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection