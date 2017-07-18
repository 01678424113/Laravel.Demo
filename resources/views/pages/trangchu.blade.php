@extends('layouts.index')
@section('content')
    <!-- Page Content -->
    <div class="container">

        @include('layouts.slide')

        <div class="space20"></div>

        <div class="row main-left">
            @include('layouts.menu')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color:#337AB7; color:white;">
                        <h2 style="margin-top:0px; margin-bottom:0px;">Laravel Tin Tức</h2>
                    </div>

                    <div class="panel-body">
                    @foreach($theloai as $tl)
                        <!-- item -->
                            <div class="row-item row">
                                <h3>
                                    @if(count($tl->loaitin) > 0)
                                        <a href="category.html">{{$tl->Ten}}</a> |
                                        @foreach($tl->loaitin as $lt)
                                            <small><a href="loaitin/{{$lt->id}}/{{$lt->TenKhongDau}}.html">{{$lt->Ten}}</a> /</small>
                                        @endforeach
                                </h3>
                                <div class="col-md-8 border-right">
                                    <?php
                                    $data = $tl->tintuc->where('NoiBat', 1)->sortByDesc('create_at')->take(6);
                                    $tin1 = $data->shift();
                                    ?>
                                    <div class="col-md-5">
                                        <a href="tintuc/{{$tin1->id}}/{{$tin1->TieuDeKhongDau}}.html">
                                            <img class="img-responsive" src="upload/tintuc/{{$tin1['Hinh']}}" alt="">
                                        </a>
                                    </div>

                                    <div class="col-md-7">
                                        <h3>{{$tin1['TieuDe']}}</h3>
                                        <p>{{$tin1['TomTat']}}</p>
                                        <a class="btn btn-primary" href="tintuc/{{$tin1->id}}/{{$tin1->TieuDeKhongDau}}.html">Xem thêm <span
                                                    class="glyphicon glyphicon-chevron-right"></span></a>
                                    </div>

                                </div>


                                <div class="col-md-4">
                                    @foreach($data as $t)
                                    <a href="tintuc/{{$t->id}}/{{$t->TieuDeKhongDau}}.html">
                                        <h4>
                                            <span class="glyphicon glyphicon-list-alt"></span>
                                            {{$t['TieuDe']}}
                                        </h4>
                                    </a>
                                    @endforeach
                                    @endif
                                </div>

                                <div class="break"></div>
                            </div>
                            <!-- end item -->
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- end Page Content -->
@endsection