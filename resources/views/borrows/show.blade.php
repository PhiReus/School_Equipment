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
            <h1 class="page-title mr-sm-auto">Phiếu Mượn #{{ $item->id }} </h1>
        </div>
    </header>

    <div class="page-section">
        <div class="card card-fluid">
            <div class="card-body">
                @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
                @endif

                <div class="row">
                    <div class="col-lg-6">
                        <table class="table table-bordered">
                            <thead class="thead-">
                                <tr>
                                    <th colspan="2">Thông tin phiếu mượn</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td> Mã </td>
                                    <td>{{ $item->id }}</td>
                                </tr>
                                
                                <tr>
                                    <td> Ngày mượn </td>
                                    <td> {{ date('d/m/Y', strtotime($item->borrow_date)) }} </td>
                                </tr>
                                
                                <tr>
                                    <td> Tình trạng </td>
                                    <td>
                                    <select name="status" class="form-control">
                                        <option value="0" @selected($item->status == 0) >Chưa trả</option>
                                        <option value="1" @selected($item->status == 1)>Đã trả</option>
                                    </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td> Trạng thái duyệt </td>
                                    <td> 
                                        <select name="approved" class="form-control">
                                            <option value="0" @selected($item->approved == 0)>Chưa xét duyệt</option>
                                            <option value="1"  @selected($item->approved == 1)> Đã xét duyệt</option>
                                            <option value="2"  @selected($item->approved == 2)> Từ chối </option>
                                        </select>    
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-6">
                        <table class="table table-bordered">
                            <thead class="thead-">
                                <tr>
                                    <th colspan="2">Thông tin người mượn</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td> Tên </td>
                                    <td>  </td>
                                </tr>
                                
                                <tr>
                                    <td> Email </td>
                                    <td> 216 </td>
                                </tr>
                                
                                <tr>
                                    <td> Số điện thoại </td>
                                    <td> 191 </td>
                                </tr>
                                <tr>
                                    <td> Ghi chú </td>
                                    <td> {{ $item->borrow_note  }} </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>


                <!-- Chi tiết thiết bị -->
              
                <div class="row">
                    <div class="col-lg-12">
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
                                        <th>Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($the_devices as $index => $the_device)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <a class="tile tile-img mr-1">
                                                <img src="{{ $the_devices[$index]->image }}" alt="Ảnh sản phẩm"
                                                    style="max-width: 100px; max-height: 100px;">
                                                <a href="#">{{ $the_devices[$index]->name }}</a>
                                        </td>
                                        <td>{{ $the_device->lesson_name }}</td>
                                        <td>{{ $the_device->quantity }}</td>
                                        <td>{{ $the_device->session }}</td>
                                        <td>{{ $the_device->lecture_name }}</td>
                                        <td>{{ $the_device->room->name }}</td>
                                        <td>{{ $the_device->lecture_number }}</td>
                                        <td>{{ $the_device->return_date }}</td>
                                        <td>
                                            <select name="status[{{ $the_device->id }}][]" class="form-control">
                                                <option value="0" {{ $the_device->status == '0' ? 'selected' : '' }}>Chưa trả
                                                </option>
                                                <option value="1" {{ $the_device->status == '1' ? 'selected' : '' }}>Đã trả</option>
                                            </select>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table><!-- /.table -->
                            <div class="form-actions">
                                <a class="btn btn-secondary float-right" href="{{route('borrows.index')}}">Quay lại</a>
                                <button class="btn btn-primary ml-auto" type="submit">Lưu</button>
                            </div>
                        </div>
                    </div>
                </div>




            </div><!-- /.card-body -->
        </div>
    </div>

    @endsection