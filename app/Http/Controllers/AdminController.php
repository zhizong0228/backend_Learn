<?php

namespace App\Http\Controllers;

use App\ProductImg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function ajax_upload_img()
    {
        // A list of permitted file extensions
        $allowed = array('png', 'jpg', 'gif', 'zip');

        if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
            $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            if (!in_array(strtolower($extension), $allowed)) {
                echo '{"status":"error"}';
                exit;
            }
            $name = strval(time() . md5(rand(100, 200)));
            $ext = explode('.', $_FILES['file']['name']);
            $filename = $name . '.' . $ext[1];

            //防呆：資料夾不存在時將會自動建立資料夾，避免錯誤
            if (!is_dir('upload/')) {
                mkdir('upload/');
            }
            //防呆：資料夾不存在時將會自動建立資料夾，避免錯誤
            if (!is_dir('upload/img')) {
                mkdir('upload/img');
            }
            $destination = public_path() . '/upload/img/' . $filename; //change this directory
            $location = $_FILES["file"]["tmp_name"];
            move_uploaded_file($location, $destination);
            echo "/upload/img/" . $filename; //change this URL
        }
        exit;
    }

    public function ajax_delete_img(Request $request){
        if(file_exists(public_path().$request->file_link)){
            File::delete(public_path().$request->file_link);
        }
    }

    public function ajax_delete_multi_img(Request $request){
        // 從編輯頁面傳進來的圖片id
        $img_id = $request->id;

        // 尋找資料庫
        $product_imgs = ProductImg::find($img_id);

        // 刪除
        $product_imgs->delete();

        return 'success';
    }

    public function ajax_sort_multi_img(Request $request){
        // 從編輯頁面傳進來的圖片id
        $img_id = $request->id;
        // 排序的數值
        $img_sort = $request->value;

        // 尋找資料庫
        $product_imgs = ProductImg::find($img_id);

        // 儲存數值進資料
        $product_imgs->sort = $img_sort;

        // 儲存已修改的資料
        $product_imgs->save();

        return 'success';
    }
}
