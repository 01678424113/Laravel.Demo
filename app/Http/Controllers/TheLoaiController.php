<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;

class TheLoaiController extends Controller
{
    //
    public function getDanhsach(){
        $theloai = TheLoai::all();
        return view('admin.theloai.danhsach',['theloai'=>$theloai]);
    }
    public function getSua($id){
       $theloai = TheLoai::find($id);
       return view('admin\theloai\sua',['theloai'=>$theloai]);
    }
    public function postSua(Request $request,$id){
        $theloai = TheLoai::find($id);
        $this->validate($request,
            [
                'Ten'=>'required|min:3|max:100|unique:TheLoai,Ten'
            ]
            ,
            [
                'Ten.required'=>'Bạn chưa nhập tên mới',
                'Ten.min'=>'Bạn cần nhập tên lớn hơn 3 đến 100 kí tự',
                'Ten.max'=>'Bạn cần nhập tên lớn hơn 3 đến 100 kí tự',
                'Ten.unique'=>'Tên đã tồn tại'
            ]);

        $theloai->Ten = $request->Ten;
        $theloai->TenKhongDau = changeTitle($request->Ten);
        $theloai->save();
        return redirect('admin/theloai/sua/'.$id)->with('thongbao','Đã sửa thành công');
    }


    public function getThem(){
        return view('admin.theloai.them');
    }
    public function postThem(Request $request)
    {
        $this->validate($request,
            [
                'Ten' => 'required|unique:TheLoai,Ten|min:3|max:100'
            ],
            [
                'Ten.required'=>'Bạn chưa nhập thể loại',
                'Ten.min'=>'Bạn cần nhập tên lớn hơn 3 đến 100 kí tự',
                'Ten.max'=>'Bạn cần nhập tên lớn hơn 3 đến 100 kí tự',
                'Ten.unique'=>'Tên đã tồn tại'
            ]);
        $theloai = new TheLoai;
        $theloai->Ten = $request->Ten;
        $theloai->TenKhongDau = changeTitle($request->Ten);
        $theloai->save();
        return redirect('admin/theloai/them')->with('thongbao','Thêm thành công');
    }

    public function getXoa($id){
        $theloai = TheLoai::find($id);
        $theloai->delete();

        return redirect('admin/theloai/danhsach')->with('thongbao','Đã xóa thành công');
    }

}
