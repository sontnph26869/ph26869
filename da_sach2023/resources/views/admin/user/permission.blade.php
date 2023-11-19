@extends('layouts.admin')
@section('content')


<div class="container-fluid">

    <!-- Page Heading -->
    @if(isset($name_role))
    <h1 class="h3 mb-2 text-gray-800">Vai trò hiện tại: {{$name_role}}</h1>
    @endif
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="post" action="{{route('insert-permission',['id'=>$user->id])}}" enctype="multipart/form-data">
                @csrf
                <label for="" class="btn btn-success">Quyền</label>
                @foreach($permission as $per)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" 
                    @foreach($get_permission_via_role as $get)
                     @if($get->id == $per->id)
                    checked
                    @endif
                    @endforeach
                    value="{{$per->name}}" id="{{$per->id}}" name="permission[]">
                    <label class="form-check-label" for="{{$per->id}}">
                        {{$per->name}}
                    </label>
                </div>
                @endforeach
                <br>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

</div>
@endsection