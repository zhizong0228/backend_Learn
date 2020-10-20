@extends('layouts/nav_footer')

@section('css')
    <link rel="stylesheet" href="/css/news.css">
@endsection

@section('content')

    <section class="news">
        <div class="container">
            <div>
                <ul>
                    @foreach ($product_types  as $product_type)
                        <li>
                            <a href="/product_type/{{$product_type->id}}">{{$product_type->type_name}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <h2 class="news_title">秘境好康</h2>
            <div class="news_lists">
                @foreach ($product_types  as $product_type)
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
                @endforeach
            </div>
        </div>
    </section>
@endsection
