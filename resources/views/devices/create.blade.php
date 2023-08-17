@extends('layouts.master')
@section('content')
<header class="page-title-bar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">
                <a href="{{route('devices.index')}}"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Quản Lý Thiết Bị </a>
            </li>
        </ol>
    </nav>
    <h1 class="page-title">Thêm Thiết Bị</h1>
</header>
<div class="page-section">
    <form method="post" action="{{route('devices.store')}}" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
                <legend>Thông tin cơ bản</legend>
                <div class="form-group">
                    <label for="tf1">Tên thiết bị <abbr name="Trường bắt buộc">*</abbr></label> <input name="name" type="text" class="form-control" id="" placeholder="Nhập tên thiết bị">
                    <small id="" class="form-text text-muted"></small>
                    @if ($errors->any())
                    <p style="color:red">{{ $errors->first('name') }}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label for="tf1">Số lượng<abbr name="Trường bắt buộc">*</abbr></label> <input name="quantity" type="text" class="form-control" id="" placeholder="Nhập số lượng">
                    <small id="" class="form-text text-muted"></small>
                    @if ($errors->any())
                    <p style="color:red">{{ $errors->first('quantity') }}</p>
                    @endif
                </div>
                 <div class="mb-3">
                     <label for="image" class="form-label">Ảnh</label>
                     <input type="file" class="form-control" id="image" name="image" onchange="previewImage(event)">
                      <div class="image-container mt-3">
                     <img id="preview" src="#" alt="Ảnh" style="max-width: 100px; display: none;">
                 </div>
                 @if ($errors->any())
                    <p style="color:red">{{ $errors->first('image') }}</p>
                    @endif
</div>
                <div class="form-actions">
                    <a class="btn btn-secondary float-right" href="{{route('devices.index')}}">Hủy</a>
                    <button class="btn btn-primary ml-auto" type="submit">Lưu</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection