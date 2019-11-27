{{-- Tile di un prodotto, da includere con @include
    Genera UNA mattonella per ogni nuovo prodotto
    --}}
    <div class="card mb-3" style="max-width: 12rem; min-width: 12rem; center">
        <div class="card-img-top" style="height:200px">
            <a href="{{ $link }}">
                <img class="card-img-top" src="{{ asset('images/product/'.$product->imagepath) }}" alt="{{ $product->name }}"
                    height="200">
            </a>
        </div>
        <div class="card-body">
            <div class="card-title">
                <a href="{{ $link }}">
                    <h5 class="card-title">
                        {!! nl2br(e($product->name)) !!}
                    </h5>
                </a>
            </div>
            <p class="card-text">
                {{ $product->price }} €
            </p>
        </div>
    </div>