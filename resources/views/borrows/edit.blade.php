@extends('layouts.master')
@section('content')
<!-- .page-title-bar -->
<header class="page-title-bar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">
                <a href="{{route('borows.index')}}"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Quản Lý Phiếu
                    Mượn</a>
            </li>
        </ol>
    </nav>
    <h1 class="page-title"> Chỉnh Sửa Phiếu Mượn </h1>
</header>

<div class="page-section">
    <form method="post" action="{{route('borows.update',$item->id)}}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <legend>Thông tin cơ bản</legend>

                <div class="form-group">
                    <label for="tf1">Người mượn </label> <input type="text" name="name" value="{{ $item->name }}"
                        class="form-control" placeholder="Nhập tên kách hàng">
                    <small class="form-text text-muted"></small>
                    @if ($errors->any())
                    <p style="color:red">{{ $errors->first('name') }}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label for="tf1">Ngày mượn</label> <input type="text" name="quantity" value="{{ $item->quantity }}"
                        class="form-control" placeholder="Nhập địa chỉ">
                    <small class="form-text text-muted"></small>
                    @if ($errors->any())
                    <p style="color:red">{{ $errors->first('address') }}</p>
                    @endif
                </div>

                <div class="form-actions">
                    <a class="btn btn-secondary float-right" href="{{route('borows.index')}}">Hủy</a>
                    <button class="btn btn-primary ml-auto" type="submit">Cập nhật</button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection