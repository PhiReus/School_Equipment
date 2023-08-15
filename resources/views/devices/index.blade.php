<!DOCTYPE html>
<html>
<head>
    <title>List of Device</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body class="container">

<h1>List of Device</h1>
<a href="{{ route('devices.create') }}" class="btn btn-info mb-3">Create</a>
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>QuanTity</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $key => $item)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td><img width="90px" height="120px" src="{{ asset($item->image)}}" alt=""></td>
                <td>
                    <a href="{{ route('devices.edit', ['device' => $item->id]) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('devices.destroy', ['device' => $item->id]) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
