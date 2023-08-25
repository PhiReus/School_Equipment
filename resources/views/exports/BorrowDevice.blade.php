

<table border="1" align="left" cellpadding="5" width="100%">
    <caption>Ảnh và Số Điện Thoại : </caption>
    <tr>
        <th width="60px" height="50px">Ảnh</th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th width="60%" style="font-weight: bold;">Liên Hệ : 0987654321</th>
    </tr>
</table>




<table border="1" align="left" cellpadding="5">
    <caption>Liên Hệ Và Địa Chỉ : </caption>
    <tr>
        <th width="200px" style="font-weight: bold;">
            http://thptgiolinh.com/ <br>
            032522800 - 0987654321
        </th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th width="200px" style="font-weight: bold;">
            Trường THPT Gio Linh <br>
            Địa Chỉ: Gio Linh Quảng Trị
        </th>
    </tr>
</table>

<table border="1" align="left" cellpadding="5">
    <caption>Liên Hệ Và Địa Chỉ : </caption>
    <tr>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th align="center" width="200px"><p><strong>Quản Lý Thiết Bị Mượn :</strong></p> <br></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
</table>

<table border="1" align="left" cellpadding="5" width="100%" >
    <caption>Quản Lý Thiết Bị Mượn : </caption>
    <tr>
        <th align="center" style="font-weight: bold;" width="200px" >STT</th>
        <th align="center" style="font-weight: bold;" width="200px">Người mượn</th>
        <th align="center" style="font-weight: bold;" width="200px">Tên thiết bị</th>
        <th align="center" style="font-weight: bold;" width="80px">Tên bài dạy</th>
        <th align="center" style="font-weight: bold;">Số lượng</th>
        <th align="center" style="font-weight: bold;">Buổi</th>
        <th align="center" style="font-weight: bold;">Tiết PCCT</th>
        <th align="center" style="font-weight: bold;">Lớp</th>
        <th align="center" style="font-weight: bold;">Tiết TKB</th>
        <th align="center" style="font-weight: bold;" width="80px">Trạng thái</th>
        <th align="center" style="font-weight: bold;" width="200px">Ngày mượn</th>
        <th align="center" style="font-weight: bold;" width="200px">Ngày trả</th>
    </tr>
    @foreach ($BorrowDevices as $key => $item)
        <tr>
            <td align="center">{{ ++$key }}</td>
            <td align="center">{{ $item->borrow->user->name ?? 'Người mượn không tồn tại' }}</td>
            <td align="center">{{ $item->device->name }}</td>
            <td align="center">{{ $item->lesson_name }}</td>
            <td align="center">{{ $item->quantity }}</td>
            <td align="center">{{ $item->session }}</td>
            <td align="center">{{ $item->lecture_name }}</td>
            <td align="center">{{ $item->room->name }}</td>
            <td align="center">{{ $item->lecture_number }}</td>
            <td align="center">{{ $changeStatus[$item->status] }}</td>
            <td align="center">{{ $item->borrow->borrow_date }}</td>
            <td align="center">{{ $item->return_date }}</td>
        </tr>
    @endforeach
</table>
