@extends('layouts.master')
@section('content')

<header class="page-title-bar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">
                <a href="#"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Trang Chủ</a>
            </li>
        </ol>
    </nav>
    <div class="d-md-flex align-items-md-start">
        <h1 class="page-title mr-sm-auto">Chi Tiết Phiếu Mượn</h1>
    </div>
</header>

<div class="page-section">
    <div class="card card-fluid">
        <div class="card-body">
            <div class="row mb-2">
                <div class="col">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>

                        <tr>
                            <th>#</th>
                            <th>Tên thiết bị</th>
                            <th>Tên bài dạy</th>
                            <th>Số lượng</th>
                            <th>Buổi</th>
                            <th>Tiết PCCT</th>
                            <th>Lớp</th>
                            <th>Tiết TKB</th>
                            <th>Ngày trả</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($item2 as $key => $item3)

                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $item3->device->name }}</td>
                            <td>{{ $item3->lesson_name }}</td>
                            <td>{{ $item3->quantity }}</td>
                            <td>{{ $item3->session }}</td>
                            <td>{{ $item3->lecture_name }}</td>
                            <td>{{ $item3->room->name }}</td>
                            <td>{{ $item3->lecture_number }}</td>
                            <td>{{ $item3->return_date }}</td>
      
                            </tr>
                            @endforeach
                    </tbody><!-- /tbody -->

                </table><!-- /.table -->
                <button class="btn btn-dark" onclick="window.history.back()">
                    <i class="fa fa-arrow-left mr-2"></i> Back
                </button>
            </div>
            <!-- /.table-responsive -->
            <!-- .pagination -->
        </div><!-- /.card-body -->
    </div>
</div>
@endsection