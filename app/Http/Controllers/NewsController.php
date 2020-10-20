<?php

namespace App\Http\Controllers;

use App\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news_list = News::all();
        return view('admin.news.index',compact('news_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestData = $request->all();

        // 第一種檔案上傳方式 file storage
        //
        // //檔案上傳並取得圖片名稱
        // $file_name = $request->file('image_url')->store('','public');
        // $requestData['image_url'] = $file_name;

        // 第二種檔案上傳方式 move
        if($request->hasFile('image_url')) {
            $file = $request->file('image_url');
            $path = $this->fileUpload($file,'news');
            $requestData['image_url'] = $path;
        }
        News::create($requestData);

        return redirect('/admin/news');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //取得特定一筆資料
        // $news = News::where('id','=',$id)->first();
        $news = News::find($id);

        return view('admin.news.edit',compact('news'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $news = News::find($id);
        $requestData = $request->all();

        //判斷 是否有上傳圖片
        if($request->hasFile('image_url')) {
             //刪除舊有圖片
            $old_image = $news->image_url;
            File::delete(public_path().$old_image);

            //上傳新的圖片
            $file = $request->file('image_url');
            $path = $this->fileUpload($file,'news');

            //將新圖片的路徑，放入requestData中
            $requestData['image_url'] = $path;
        }

        $news->update($requestData);

        return redirect('/admin/news');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //刪除舊有的圖片
        $news = News::find($id);
        $old_image = $news->image_url;
        File::delete(public_path().$old_image);

        //刪除資料庫資料
        News::destroy($id);

        return redirect('/admin/news');
    }

    private function fileUpload($file,$dir){
        //防呆：資料夾不存在時將會自動建立資料夾，避免錯誤
        if( ! is_dir('upload/')){
            mkdir('upload/');
        }
        //防呆：資料夾不存在時將會自動建立資料夾，避免錯誤
        if ( ! is_dir('upload/'.$dir)) {
            mkdir('upload/'.$dir);
        }

        //取得檔案的副檔名
        $extension = $file->getClientOriginalExtension();
        //檔案名稱會被重新命名
        $filename = strval(time().md5(rand(100, 200))).'.'.$extension;
        //移動到指定路徑
        move_uploaded_file($file, public_path().'/upload/'.$dir.'/'.$filename);
        //回傳 資料庫儲存用的路徑格式
        return '/upload/'.$dir.'/'.$filename;
    }
}
