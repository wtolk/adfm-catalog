<section class="section section_page section_no-bottom-space">
    <div class="container">
        <div class="section__header">
            <h1 class="h1-header h1-header-page">{{$product->title}}</h1>
        </div>
        <div class="section__content">
            <div class="row">
                <div class="col-12 col-md-7 col-xl-6">
                    <div class="prod-p__image">
                        @if (count($product->files) > 0)
                            {!! ImageCache::get($product->files[0], ['w' => 630, 'h' => 414, 'fit' => 'crop']); !!}
                        @endif
                    </div>
                </div>
                <div class="col-12 col-md-5">
                    <div class="prod-p__descr">
                        {!! $product->content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>