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
            <h1 class="page-title mr-sm-auto">Quản lý giáo viên</h1>
        </div>
    </header>
    <div class="page-section">
        <div class="card card-fluid">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col">
                        <form action="" method="GET" id="form-search">
                            <div class="input-group input-group-alt">
                                <div class="input-group-prepend">
                                    <button class="btn btn-secondary" type="button" data-toggle="modal"
                                        data-target="#modalFilterColumns">Tìm nâng cao</button>
                                </div>
                                <div class="input-group has-clearable">
                                    <button type="button" class="close trigger-submit trigger-submit-delay"
                                        aria-label="Close">
                                        <span aria-hidden="true"><i class="fa fa-times-circle"></i></span>
                                    </button>
                                    <div class="input-group-prepend trigger-submit">
                                        <span class="input-group-text"><span class="fas fa-search"></span></span>
                                    </div>
                                    <input type="text" class="form-control" name="query" value=""
                                        placeholder="Tìm nhanh theo cú pháp (ma:Mã kết quả hoặc ten:Tên kết quả)">
                                </div>
                                <div class="input-group-append">
                                    <button class="btn btn-secondary" data-toggle="modal" data-target="#modalSaveSearch"
                                        type="button">Lưu bộ lọc</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Mật khẩu</th>
                                <th>Giới tính</th>
                                <th>Ngày sinh</th>
                                <th>Chức vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->password }}</td>
                                <td>{{ $item->gender }}</td>
                                <td>{{ $item->birthday }}</td>
                                <td>{{ $item->group->name }}</td>

                            </tr>
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
