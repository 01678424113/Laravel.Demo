<?php

namespace App\Http\Controllers;

use App\TinTuc;
use Illuminate\Http\Request;
use App\TheLoai;
use App\LoaiTin;
use App\Comment;

class CommentController extends Controller
{
    //
    public function getXoa($id,$idTinTuc)
    {
        $comment = Comment::find($id);
        $comment->delete();
        return redirect('admin/tintuc/sua/'.$idTinTuc)->with('thongbao','Xóa comment thành công');
    }
}
