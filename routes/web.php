<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\TheLoai;
Route::get('/', function () {
    return view('welcome');
});

Route::get('admin/dangnhap','UserController@getDangNhapAdmin');
Route::post('admin/dangnhap','UserController@postDangNhapAdmin');

Route::get('admin/dangxuat','UserController@getDangXuatAdmin');

Route::group(['prefix'=>'admin','middleware'=>'adminLogin'],function (){
   Route::group(['prefix'=>'theloai'],function (){
       Route::get('danhsach','TheLoaiController@getDanhsach');

       Route::get('sua/{id}','TheLoaiController@getSua');
       Route::post('sua/{id}','TheLoaiController@postSua');

       Route::get('them','TheLoaiController@getThem');
       Route::post('them','TheLoaiController@postThem');

       Route::get('xoa/{id}','TheLoaiController@getXoa');
   });
    Route::group(['prefix'=>'loaitin'],function (){
        Route::get('danhsach','LoaiTinController@getDanhsach');

        Route::get('sua/{id}','LoaiTinController@getSua');
        Route::post('sua/{id}','LoaiTinController@postSua');

        Route::get('them','LoaiTinController@getThem');
        Route::post('them','LoaiTinController@postThem');

        Route::get('xoa/{id}','LoaiTinController@getXoa');
    });
    Route::group(['prefix'=>'tintuc'],function (){
        Route::get('danhsach','TinTucController@getDanhsach');

        Route::get('sua/{id}','TinTucController@getSua');
        Route::post('sua/{id}','TinTucController@postSua');

        Route::get('them','TinTucController@getThem');
        Route::post('them','TinTucController@postThem');

        Route::get('xoa/{id}','TinTucController@getXoa');
    });
    Route::group(['prefix'=>'comment'],function (){

        Route::get('xoa/{id}/{idTinTuc}','CommentController@getXoa');
    });

    Route::group(['prefix'=>'slide'],function (){
        Route::get('danhsach','SlideController@getDanhsach');

        Route::get('sua/{id}','SlideController@getSua');
        Route::post('sua/{id}','SlideController@postSua');

        Route::get('them','SlideController@getThem');
        Route::post('them','SlideController@postThem');

        Route::get('xoa/{id}','SlideController@getXoa');
    });

    Route::group(['prefix'=>'user'],function (){
        Route::get('danhsach','UserController@getDanhsach');

        Route::get('sua/{id}','UserController@getSua');
        Route::post('sua/{id}','UserController@postSua');

        Route::get('them','UserController@getThem');
        Route::post('them','UserController@postThem');

        Route::get('xoa/{id}','UserController@getXoa');
    });
    Route::group(['prefix'=>'ajax'],function (){
        Route::get('loaitin/{idTheLoai}','AjaxController@getLoaiTin');
    });
});
Route::get('danhsach','TheLoaiController@getDanhsach');
Auth::routes();

Route::get('trangchu','PagesController@trangchu');
Route::get('lienhe','PagesController@lienhe');
Route::get('loaitin/{id}/{TenKhongDau}.html','PagesController@loaitin');
Route::get('tintuc/{id}/{TenKhongDau}.html','PagesController@tintuc');

Route::get('dangnhap','PagesController@getDangnhap');
Route::post('dangnhap','PagesController@postDangnhap');

Route::get('dangxuat','PagesController@getDangxuat');

Route::post('comment/{id}','CommentController@postComment');

Route::get('nguoidung/{id}','PagesController@getNguoidung');
Route::post('nguoidung/{id}','PagesController@postNguoiDung');

Route::get('dangki','PagesController@getDangki');
Route::post('dangki','PagesController@postDangki');

Route::post('timkiem','PagesController@postTimkiem');