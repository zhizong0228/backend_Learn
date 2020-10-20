<?php

namespace App\Http\Controllers;

use App\News;
use App\Place;
use App\Products;
use App\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    public function index()
    {
        // 1. 用陣列帶物件的方式
        // $users = DB::table('users')->get();
        // $news_list = DB::table('news')->orderBy('id','desc')->take(3)->get();
        // return view('front/index',['news_list' => $news_list , 'users' => $users]);

        //2. compact
        $users = News::all();
        $news_list = News::orderBy('id','desc')->take(3)->get();

        return view('front.index',compact('news_list','users'));
    }

    public function news()
    {
        // $news_list = DB::table('news')->orderBy('id','desc')->simplePaginate(6);
        $news_list = News::orderBy('id','desc')->simplePaginate(6);
        return view('front.news',compact('news_list'));
    }

    public function news_info($news_id)
    {
        // dd($news_id);
        //取得特定的某一筆news
        $news = News::where('id','=',$news_id)->first();
        return view('front.news_info',compact('news'));
    }

    public function contact_us()
    {
        return view('front.contact_us');
    }

    public function store_contact(Request $request)
    {
        //取得由前端來的資料

        // $email = $request->input('email');
        // $email = $request->email;

        //存放進資料庫
        // DB::table('place')->insert(
        //     ['email' => $request->email,
        //     'location' => $request->location,
        //     'image_url' => '',
        //     'place_name' => $request->place_name,
        //     'info' => $request->info]
        // );

        //ORM 基本新增
        // $new_place = new Place();
        // $new_place->email = $request->email;
        // $new_place->location = $request->location;
        // $new_place->image_url = '';
        // $new_place->place_name = $request->place_name;
        // $new_place->info = $request->info;
        // $new_place->save();

        //ORM　create - #mass-assignment(批量賦值) + request->all();
        Place::create($request->all());

        return '成功新增';
    }

    public function product_type($product_type_id)
    {
        $product_type = ProductType::find($product_type_id);
        return view('front.product_type',compact('product_type'));
    }

    public function product()
    {
        $product_types = ProductType::with('products')->get();
        return view('front.product',compact('product_types'));
    }

    public function product_detail($product_id)
    {
        //取得到特定一筆商品內容
        $product = Products::find($product_id);
        return view('front.product_detail',compact('product'));
    }
}
