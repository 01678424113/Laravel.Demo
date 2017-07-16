<?php

namespace App\Http\Controllers;

use App\TinTuc;
use Illuminate\Http\Request;
use App\TheLoai;
use App\LoaiTin;
use App\Comment;

class TinTucController extends Controller
{
    //
    public function getDanhsach(){
        $tintuc = TinTuc::all();
        return view('admin.tintuc.danhsach',['tintuc'=>$tintuc]);
    }
    public function getSua($id){
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::all();
        $tintuc = TinTuc::find($id);
        return view('admin.tintuc.sua',['theloai'=>$theloai,'loaitin'=>$loaitin,'tintuc'=>$tintuc]);
    }

    public function postSua(Request $request,$id)
    {
        $tintuc = TinTuc::find($id);
        $this->validate($request,
            [
                'LoaiTin'=>'required',
                'TieuDe'=>'required',
                'TomTat'=>'required',
                'NoiDung'=>'required',
            ],
            [
                'LoaiTin.required'=>'Chưa chọn loại tin',
                'TieuDe.required'=>'Chưa nhập tiêu đề',
                'TomTat.required'=>'Chưa nhập tóm tắt',
                'NoiDung.required'=>'Chưa nhập nội dung',
            ]);
        $tintuc->TieuDe = $request->TieuDe;
        $tintuc->TieuDeKhongDau = changeTitle($request->TieuDe);
        $tintuc->idLoaiTin = $request->LoaiTin;
        $tintuc->TomTat =$request->TomTat;
        $tintuc->NoiDung = $request->NoiDung;
        $tintuc->NoiBat = $request->NoiBat;

        if($request->hasFile('Hinh')){
            $file = $request->file('Hinh');

            $duoi = $file->getClientOriginalExtension();
            $name = $file->getClientOriginalName();
            $hinh = str_random(5)."_".$name;
            while(file_exists("upload/tintuc/".$hinh)){
                $hinh = str_random(5)."_".$name;
            };
            if($duoi != 'jpg' && $duoi != 'png'){
                return redirect('admin/tintuc/sua/'.$id)->with('loi','Hình ảnh phải có đuôi jpg hoặc png');
            };
            $file->move("upload/tintuc/",$hinh);
            unlink("upload/tintuc/".$tintuc->Hinh);
            $tintuc->Hinh = $hinh;
        }else{
            $tintuc->Hinh = "";
        };
        $tintuc->save();
        return redirect('admin/tintuc/sua/'.$tintuc->id)->with('thongbao','Sửa thành công');
    }

    public function getThem(){
        $loaitin = LoaiTin::all();
        $theloai = TheLoai::all();
        return view('admin.tintuc.them',['loaitin'=>$loaitin,'theloai'=>$theloai]);
    }

    public function postThem(Request $request)
    {
        $this->validate($request,
            [
                'LoaiTin'=>'required',
                'TieuDe'=>'required|unique:TinTuc,TieuDe',
                'TomTat'=>'required',
                'NoiDung'=>'required',
            ],
            [
                'LoaiTin.required'=>'Chưa chọn loại tin',
                'TieuDe.required'=>'Chưa nhập tiêu đề',
                'TieuDe.unique'=>'Tiêu đề đã tồn tại',
                'TomTat.required'=>'Chưa nhập tóm tắt',
                'NoiDung.required'=>'Chưa nhập nội dung',
            ]);
        $tintuc = new TinTuc;
        $tintuc->TieuDe = $request->TieuDe;
        $tintuc->TieuDeKhongDau = changeTitle($request->TieuDe);
        $tintuc->idLoaiTin = $request->LoaiTin;
        $tintuc->TomTat =$request->TomTat;
        $tintuc->NoiDung = $request->NoiDung;
        $tintuc->NoiBat = $request->NoiBat;
        $tintuc->SoLuotXem = 0;

        if($request->hasFile('Hinh')){
            $file = $request->file('Hinh');

            $duoi = $file->getClientOriginalExtension();
            $name = $file->getClientOriginalName();
            $hinh = str_random(5)."_".$name;
            while(file_exists("upload/tintuc/".$hinh)){
                $hinh = str_random(5)."_".$name;
            };
            if($duoi != 'jpg' && $duoi != 'png'){
                return redirect('admin/tintuc/them')->with('loi','Hình ảnh phải có đuôi jpg hoặc png');
            };
            $file->move("upload/tintuc/",$hinh);
            $tintuc->Hinh = $hinh;
        }else{
            $tintuc->Hinh = "";
        };
        $tintuc->save();
        return redirect('admin/tintuc/them')->with('thongbao','Đã thêm thành công');
    }

    public function getXoa($id)
    {
        $tintuc = TinTuc::find($id);
        $tintuc->delete();
        return redirect('admin/tintuc/danhsach')->with('thongbao','Xóa thành công');
    }
}
