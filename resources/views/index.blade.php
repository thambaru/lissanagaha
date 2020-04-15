@extends('layouts.main')
@section('content')

<div class="lissanagaha">
    <div class="flag"></div>
    <div class="pole"></div>
    <div class="teams">
        <!-- <div class="team right">
            <div class="point"></div>
            <div class="arrow"></div>
            <div class="box">Team Sandra</div>
        </div> -->
        @foreach($teams as $key=>$val)
        <div class="team {{$key%2==0 ? 'right' : ''}}" style="bottom:{{$score[$key]}}px">
            <div class="point"></div>
            <div class="arrow"></div>
            <div class="box">{{$teams[$key]}}</div>
        </div>
        @endforeach
    </div> 
</div>
@endsection