{{-- Tile di un prodotto, da includere con @include Genera UNA mattonella per ogni nuovo prodotto--}}

<div class="w3-col l3 s3" style="text-align: center;">
    <div class="w3-container">
        <div class="w3-display-container">
            <img src="{{ asset('images/product/'.$product->imagepath) }}" alt="{{ $product->name }}" height="200">
            <div class="w3-display-middle w3-display-hover">
                <a style="background-color: #09aaf7 !important" class="w3-button w3-black" href="{{ $link }}">Show more</a>
            </div>
        </div>
        <p>{{ str_limit($product->name, $limit = 28, $end = '...') }}<br><b>{{ $product->price }} €</b></p>
    </div>
</div>