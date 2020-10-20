<?php

namespace App\Http\Controllers;

use App\ProductImg;
use Illuminate\Http\Request;
use App\Products;
use App\ProductType;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
        // 關聯
        // $news_list = Products::with('product_type')->find(1);
        // with()抓取跟此筆資料有關係的其他資料表的資料,括弧中寫Model裡定義的函式名稱

        // Q:為什麼要做關聯? A:每次搜尋資料,需要不斷的進出資料庫,對伺服器的負擔會很大,讀取時間也會越久


        // 無關聯的寫法(需要進入資料庫兩次做搜尋,負擔較大)
        $news_list = Products::all(); //all() 抓所有的資料,資料型態=陣列

        // $news_list = Products::where('id','=','1')->get(); //取得所有符合條件的資料,資料型態=陣列
        // $news_list = Products::where('id','=','1')->first(); //符合條件的第一筆資料,資料型態=物件
        // $news_list = Products::find(1); //尋找指定id的資料,資料型態=物件

        // $type = ProductType::where('id','=',$news_list->type_id)->get();

        // foreach($news_list as $list){
        //     dd($list->type_id);
        // }

        return view('admin.product.index',compact('news_list'));
    }

    public function create()
    {
        $product_types = ProductType::all();
        return view('admin.product.create',compact('product_types'));
    }

    public function store(Request $request)
    {

        $requestData = $request->all();

        // 第一種檔案上傳方式 file storage
        //
        // //檔案上傳並取得圖片名稱
        // $file_name = $request->file('image_url')->store('','public');
        // $requestData['image_url'] = $file_name;

        // 第二種檔案上傳方式 move
        if($request->hasFile('product_image')) {
            $file = $request->file('product_image');
            $path = $this->fileUpload($file,'product');
            $requestData['product_image'] = $path;
        }


        $product = Products::create($requestData);
        //取得剛剛建立資料的ID
        $product_id = $product->id;

        //多圖上傳
        if($request->hasFile('multiple_images')) {
            $files = $request->file('multiple_images');
            foreach( $files as $file){
                $path = $this->fileUpload($file,'product');
                ProductImg::create([
                    'img_url' => $path,
                    'product_id' => $product_id,
                ]);
            }
        }

        return redirect('/admin/product');
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
        $product = Products::find($id);
        $product_types = ProductType::all();
        $productImgs = ProductImg::orderBy('sort','desc')->get();

        return view('admin.product.edit',compact('product','product_types','productImgs'));
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
        $product = Products::find($id);
        $requestData = $request->all();

        //判斷 是否有上傳圖片
        if($request->hasFile('product_image')) {
             //刪除舊有圖片
            $old_image = $product->product_image;
            File::delete(public_path().$old_image);

            //上傳新的圖片
            $file = $request->file('product_image');
            $path = $this->fileUpload($file,'product');

            //將新圖片的路徑，放入requestData中
            $requestData['product_image'] = $path;
        }

        $product->update($requestData);

        return redirect('/admin/product');
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
        $product = Products::find($id);
        $old_image = $product->product_image;
        File::delete(public_path().$old_image);

        //刪除資料庫資料
        Products::destroy($id);

        return redirect('/admin/product');
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
