@extends('layouts.app')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<style>
    .imgs {
        display:inline-block;
        position: relative;
    }

    .cancel_btn {
        position: absolute;
        right: -15px;
        top: -15px;
        z-index: 10;

        padding:9px 15px;
        background:red;
        color:white;
        border-radius: 50%;
    }

</style>
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin">後臺</a></li>
        <li class="breadcrumb-item"><a href="/admin/product">商品管理</a></li>
        <li class="breadcrumb-item active" aria-current="page">編輯</li>
    </ol>
</nav>

<form method="POST" action="/admin/product/update/{{$product->id}}" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="product_type_id">
            商品類別
        </label>
        <select class="form-control" name="product_type_id" id="product_type_id">
            @foreach ($product_types as $product_type)
            {{-- 把舊資料套進下拉式選單 --}}
            <option value="{{$product_type->id}}" @if($product_type->id == $product->product_type_id) selected
                @endif>{{$product_type->type_name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="name">
            商品名稱
            <small class="text-danger">(限制至多20字)</small>
        </label>
        <input type="text" class="form-control" id="name" name="name" value="{{$product->name}}" required>
    </div>
    <div class="form-group">
        <label for="price">price</label>
        <input type="text" class="form-control" id="price" name="price" value="{{$product->price}}" required>
    </div>
    <div class="form-group">
        <label for="product_image">
            更新主要圖片
            <small class="text-danger">(建議圖片寬高比例為4:3)</small>
        </label>
        <input type="file" class="form-control-file" id="product_image" name="product_image">
    </div>
    <div>
        <label for="product_image">
            內頁多張圖片 (建議圖片寬高比例為4:3)
            <small class="text-danger">(建議圖片寬高比例為4:3)</small>
        </label>
        <div class="form-group">
            @foreach ($productImgs as $productImg)
            <div class="imgs">
                <div class="cancel_btn" data-id="{{$productImg->id}}">X</div>
                <img height="200" src="{{$productImg->img_url}}" alt="">
                <div class="form-group">
                    <input class="form-control img_sort"  type="number" data-id="{{$productImg->id}}" value="{{$productImg->sort}}">
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="form-group">
        <label for="info">內容</label>
        <textarea class="form-control" id="info" rows="3" name="info" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">編輯</button>
</form>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/lang/summernote-zh-TW.min.js"></script>

<script>
    $(document).ready(function() {
        $('#info').summernote({
            height: 150,
            lang: 'zh-TW',
            callbacks: {
                onImageUpload: function(files) {
                    for(let i=0; i < files.length; i++) {
                        $.upload(files[i]);
                    }
                },
                onMediaDelete : function(target) {
                    $.delete(target[0].getAttribute("src"));
                }
            },
        });

        $.upload = function (file) {
            let out = new FormData();
            out.append('file', file, file.name);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                method: 'POST',
                url: '/admin/ajax_upload_img',
                contentType: false,
                cache: false,
                processData: false,
                data: out,
                success: function (img) {
                    $('#info').summernote('insertImage', img);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error(textStatus + " " + errorThrown);
                }
            });
        };

        $.delete = function (file_link) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                method: 'POST',
                url: '/admin/ajax_delete_img',
                data: {file_link:file_link},
                success: function (img) {
                    console.log("delete:",img);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error(textStatus + " " + errorThrown);
                }
            });
        };


        $('.cancel_btn').click(function(){
            var img_id = $(this).data('id');


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                method: 'POST',
                url: '/admin/ajax_delete_multi_img',
                data: {'id':img_id},
                success: function (img) {
                    $(`.cancel_btn[data-id=${img_id}]`).parent().addClass('d-none')
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error(textStatus + " " + errorThrown);
                }
            });
        })

        $('.img_sort').change(function(){
            var img_id = $(this).data('id'); //抓圖片id
            var value = $(this).val(); //抓input的值

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                method: 'POST',
                url: '/admin/ajax_sort_multi_img',
                data: {
                    'id':img_id,
                    'value':value,
                },
                success: function (img) {

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error(textStatus + " " + errorThrown);
                }
            });
        })

    });
</script>

@endsection
