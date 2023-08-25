<!DOCTYPE html>
<html>
<head>
    <title>Phiếu Mượn</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">
        * {
            font-family: DejaVu Sans, sans-serif;
        }

        body {
            font-size: 13px;
            height: 100vh;

        }

        table {
            border-collapse: collapse;
            margin: 0;
            padding: 0;
        }

        td {
            vertical-align: middle;
        }

        caption {
            font-size: 15px;
            font-weight: bold;
            text-align: left;
            color: rgb(0, 102, 255);
        }

        .companyInfo {
            font-size: 13px;
            font-weight: bold;
            text-align: left;
        }

        .thongtin {
            font-size: 20px;
            font-weight: bold;
            text-align: left;
        }

        .companyImg {
            width: 200px;
            height: 200px;
        }
    </style>
</head>

<body>
    <table border="0" align="left" width="100%" style="padding: 0; margin: 0;">
        <tr>
            <td class="companyInfo" align="left" width="41%" style="padding: 0; margin: 0;">
                <p style="font-size: 50px;">&#9733;</p>
            </td>
            <td class="companyInfo" align="left" width="59%" style="padding: 0; margin: 0;">Date:
                <?php echo date('Y-m-d'); ?></td>
            <td style="padding: 0; margin: 0;"></td>
        </tr>
    </table>

    <table border="0" align="left" width="100%">
        <tr>
            <td class="companyInfo" align="left" width="41%">
                http://thptgiolinh.com/<br />
                (0533).825.433<br />
            </td>
            <td class="companyInfo" align="left" width="59%">
                Trường THPT Gio Linh<br />
                Địa chỉ : Thị Trấn Gio Linh - Huyện Gio Linh - Tỉnh Quảng Trị
            </td>
        </tr>
    </table>
    <br>
    <br>
    <br>
    <table border="0" align="left" width="100%">
        <caption align="left">Thông tin người mượn :</caption><br>
        <tr>
            <td align="left" width="41%">
                Tên giáo viên : <br>
                E-mail : <br>
                Số điện thoại : <br>
            </td>
            <td align="left" width="59%">
                {{ $item->borrow->user->name }}<br />
                {{ $item->borrow->user->email }}<br />
                {{ $item->borrow->user->phone }}<br />
            </td>
        </tr>
    </table>
    <br>
    <br>
    <br>
    <table border="1" align="left" cellpadding="5">
        <caption>Chi tiết phiếu mượn thiết bị của giáo viên : {{ $item->borrow->user->name }} </caption>
        <thead class="thead-dark">
            <tr>
                <th scope="col">Tên thiết bị</th>
                <th scope="col">Tên bài dạy</th>
                <th scope="col">Số lượng</th>
                <th scope="col">Buổi</th>
                <th scope="col">Tiết PCCT</th>
                <th scope="col">Lớp</th>
                <th scope="col">Tiết TKB</th>
                <th scope="col">Ngày trả</th>
                <th scope="col">Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td align="center">{{ $item->device->name }}</td>
                <td align="center">{{ $item->lesson_name }}</td>
                <td align="center">{{ $item->quantity }}</td>
                <td align="center">{{ $item->session }}</td>
                <td align="center">{{ $item->lecture_name }}</td>
                <td align="center">{{ $item->room->name }}</td>
                <td align="center">{{ $item->lecture_number }}</td>
                <td align="center">{{ $item->return_date }}</td>
                <td align="center">{{ $changeStatus[$item->status] }}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
