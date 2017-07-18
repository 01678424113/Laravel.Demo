<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
use App\Slide;
use App\LoaiTin;
use App\Tintuc;
use App\User;
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
            $user = Auth::user();
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
    function getDangxuat()
    {
        Auth::logout();
        return redirect('trangchu');
    }

    function getNguoidung($id)
    {
        $nd = Auth::user();
        return view('pages.nguoidung',['nd'=>$nd]);
    }
    function postNguoidung(){

    }

    public function getDangki()
    {
        return view('pages.dangki');
    }

    public function postDangki(Request $request)
    {
        $this->validate($request,
            [
                'name' => 'required|min:3|max:30',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:3|max:32',
                'passwordAgain' => 'required|same:password'
            ],
            [
                'name.required' => 'Chưa nhập tên User',
                'name.min' => 'Tên phải 3-30 kí tự',
                'name.max' => 'Tên phải 3-30 kí tự',
                'email.required' => 'Chưa nhập email',
                'email.email' => 'Email chưa đúng',
                'email.unique' => 'Email đã tồn tại',
                'password.required' => 'Chưa nhập password',
                'password.min' => 'Password phải có 3-32 kí tự',
                'password.max' => 'Password phải có 3-32 kí tự',
                'passwordAgain.required' => 'Chưa nhập lại password',
                'passwordAgain.same' => 'Password nhập lại chưa đúng'
            ]);
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->quyen = 0;
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect('dangnhap')->with('thongbao', 'Đăng kí thành công. Bạn có thể đăng nhập.');
    }

    public function postTimkiem(Request $request)
    {
        $tukhoa = $request->tukhoa;
        $tintuc = TinTuc::where('TieuDe','like',"%$tukhoa%")->orWhere('TomTat','like',"%$tukhoa%")->orWhere('NoiDung','like',"%$tukhoa%")->take(30)->paginate(5);
        return view('pages.timkiem',['tukhoa'=>$tukhoa,'tintuc'=>$tintuc]);
    }
}
