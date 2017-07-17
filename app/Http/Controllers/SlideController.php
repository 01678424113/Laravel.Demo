<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LoaiTin;
use App\TheLoai;
use App\Slide;

class SlideController extends Controller
{
    //
    public function getDanhsach(){
        $slide = Slide::all();
        return view('admin.slide.danhsach',['slide'=>$slide]);
    }
    public function getSua($id){
        $slide = Slide::find($id);
        return view('admin.slide.sua',['slide'=>$slide]);
    }
    public function postSua(Request $request,$id){
        $slide = Slide::find($id);
        $this->validate($request,
            [
                'Ten'=>'required',
                'NoiDung'=>'required',
                'link'=>'required'
            ],
            [
                'Ten.required'=>'Chưa nhập tên silde',
                'NoiDung.required'=>'Chưa nhập nội dung',
                'link.required'=>'Chưa nhập link'
            ]);
        $slide->Ten = $request->Ten;
        $slide->NoiDung= $request->NoiDung;
        $slide->link = $request->link;
        if($request->hasFile('Hinh')){
            $file = $request- >file('Hinh');

            $name = $file->getClientOriginalName();
            $duoi = $file->getClientOriginalExtension();
            $hinh = str_random(5)."_".$name;
            while(file_exists('upload/slide/'.$hinh)){
                $hinh = str_random(5)."_".$name;
            }
            if($duoi != 'jpg' && $duoi != 'png'){
                return redirect('admin/slide/sua/'.$id)->with('loi','File ảnh phải có đuôi png hoặc jpg');
            }
            $file->move('upload/slide',$hinh);
            unlink('upload/slide/'.$slide->Hinh);
            $slide->Hinh = $hinh;
        }
        $slide->save();
        return redirect('admin/slide/sua/'.$id)->with('thongbao','Sửa thành công');
    }


    public function getThem(){
        return view('admin.slide.them');
    }
    public function postThem(Request $request)
    {
        $this->validate($request,
            [
                'Ten'=>'required',
                'NoiDung'=>'required',
                'link'=>'required'
            ],
            [
                'Ten.required'=>'Chưa nhập tên silde',
                'NoiDung.required'=>'Chưa nhập nội dung',
                'link.required'=>'Chưa nhập link'
            ]);
        $slide = new Slide;
        $slide->Ten = $request->Ten;
        $slide->NoiDung = $request->NoiDung;
        $slide->link = $request->link;
        if($request->hasFile('Hinh')){
            $file = $request->file('Hinh');

            $name = $file->getClientOriginalName();
            $duoi = $file->getClientOriginalExtension();
            $hinh = str_random(5)."_".$name;
            while(file_exists('upload/slide/'.$hinh)){
                $hinh = str_random(5)."_".$name;
            }
            if($duoi != 'jpg' && $duoi != 'png'){
                return redirect('admin/slide/them')->with('loi','File ảnh phải có đuôi png hoặc jpg');
            }
            $file->move('upload/slide',$hinh);
            $slide->Hinh = $hinh;
        }
        $slide->save();
        return redirect('admin/slide/them')->with('thongbao','Thêm thành công');
    }

    public function getXoa($id){
        $slide = Slide::find($id);
        $slide->delete();
        return redirect('admin/slide/danhsach')->with('thongbao','Xóa thành công');
    }
}
