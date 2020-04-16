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
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Sorry!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Your team has already enough members. But you can still watch the competion
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
@if(count($errors)>0)
<script type="text/javascript">
    $(window).on('load', function() {
        $('#exampleModalCenter').modal('show');
    });
</script>
@endif
@endsection