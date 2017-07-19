<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LoaiTin;
use App\TheLoai;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function getDanhsach()
    {
        $user = User::all();
        return view('admin.user.danhsach', ['user' => $user]);
    }

    public function getSua($id)
    {
        $user = User::find($id);
        return view('admin.user.sua', ['user' => $user]);
    }

    public function postSua(Request $request, $id)
    {
        $this->validate($request,
            [
                'name' => 'required|min:3|max:30',
                'email' => 'required|email',
                'password' => 'required|min:3|max:32',
                'passwordAgain' => 'required|same:password'
            ],
            [
                'name.required' => 'Chưa nhập tên User',
                'name.min' => 'Tên phải 3-30 kí tự',
                'name.max' => 'Tên phải 3-30 kí tự',
                'email.required' => 'Chưa nhập email',
                'email.email' => 'Email chưa đúng',
                'password.required' => 'Chưa nhập password',
                'password.min' => 'Password phải có 3-32 kí tự',
                'password.max' => 'Password phải có 3-32 kí tự',
                'passwordAgain.required' => 'Chưa nhập lại password',
                'passwordAgain.same' => 'Password nhập lại chưa đúng'
            ]);
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->quyen = $request->quyen;
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect('admin/user/sua/' . $id)->with('thongbao', 'Sửa thành công');
    }


    public function getThem()
    {
        return view('admin.user.them');
    }

    public function postThem(Request $request)
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
        $user->quyen = $request->quyen;
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect('admin/user/them')->with('thongbao', 'Thêm user thành công');
    }

    public function getXoa($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('admin/user/danhsach')->with('thongbao', 'Xóa thành công');
    }

    public function getDangNhapAdmin()
    {
        return view('admin.layout.login');
    }

    public function postDangNhapAdmin(Request $request)
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
        if (Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
           return redirect('admin/theloai/danhsach')->with('thongbao','Đăng nhập thành công');
        }else{
            return redirect('admin/dangnhap')->with('thongbao','Đăng nhập thất bại');
        }
    }

    public function getDangXuatAdmin()
    {
        Auth::logout();
        return redirect('admin/dangnhap');
    }
}
