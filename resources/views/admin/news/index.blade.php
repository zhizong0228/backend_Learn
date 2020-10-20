@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin">後臺</a></li>
        <li class="breadcrumb-item active" aria-current="page">最新消息管理</li>
    </ol>
</nav>

<a href="/admin/news/create" class="btn btn-success mb-3">新增最新消息</a>

<table id="example" class="table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>標題</th>
            <th>圖片</th>
            <th>副標題</th>
            <th>created_at</th>
            <th width="80">功能</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($news_list as $news)
            <tr>
                <td>{{$news->title}}</td>
                <td>
                    <img width="200" src="{{$news->image_url}}" alt="">
                </td>
                <td>{{$news->sub_title}}</td>
                <td>{{$news->created_at}}</td>
                <td>
                    <a href="/admin/news/edit/{{$news->id}}" class="btn btn-sm btn-primary">編輯</a>
                    <button class="btn btn-danger btn-sm btn-delete" data-newsid="{{$news->id}}">刪除</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{--  --}}

@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $("#example").on("click", ".btn-delete", function(){
                var news_id = this.dataset.newsid;

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    // Swal.fire(
                    // 'Deleted!',
                    // 'Your file has been deleted.',
                    // 'success'
                    // )
                    window.location.href = `/admin/news/destroy/${news_id}`;

                    }
                })
            });
        });
    </script>
@endsection
