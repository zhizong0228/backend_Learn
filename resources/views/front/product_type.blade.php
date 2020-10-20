@extends('layouts/nav_footer')

@section('css')
    <link rel="stylesheet" href="/css/news.css">
@endsection

@section('content')

    <section class="news">
        <div class="container">
            <h2 class="news_title">秘境好康</h2>
            <div class="news_lists">
                <div class="mb-3">
                    <h1>{{$product_type->type_name}}</h1>
                     <div class="row">
                         @foreach ($product_type->products as $product)
                             <div class="col-md-4">
                                 <div class="news_list">
                                     <h3>{{$product->name}}</h3>
                                 <a class="btn btn-primary" href="/product/{{$product->id}}">查看更多</a>
                                 </div>
                             </div>
                         @endforeach
                     </div>
                </div>
            </div>
        </div>
    </section>
@endsection
