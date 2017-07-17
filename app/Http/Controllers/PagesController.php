<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
use App\Slide;
use App\LoaiTin;
use App\Tintuc;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    //
    function __construct()
    {
        $theloai = TheLoai::all();
        $slide = Slide::all();
        view()->share('theloai',$theloai);
        view()->share('slide',$slide);

        if(Auth::check())
        {
            $user = Auth::users();
            view()->share('nguoidung',$user);
        }
    }
    function trangchu(){
        return view('pages.trangchu');
    }
    function lienhe(){
        return view('pages.lienhe');
    }
    function loaitin($id){
        $loaitin = LoaiTin::find($id);
        $tintuc = TinTuc::where('idLoaiTin',$id)->paginate(5);
        return view('pages.loaitin',['loaitin'=>$loaitin,'tintuc'=>$tintuc]);
    }
    function  tintuc($id)
    {
        $tintuc = Tintuc::find($id);
        $tinnoibat = TinTuc::where('NoiBat',1)->take(4)->get();
        $tinlienquan = TinTuc::where('idLoaiTin',$tintuc->idLoaiTin)->take(4)->get();
        return view('pages.tintuc',['tintuc'=>$tintuc,'tinnoibat'=>$tinnoibat,'tinlienquan'=>$tinlienquan]);
    }

    function getDangnhap()
    {
        return view('pages.dangnhap');
    }
    function postDangnhap(Request $request)
    {
        $this->validate($request,
            [
                'email' => 'required|email',
                'password' => 'required|min:3|max:32',
            ],
            [

                'email.required' => 'Chưa nhập email',
                'email.email' => 'Email chưa đúng',
                'password.required' => 'Chưa nhập password',
                'password.min' => 'Password phải có 3-32 kí tự',
                'password.max' => 'Password phải có 3-32 kí tự',
            ]);
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password]))
        {
            return redirect('trangchu')->with('thongbao','Chào bạn !');
        }else
        {
            return redirect('dangnhap')->with('thongbao','Đăng nhập không thành công');
        }
    }
}
