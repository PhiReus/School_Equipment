@extends('layouts.master')
@section('content')
    <header class="page-title-bar">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="{{ route('borrows.index') }}"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Trang Chủ</a>
                </li>
            </ol>
        </nav>
        <!-- <button type="button" class="btn btn-success btn-floated"><span class="fa fa-plus"></span></button> -->
        <div class="d-md-flex align-items-md-start">
            <h1 class="page-title mr-sm-auto">Quản Lý Phiếu Mượn</h1>
            <div class="btn-toolbar">
                <a href="{{ route('borrows.create') }}" class="btn btn-primary mr-2">
                    <i class="fa-solid fa fa-plus"></i>
                    <span class="ml-1">Thêm Mới</span>
                </a>

            </div>
        </div>
    </header>
    <div class="page-section">
        <div class="card card-fluid">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link active " href="{{ route('borrows.index') }}">Tất Cả</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('borrows.trash') }}">Thùng Rác</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col">
                        <form action="{{ route('borrows.index') }}" method="GET" id="form-search">

                            <div class="row">
                                <div class="col">

                                    <input name="searchName" value="{{ request('searchName') }}" class="form-control"
                                        type="text" placeholder="Tìm theo tên..." />
                                </div>
                                <div class="col">
                                    <input name="searchBorrow_date" value="{{ request('searchBorrow_date') }}"
                                        class="form-control" type="text" placeholder="Tìm theo ngày mượn..." />
                                </div>
                                <div class="col">
                                    <select name="searchStatus" class="form-control">
                                        <option value="">Tìm theo tình trạng...</option>
                                        <option value="Đã trả"
                                            {{ $request->input('searchStatus') === 'Đã trả' ? 'selected' : '' }}>Đã trả
                                        </option>
                                        <option value="Chưa trả"
                                            {{ $request->input('searchStatus') === 'Chưa trả' ? 'selected' : '' }}>Chưa trả
                                        </option>
                                    </select>
                                </div>

                                <div class="col">
                                    <select name="searchApproved" class="form-control">
                                        <option value="">Tìm theo trạng thái...</option>
                                        <option value="Chưa xét duyệt"
                                            {{ $request->input('searchApproved') === 'Chưa xét duyệt' ? 'selected' : '' }}>
                                            Chưa xét duyệt</option>
                                        <option value="Đã xét duyệt"
                                            {{ $request->input('searchApproved') === 'Đã xét duyệt' ? 'selected' : '' }}>Đã
                                            xét duyệt</option>
                                        <option value="Từ chối"
                                            {{ $request->input('searchApproved') === 'Từ chối' ? 'selected' : '' }}>Từ chối
                                        </option>
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
                                <th>STT</th>
                                <th>Người dùng</th>
                                <th>Ngày mượn</th>
                                <th>Tình trạng</th>
                                <th>Xét duyệt</th>
                                <th>Chức năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $key => $item)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>
                                        <a href="{{ route('borrows.show', $item->id) }}">
                                            {{ $item->user->name }}
                                        </a>
                                    </td>
                                    <td>{{ date('d/m/Y', strtotime($item->borrow_date)) }}</td>
                                    <td>{{ $item->status ? 'Đã trả' : 'Chưa trả' }}</td>
                                    <td>{{ $item->approved ? 'Đã duyệt' : 'Chưa duyệt' }}</td>

                                    <td>

                                        <span class="sr-only">Edit</span>

                                        @if ($item->approved != 1)
                                            <a href="{{ route('borrows.edit', $item->id) }}"
                                                class="btn btn-sm btn-icon btn-secondary">
                                                <i class="fa fa-pencil-alt"></i>
                                                <span class="sr-only">Remove</span>
                                            </a>
                                        @endif

                                        <a class="btn btn-sm btn-icon btn-secondary"
                                            href="{{ route('borrows.show', $item->id) }}">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>

                                        </a>
                                        @if ($item->approved != 1)
                                            <form action="{{ route('borrows.destroy', $item->id) }}" style="display:inline"
                                                method="post">
                                                <button onclick="return confirm('Xóa {{ $item->name }} ?')"
                                                    class="btn btn-sm btn-icon btn-secondary">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                                @csrf
                                                @method('delete')
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div style="float:right">
                        {{ $items->appends(request()->query())->links() }}
                    </div>

                </div>
            @endsection
