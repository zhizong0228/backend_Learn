@extends('layouts/nav_footer')

@section('css')
    <link rel="stylesheet" href="./css/news_info.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
@endsection

@section('content')
    <section class="news_info">
        <div class="container" style="margin-top: 60px">
            <h2 class="info_title"> {{$product->name}}</h2>
            <div class="row">
                <div class="col-12 my-3 my-md-0 col-md-6">
                    <div class="image_box h-100">
                        <a href=" {{$product->product_image}}" data-lightbox="image-1" data-title="My caption">
                            <img width="100%" src=" {{$product->product_image}}" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-12 my-3 my-md-0 col-md-6">
                    <div>商品類別: {{$product->product_type->type_name}}</div>
                    <div>price:  {{$product->price}}</div>
                    <div class="info_content">
                        {!! $product->info !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
@endsection
