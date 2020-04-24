@extends('layouts.main')
@section('content')

@include('lissangaha')
<a href="{{route('answer.create')}}" class="btn btn-primary btn-lg btn-climb" >Climb Now!</a>
<table class="table table-borderless">
    <tr>
        <th>Team</th>
        <th class="text-right">Height</th>
    </tr>
    @foreach($teams as $key=>$val)
    <tr>
        <td>{{$teams[$key]}}</td>

        <td class="text-right">{{$score[$key]}} m</td>
    </tr>
    @endforeach
</table>


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
            Your team already has all the players logged in, but still you can watch the action!
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