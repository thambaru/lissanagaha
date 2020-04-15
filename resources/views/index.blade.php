@extends('layouts.main')
@section('content')
<div class="sash">
    <div class="row">
        <div class="col">
            @if(count($errors)>0)
            <div class="alert alert-danger shadow alert-dismissible fade show hide-print" id="absolute-alert" role="alert">
                <ul>
                    @foreach($errors->all() as $err )
                    <li>{{$err}}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <section id="teamSelect">
                <h1>Select your team</h1>
                <form action="{{route('user.store')}}" method="POST">
                    {{csrf_field()}}
                    <input type="hidden" class="form-control mb-3" name="ip" placeholder="Your Employee ID" value="{{$_SERVER['REMOTE_ADDR']}}">
                    <input type="text" class="form-control mb-3" name="emp_id" placeholder="Your Employee ID" value="{{old('emp_id')}}">
                    <select id="team" class="form-control" name="division">
                        <option value="1">Group Service Delivery</option>
                        <option value="2">Group Marketing</option>
                        <option value="3">Group Business Operation</option>
                    </select>
                    <button class="btn btn-lg btn-primary">Select</button>
                </form>
            </section>
        </div>
    </div>
</div>
@endsection