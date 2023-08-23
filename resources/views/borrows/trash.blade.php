@extends('layouts.master')
@section('content')
<header class="page-title-bar">
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
         <li class="breadcrumb-item active">
            <a href="{{route('borrows.index')}}"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Trang Chủ</a>
         </li>
      </ol>
   </nav>
   <!-- <button type="button" class="btn btn-success btn-floated"><span class="fa fa-plus"></span></button> -->
   <div class="d-md-flex align-items-md-start">
      <h1 class="page-title mr-sm-auto">Quản Lý Phiếu Mượn - Thùng Rác</h1>
      <div class="btn-toolbar">
      </div>
   </div>
</header>
<div class="page-section">
   <div class="card card-fluid">
      <div class="card-header">
         <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
               <a class="nav-link " href="{{route('borrows.index')}}">Tất Cả</a>
            </li>
            <li class="nav-item">
               <a class="nav-link active " href="{{route('borrows.trash')}}">Thùng Rác</a>
            </li>
         </ul>
      </div>
      <div class="card-body">
         <div class="row mb-2">
            <div class="col">
            </div>
         </div>
         @if (Session::has('success'))
         <div class="alert alert-success">{{session::get('success')}}</div>
         @endif
         @if (Session::has('error'))
         <div class="alert alert-danger">{{session::get('error')}}</div>
         @endif
         <div class="table-responsive">
            <table class="table">
               <thead>
                  <tr>
                     <th>STT</th>
                     <th>Tên </th>
                     <th>Ngày mượn</th>
                     <th>Chức Năng</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($items  as $key => $item)
                  <tr>
                     <td>{{++$key}}</td>
                     <td>{{$item->user->name}}</td>
                     <td>{{$item->borrow_date}}</td>
                     <td>
                        <form action="{{ route('borrows.forceDelete',$item->id )}}" style="display:inline" method="post">
                                    <button onclick="return confirm('Xóa vĩnh viễn {{$item->name}} ?')" class="btn btn-sm btn-icon btn-secondary"><i class="far fa-trash-alt"></i></button>
                                    @csrf
                                    @method('delete')
                                </form>
                                <span class="sr-only">Edit</span></a> <a href="{{route('borrows.restore',$item->id)}}" class="btn btn-sm btn-icon btn-secondary"><i class="fa fa-trash-restore"></i> <span class="sr-only">Remove</span></a>
                     </td>
                     @endforeach
                  </tr> 
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
</div>
@endsection