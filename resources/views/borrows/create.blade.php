@extends('layouts.master')
@section('content')
<header class="page-title-bar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">
                <a href="{{route('borrows.index')}}"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Quản Lý Thiết
                    Bị </a>
            </li>
        </ol>
    </nav>
    <h1 class="page-title">Thêm Thiết Bị</h1>
</header>
<div class="page-section">
    <form method="post" action="{{route('borrows.store')}}" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
                <legend>Thông tin cơ bản</legend>

                <div class="form-group">
                    <label for="exampleSelectGender">Người mượn<abbr name="Trường bắt buộc">*</abbr></label>
                    <select class="form-control" name="user_id">
                        <option value="">--Vui lòng chọn--</option>
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->any())
                    <p style="color:red">{{ $errors->first('user_id') }}</p>
                    @endif
                </div>


                <div class="form-group">
                    <label for="tf1">Ngày mượn<abbr name="Trường bắt buộc">*</abbr></label> <input name="borrow_date"
                        type="date" class="form-control" id="" placeholder="Nhập ngày mượn">
                    <small id="" class="form-text text-muted"></small>
                    @if ($errors->any())
                    <p style="color:red">{{ $errors->first('borrow_date') }}</p>
                    @endif
                </div>


            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <legend>Chi tiết phiếu mượn</legend>

                <div class="row">
                    <div class="col">
                        <select id="devices" class="form-control" name="state"></select>
                    </div>
                    <div class="col-lg-2">
                        <button id="addToDanhSach" class="btn btn-primary" type="button">Thêm vào danh sách</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tên</th>
                                        <th>Tên bài dạy</th>
                                        <th>Số lượng</th>
                                        <th>Buổi</th>
                                        <th>Tiết PCTT</th>
                                        <th>Lớp</th>
                                        <th>Tiết TKB</th>
                                        <th>Ngày trả</th>
                                        <!-- <th>Ngày trả</th> -->
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="device_list">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a class="btn btn-secondary float-right" href="{{route('borrows.index')}}">Hủy</a>
                    <button class="btn btn-primary ml-auto" type="submit">Lưu</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section('footer_scripts')

<script>
$(document).ready(function() {
    var device_ids = [];
    $('#devices').select2({
        ajax: {
            url: "{{ route('borrows.devices') }}",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    searchName: params.term, // Change "term" to "searchName"
                    page: params.page
                };
            },
            processResults: function(data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        placeholder: 'Chọn một tùy chọn',
        minimumInputLength: 1
    });

    function remove_device(){
        alert(1)
    }
    var device_template = `
        <tr>
            <td>DEVICE_STT</td>
            <td>DEVICE_NAME <input name="devices[id][]" type="hidden" value="DEVICE_ID"></td>
            <td> <input name="devices[lesson_name][]" type="text" class="form-control input-sm"> </td>
            <td width="100"> <input name="devices[quantity][]" type="number" class="form-control input-sm"> </td>
            <td width="120">
                <select name="devices[session][]" class="form-control">
                    <option value="Sáng">Sáng</option>
                    <option value="Sáng">Sáng</option>
                    <option value="Sáng">Sáng</option>
                </select>
            </td>
            <td width="100"> <input name="devices[lecture_name][]" type="text" class="form-control input-sm"> </td>
            <td>
                <select name="devices[room_id][]" class="form-control">
                    <option value="">Chọn lớp</option>
                    <option value="1">10C</option>
                    <option value="2">A11</option>
                </select>
            </td>
            <td width="100">
                <select name="devices[lecture_number][]" class="form-control">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">4</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </td>
            <td> <input name="devices[return_date][]" type="date" class="form-control input-sm"> </td>
            <td>
                <button data-id="DEVICE_ID" type="button" class="btn btn-sm btn-icon btn-secondary remove-device"><i
                        class="far fa-trash"></i></button>
            </td>
        </tr>
    `;

    $('#addToDanhSach').on('click', function() {
        var device_id = $('#devices').val();
        if(device_id){
            if( device_ids.indexOf(device_id) >= 0 ){
                alert('Thiết bị này đã có trong danh sách');
                return false;
            }

            var device_name = $('#devices option:selected').text();
            var device_item = device_template;
            device_item = device_item.replace('DEVICE_STT',device_id);
            device_item = device_item.replaceAll('DEVICE_ID',device_id);
            device_item = device_item.replace('DEVICE_NAME',device_name);
            $('#device_list').append(device_item);
            device_ids.push(device_id);

            $('#devices').val('');
            $('#devices').trigger('change')
        }else{
            alert('Vui lòng lựa chọn thiết bị');
        }
        
        
    });

    $('body').on('click','.remove-device', function() {
        let device_id = $(this).data('id');
        device_ids = device_ids.filter(item => item !== device_id)
        $(this).closest('tr').remove();
    });

    


});
</script>
@endsection