@extends('layouts.master')
@section('content')
    <header class="page-title-bar">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="{{ route('devicetypes.index') }}"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Trang
                        Chủ</a>
                </li>
            </ol>
        </nav>
        <div class="d-md-flex align-items-md-start">
            <h1 class="page-title mr-sm-auto">Quản Lý Loại Thiết Bị - Thùng Rác</h1>
            <div class="btn-toolbar">
            </div>
        </div>
    </header>
    <div class="page-section">
        <div class="card card-fluid">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link " href="{{ route('devicetypes.index') }}">Tất Cả</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active " href="{{ route('devicetypes.trash') }}">Thùng Rác</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col">
                        <form action="{{ route('devicetypes.trash') }}" method="GET" id="form-search">
                            <div class="row">
                                <div class="col">
                                    <input name="searchName" value="{{request('searchName')}}" class="form-control" type="text"
                                        placeholder="Tìm theo tên..." />
                                </div>
                                <div class="col-lg-1">
                                    <button class="btn btn-secondary" data-toggle="modal" data-target="#modalSaveSearch"
                                        type="submit">Tìm Kiếm</button>
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
                                <th> STT </th>
                                <th> Tên loại thiết bị </th>
                                <th> Thao tác </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($devicetypes as $devicetype)
                                <tr>
                                    <td class="align-middle"> {{ $devicetype->id }} </td>
                                    <td class="align-middle"> {{ $devicetype->name }} </td>
                                    <td>
                                        <form action="{{ route('devicetypes.forceDelete', $devicetype->id) }}"
                                            style="display:inline" method="post">
                                            <button onclick="return confirm('Xóa vĩnh viễn {{ $devicetype->name }} ?')"
                                                class="btn btn-sm btn-icon btn-secondary"><i
                                                    class="far fa-trash-alt"></i></button>
                                            @csrf
                                            @method('delete')
                                        </form>
                                        <span class="sr-only">Edit</span></a> <a
                                            href="{{ route('devicetypes.restore', $devicetype->id) }}"
                                            class="btn btn-sm btn-icon btn-secondary"><i class="fa fa-trash-restore"></i>
                                            <span class="sr-only">Remove</span></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div style="float:right">
                {{ $devicetypes->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection
