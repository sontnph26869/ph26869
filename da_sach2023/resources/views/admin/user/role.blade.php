@extends('layouts.admin')
@section('content')


<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Cấp vai trò User: {{$user->name}}</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="post" action="{{route('insert-role',['id'=>$user->id])}}" enctype="multipart/form-data">
                @csrf
                <label for="" class="btn btn-success">Vai trò</label>
                @foreach($role as $role)
                @if(isset($check_role))
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="role" id="{{$role->id}}" value="{{$role->name}}" {{$role->id==$check_role->id?'checked':''}}>
                    <label class="form-check-label" for="{{$role->id}}">
                        {{$role->name}}
                    </label>
                </div>
                @else
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="role" id="{{$role->id}}" value="{{$role->name}}">
                    <label class="form-check-label" for="{{$role->id}}">
                        {{$role->name}}
                    </label>
                </div>
                @endif
                @endforeach
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

</div>
@endsection