@extends('layouts.app')

@section('css')

@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin">後臺</a></li>
        <li class="breadcrumb-item"><a href="/admin/news">最新消息管理</a></li>
        <li class="breadcrumb-item active" aria-current="page">新增</li>
    </ol>
</nav>

<form method="POST" action="/admin/news/store" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="title">
            標題
            <small class="text-danger">(限制至多20字)</small>
        </label>
        <input type="text" class="form-control" id="title" name="title" required>
    </div>
    <div class="form-group">
        <label for="sub_title">副標題</label>
        <input type="text" class="form-control" id="sub_title" name="sub_title" required>
    </div>
    <div class="form-group">
        <label for="image_url">
            上傳主要圖片
            <small class="text-danger">(建議圖片寬高比例為4:3)</small>
        </label>
        <input type="file" class="form-control-file" id="image_url" name="image_url" required>
    </div>
    <div class="form-group">
        <label for="content">內容</label>
        <textarea class="form-control" id="content" rows="3" name="content" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">新增</button>
</form>
@endsection

@section('js')

@endsection
