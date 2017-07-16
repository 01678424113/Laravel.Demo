@extends('admin.layout.index')

@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Sửa slide
                        <small>{{$slide->Ten}}</small>
                    </h1>
                </div>
                <!-- /.col-lg-12 -->
                <div class="col-lg-7" style="padding-bottom:120px">
                    <form action="admin/slide/sua/{{$slide->id}}" method="POST" enctype="multipart/form-data">
                        @if(count($errors) > 0)
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $err )
                                    {{$err}}<br/>
                                @endforeach
                            </div>
                        @endif
                        @if(session('thongbao'))
                            <div class="alert alert-success">
                                {{session('thongbao')}}
                            </div>
                        @endif
                        @if(session('loi'))
                            <div class="alert alert-danger">
                                {{session('loi')}}
                            </div>
                        @endif
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form-group">
                            <label>Tên</label>
                            <input class="form-control" name="Ten" value="{{$slide->Ten}}"/>
                        </div>
                        <div class="form-group">
                            <label>Hình</label>
                            <p><img width="400px" src="upload/slide/{{$slide->Hinh}}" alt=""></p>
                            <input type="file" name="Hinh">
                        </div>
                        <div class="form-group">
                            <label>Nội dung</label>
                            <textarea class="form-control ckeditor" id="demo" rows="3"
                                      name="NoiDung">{{$slide->NoiDung}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Link</label>
                            <input class="form-control" name="link" value="{{$slide->link}}"/>
                        </div>
                        <button type="submit" class="btn btn-default">Sửa</button>
                        <button type="reset" class="btn btn-default">Refresh</button>
                        <form>
                </div>
            </div>
            <!-- /.row -->
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
        @endsection
        @section('script')
            <script>
                $(document).ready(function () {
                    $('#TheLoai').change(function () {
                        var idTheLoai = $(this).val();
                        $.get("admin/ajax/loaitin/" + idTheLoai, function (data) {
                            $('#LoaiTin').html(data);
                        });
                    });
                });
            </script>
@endsection