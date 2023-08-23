@extends('layouts.master')
@section('content')
<header class="page-title-bar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">
                <a href="{{route('borrowdevices.index')}}"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Trang
                    Chủ</a>
            </li>
        </ol>
    </nav>
    <!-- <button type="button" class="btn btn-success btn-floated"><span class="fa fa-plus"></span></button> -->
    <div class="d-md-flex align-items-md-start">
        <h1 class="page-title mr-sm-auto">Chi Tiết Phiếu Mượn</h1>
    </div>
</header>
<div class="page-section">
    <div class="card card-fluid">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active " href="{{route('borrowdevices.index')}}">Tất Cả</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('borrowdevices.trash')}}">Thùng Rác</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col">
                    <form action="{{ route('borrowdevices.index') }}" method="GET" id="form-search">

                        <div class="row">
                            <div class="col">
                                <input name="searchName" class="form-control" type="text"
                                    placeholder="Tìm theo tên..." />
                            </div>
                            <div class="col">
                                <input name="searchSession" class="form-control" type="text"
                                    placeholder="Tìm theo buổi..." />
                            </div>
                            <div class="col">
                                <input name="searchQuantity" class="form-control" type="text"
                                    placeholder="Tìm theo số lượng..." />
                            </div>
                            <div class="col-lg-2">
                                <button class="btn btn-secondary" type="submit">Tìm Kiếm</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
            @endif
            @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
            @endif
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Người mượn</th>
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
                        @foreach ($items as $key => $item)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <!-- Hiển thị tên người mượn -->
                            <td>{{ $item->borrow->user->name ?? 'Người mượn không tồn tại' }}</td>
                            <td>{{ $item->device->name }}</td>
                            <td>{{ $item->lesson_name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->session }}</td>
                            <td>{{ $item->lecture_name	 }}</td>
                            <td>{{ $item->room->name }}</td>
                            <td>{{ $item->lecture_number}}</td>
                            <td>{{ $item->return_date}}</td>




                            <td>
                                <form action="{{ route('borrowdevices.destroy',$item->id )}}" style="display:inline"
                                    method="post">
                                    <button onclick="return confirm('Xóa {{$item->name}} ?')"
                                        class="btn btn-sm btn-icon btn-secondary"><i
                                            class="far fa-trash-alt"></i></button>
                                    @csrf
                                    @method('delete')
                                </form>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div style="float:right">
                    {{ $items->links() }}
                </div>
            </div>

            @endsection