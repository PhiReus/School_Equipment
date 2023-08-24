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

                <div class="row">
                    <div class="col-lg-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="mr-2">
                                <i class="far fa-calendar-alt fa-2x"></i>
                            </div>
                            <div>
                                <p class="mb-0" style="font-size: 16px;"><strong>Ngày mượn:</strong>
                                    {{ $item->borrow_date }}</p>
                                <p class="mb-0" style="font-size: 16px;">#ID {{ $item->id }}</p>
                            </div>


                        </div>
                    </div>

                    <div class="col-lg-4">
                    </div>
                    <div class="col-lg-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="mr-2">
                                <i class="far fa-calendar-check fa-2x"></i>
                            </div>
                            <div class="flex-grow-1">
                                <p class="mb-0" style="font-size: 16px;">Trạng thái</p>
                                <form action="{{ route('borrows.update-approved', $item->id) }}" method="POST"
                                    class="d-flex align-items-center">
                                    @csrf
                                    @method('PUT')
                                    <select name="approved" class="form-control mr-2" style="width: 150px;">
                                        <option value="Đã xét duyệt"
                                            {{ $item->approved === 'Đã xét duyệt' ? 'selected' : '' }}>Đã xét duyệt
                                        </option>
                                        <option value="Chưa xét duyệt"
                                            {{ $item->approved === 'Chưa xét duyệt' ? 'selected' : '' }}>Chưa xét duyệt
                                        </option>
                                        <option value="Từ chối" {{ $item->approved === 'Từ chối' ? 'selected' : '' }}>Từ
                                            chối</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary">Lưu</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="page-section">
                            <div class="card card-fluid">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="mr-3">
                                            <img src="{{ $user->image }}" alt="Avatar"
                                                style="width: 50px; height: 50px; border-radius: 50%;">
                                        </div>
                                        <div>
                                            <h4 class="mb-0" style="font-size: 24px;">Giáo Viên</h4>
                                            <p class="mb-0" style="font-size: 16px;">{{ $user->name }}</p>
                                            <p class="mb-0" style="font-size: 16px;">{{ $user->email }}
                                            </p>
                                            <p class="mb-0" style="font-size: 16px;">+{{ $user->phone }}
                                            </p>
                                            <a href="{{ route('users.show',  $user->id) }}" style="color: #007bff;">
                                                View Profile
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">

                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                    </div>
                </div>
                @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
                @endif
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
                            @foreach($borrow_device as $index => $item1)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <a class="tile tile-img mr-1">
                                        <img src="{{ $devices[$index]->image }}" alt="Ảnh sản phẩm"
                                            style="max-width: 100px; max-height: 100px;">
                                        <a href="#">{{ $devices[$index]->name }}</a>
                                </td>
                                <td>{{ $item1->lesson_name }}</td>
                                <td>{{ $item1->quantity }}</td>
                                <td>{{ $item1->session }}</td>
                                <td>{{ $item1->lecture_name }}</td>
                                <td>{{ $item1->room->name }}</td>
                                <td>{{ $item1->lecture_number }}</td>
                                <td>{{ $item1->return_date }}</td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table><!-- /.table -->
                    <div class="form-actions">
                        <a class="btn btn-secondary float-right" href="{{route('borrows.index')}}">quay lại</a>
                    </div>
                </div>
                <!-- /.table-responsive -->
                <!-- .pagination -->
            </div><!-- /.card-body -->
        </div>
    </div>

    @endsection