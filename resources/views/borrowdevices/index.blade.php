@extends('layouts.master')
@section('content')
<header class="page-title-bar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">
                <a href="{{ route('borrowdevices.index') }}"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Trang
                    Chủ</a>
            </li>
        </ol>
    </nav>
    <div class="d-md-flex align-items-md-start">
        <h1 class="page-title mr-sm-auto">Quản Lý Thiết Bị Mượn</h1>
        <div class="btn-toolbar">
            {{-- borrowdevices.testHTML --}}
            {{-- export.single.page --}}
            <a href="{{ route('export.single.page') }}" class="btn btn-primary mr-2">
                <i class="fa-solid fa fa-plus"></i>
                <span class="ml-1">Xuất Excel</span>
            </a>
        </div>
    </div>

</header>
<div class="page-section">
    <div class="card card-fluid">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active " href="{{ route('borrowdevices.index') }}">Tất Cả</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col">
                    <form action="{{ route('borrowdevices.index') }}" method="GET" id="form-search">

                        <div class="row">
                            <div class="col">
                                <input name="searchTeacher" value="{{ request('searchTeacher') }}" class="form-control"
                                    type="text" placeholder="Tìm theo tên giáo viên..." />
                            </div>
                            <div class="col">
                                <input name="searchName" value="{{ request('searchName') }}" class="form-control"
                                    type="text" placeholder="Tìm theo tên thiết bị..." />
                            </div>
                            <div class="col">
                                <input name="searchSession" value="{{ request('searchSession') }}" class="form-control"
                                    type="text" placeholder="Tìm theo buổi..." />
                            </div>
                            <div class="col">
                                <input name="searchQuantity" value="{{ request('searchQuantity') }}"
                                    class="form-control" type="text" placeholder="Tìm theo số lượng..." />
                            </div>
                            <div class="col">
                                <input name="searchBorrow_date" value="{{ request('searchBorrow_date') }}"
                                    class="form-control" type="date" placeholder="Tìm theo ngày mượn..." />
                            </div>
                            <div class="col">
                                <select name="searchStatus" class="form-control">
                                    <option value="">Tìm theo trạng thái...</option>
                                    <option value="1" {{ request('searchStatus') == '1' ? 'selected' : '' }}>Đã trả
                                    </option>
                                    <option value="0" {{ request('searchStatus') == '0' ? 'selected' : '' }}>Chưa
                                        trả</option>
                                </select>
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
                            <th>Trạng thái</th>
                            <th>Ngày mượn</th>
                            <th>Ngày trả</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $key => $item)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <!-- Hiển thị tên người mượn -->
                            <td>{{ $item->borrow->user->name ?? 'null' }}</td>
                            <td>{{ $item->device->name ?? 'null' }}</td>
                            <td>{{ $item->lesson_name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->session }}</td>
                            <td>{{ $item->lecture_name }}</td>
                            <td>{{ $item->room->name }}</td>
                            <td>{{ $item->lecture_number }}</td>
                            <td>{{ $changeStatus[$item->status] ?? 'Unknown Status' }}</td>
                            <td>
                                {{ optional($item->borrow)->borrow_date ? date('d/m/Y', strtotime($item->borrow->borrow_date)) : 'null' }}
                            </td>


                            <td>{{ date('d/m/Y', strtotime($item->return_date)) }}</td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div style="float:right">
                    {{ $items->appends(request()->query())->links() }}
                </div>
            </div>
            @endsection