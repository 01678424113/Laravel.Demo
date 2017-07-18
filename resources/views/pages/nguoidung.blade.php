@extends('layouts.index')
@section('content')
    <!-- Page Content -->
    <div class="container">

        <!-- slider -->
        <div class="row carousel-holder">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">Thông tin tài khoản</div>
                    <div class="panel-body">
                        <form action="nguoidung/{{$nd->id}}" method="post">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div>
                                <label>Họ tên</label>
                                <input type="text" class="form-control" value="{{$nd->name}}" name="name" aria-describedby="basic-addon1">
                            </div>
                            <br>
                            <div>
                                <label>Email</label>
                                <input type="email" class="form-control" value="{{$nd->email}}" name="email" aria-describedby="basic-addon1"
                                       disabled
                                >
                            </div>
                            <br>
                            <div>
                                <input type="checkbox" id="checkPassword" name="checkpassword">
                                <label>Đổi mật khẩu</label>
                                <input type="password" class="form-control disabled" name="password"  aria-describedby="basic-addon1" >
                            </div>
                            <br>
                            <div>
                                <label>Nhập lại mật khẩu</label>
                                <input type="password" class="form-control disabled" name="passwordAgain" aria-describedby="basic-addon1">
                            </div>
                            <br>
                            <button type="button" class="btn btn-default">Sửa
                            </button>

                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
            </div>
        </div>
        <!-- end slide -->
    </div>
    <!-- end Page Content -->
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            $("#checkPassword").change(function(){
                if($(this).is(":checked"))
                {
                    $(".disabled").removeAttr('disabled');
                }else
                {
                    $(".disabled").attr('disabled','');
                }
            })
        });
    </script>
@endsection
