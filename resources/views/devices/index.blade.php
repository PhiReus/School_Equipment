@extends('layouts.master')
@section('content')
        <header class="page-title-bar">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">
                        <a href="{{ route('devices.index') }}"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Trang
                            Chủ</a>
                    </li>
                </ol>
            </nav>
            <div class="d-md-flex align-items-md-start">
                <h1 class="page-title mr-sm-auto">Quản Lý Thiết Bị</h1>
                <div class="btn-toolbar">
                    @if (Auth::user()->hasPermission('Group_create'))
                        <a href="{{ route('devices.create') }}" class="btn btn-primary mr-2">
                            <i class="fa-solid fa fa-plus"></i>
                            <span class="ml-1">Thêm Mới</span>
                        </a>
                    @endif
                    <a href="" class="btn btn-primary">
                        <i class="fas fa-file"></i>
                        <span class="ml-1">Xuất file excel</span>
                    </a>
                </div>
            </div>
        </header>
        <div class="page-section">
            <div class="card card-fluid">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link active " href="{{ route('devices.index') }}">Tất Cả</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('devices.trash') }}">Thùng Rác</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col">
                            <form action="{{ route('devices.index') }}" method="GET" id="form-search">

                                <div class="row">
                                    <div class="col">
                                        <input name="searchName" class="form-control" type="text"
                                            placeholder="Tìm theo tên..." />
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
                                    <th>Tên Thiết Bị</th>
                                    <th>Số Lượng</th>
                                    @if (Auth::check())
                                        <th>Chức năng</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $key => $item)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>
                                            <a href="{{ route('devices.edit', $item->id) }}" class="tile tile-img mr-1">
                                                <img class="img-fluid" src="{{ asset($item->image) }}" alt="">
                                            </a>
                                            <a href="{{ route('devices.edit', $item->id) }}">{{ $item->name }}</a>
                                        </td>
                                        <td>{{ $item->quantity }}</td>
                                        @if (Auth::check())
                                            <td>
                                                @if (Auth::user()->hasPermission('Device_update'))
                                                    <form action="{{ route('devices.destroy', $item->id) }}"
                                                        style="display:inline" method="post">
                                                        <button onclick="return confirm('Xóa {{ $item->name }} ?')"
                                                            class="btn btn-sm btn-icon btn-secondary"><i
                                                                class="far fa-trash-alt"></i></button>
                                                        @csrf
                                                        @method('delete')
                                                    </form>
                                                @endif
                                                @if (Auth::user()->hasPermission('Device_delete'))
                                                    <span class="sr-only">Edit</span></a> <a
                                                        href="{{ route('devices.edit', $item->id) }}"
                                                        class="btn btn-sm btn-icon btn-secondary"><i
                                                            class="fa fa-pencil-alt"></i> <span
                                                            class="sr-only">Remove</span></a>
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div style="float:right">
                            {{ $items->links() }}
                        </div>
                    </div>
@endsection
