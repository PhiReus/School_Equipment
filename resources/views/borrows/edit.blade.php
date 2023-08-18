@extends('layouts.master')
@section('content')
<!-- .page-title-bar -->
<header class="page-title-bar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">
                <a href="{{route('borrows.index')}}"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Quản Lý Phiếu Mượn</a>
            </li>
        </ol>
    </nav>
    <h1 class="page-title"> Chỉnh Sửa Phiếu Mượn </h1>
</header>

<div class="page-section">
    <form method="post" action="{{route('borrows.update',$items->id)}}">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <legend>Thông tin cơ bản</legend>

                <div class="form-group">
                    <label for="tf1">Người mượn </label>
                    <select class="form-control" name="user_id">
                        <option value="">--Vui lòng chọn--</option>
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $items->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('user_id'))
                    <p style="color:red">{{ $errors->first('user_id') }}</p>
                    @endif
                    
                </div>
                <div class="form-group">
                    <label for="tf1">Ngày mượn</label>
                    <input type="date" name="borrow_date" value="{{ $items->borrow_date }}" class="form-control"
                        placeholder="Nhập ngày mượn">
                    @if ($errors->has('borrow_date'))
                    <p style="color:red">{{ $errors->first('borrow_date') }}</p>
                    @endif
                </div>

                <div class="form-actions">
                    <a class="btn btn-secondary float-right" href="{{route('borrows.index')}}">Hủy</a>
                    <button class="btn btn-primary ml-auto" type="submit">Cập nhật</button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection
