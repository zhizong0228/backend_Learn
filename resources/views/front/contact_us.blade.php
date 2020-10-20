@extends('layouts/nav_footer')

@section('css')
    <link rel="stylesheet" href="./css/contact.css">
@endsection

@section('content')
    <section class="contact">
        <div class="container">
            <h2>好康道相報 - 推薦景點</h2>
            <div class="contact_description">
                說明文字說明文字說明文字說明文字說明文字說明文字說明文字說明文字說明文字說明文字說明文字說明文字說明文字說明文字說明文字說明文字說明文字說明文字說明文字說明文字說明文字說明文字說明文字說明文字說明文字說明文字說明文字說明文字說明文字說明文字說明文字說明文字說明文字
                <ol>
                    <li>注意事項</li>
                    <li>注意事項</li>
                    <li>注意事項</li>
                    <li>注意事項</li>
                    <li>注意事項</li>
                </ol>
            </div>
            <form method="POST" action="/store_contact" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="exampleInputEmail1">您的信箱</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
                    <small id="emailHelp" class="form-text text-muted">當景點入選時會通知您，並不會另作他用</small>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect2">您推薦的景點位置</label>
                    <select class="form-control" id="exampleFormControlSelect2" name="location">
                        <option value="北台灣">北台灣</option>
                        <option value="中台灣">中台灣</option>
                        <option value="南臺灣">南臺灣</option>
                        <option value="東台灣">東台灣</option>
                        <option value="離島">離島</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlFile1">上傳照片</label>
                    <input type="file" class="form-control-file" id="exampleFormControlFile1" name="file">
                </div>
                <div class="form-group">
                    <label for="exampleInput">景點名稱</label>
                    <input type="text" class="form-control" id="exampleInput" aria-describedby="title" name="place_name">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">景點詳述</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="info"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">送出審查</button>
            </form>
        </div>
    </section>
@endsection

