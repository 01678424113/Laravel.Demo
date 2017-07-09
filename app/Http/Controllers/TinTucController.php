<?php

namespace App\Http\Controllers;

use App\TinTuc;
use Illuminate\Http\Request;
use App\TheLoai;
use App\LoaiTin;

class TinTucController extends Controller
{
    //
    public function getDanhsach(){
        $tintuc = TinTuc::orderBy('id','DESC')->get();
        return view('admin.tintuc.danhsach',['tintuc'=>$tintuc]);
    }
    public function getSua(){
        return view('admin.tintuc.sua');
    }
    public function getThem(){
        return view('admin.tintuc.them');
    }
}
