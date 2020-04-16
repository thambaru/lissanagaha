@extends('layouts.main')
@section('content')
<a href="{{route('answer.create')}}" class="btn btn-primary float-right">Climb!</a>
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
        @if($score[$key] > 0)
        <?php
        $climb =   $score[$key] / 250 * 100
        ?>
        <div class="team {{$key%2==0 ? 'right' : ''}}" style="bottom:{{$climb}}%">
            <div class="point"></div>
            <div class="arrow"></div>
            <div class="box">{{$teams[$key]}}</div>
        </div>
        @endif
        @endforeach
    </div>
</div>
@endsection