@extends('layouts.main')
@section('content')
<div class="sash">
    <div class="row">
        <div class="col">
            <form action="{{route('answer.store')}}" method="POST">
                {{csrf_field()}}
                <section id="quiz">
                    <h1>Solve this quick</h1>
                    <p class="quiz">{{$question}}</p>
                    <input type="hidden" class="form-control" name="q" value="{{$q}}">
                    <input type="text" class="form-control" name="answer">
                    <button class="btn btn-lg btn-primary" {{$lg::isEligible()?'':'disabled'}}>Climb Now!</button>
                </section>

                @if($lg::isExisting() && !$lg::isEligible())
                <div class="alert alert-warning my-3">
                    නැවත උත්සාහ කරන්න <span id="time-to-go"></span>
                </div>
                @endif

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
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@if($lg::isExisting() && !$lg::isEligible())
<script type="text/javascript">
    <?php
    $next = $lg::getLast()->created_at->addMinutes($lg::$config['disallowingMinutes']);
    ?>

    $("#time-to-go")
        .countdown("{{$next->format('Y')}}/{{$next->format('m')}}/{{$next->format('d')}} {{$next->format('H')}}:{{$next->format('i')}}:{{$next->format('s')}}", function(event) {
            $(this).text(event.strftime('විනාඩි %Mයි තත්පර %Sකින්.'));
            if (event.elapsed){
                window.location.reload(false);
            }
                
        });
</script>

@endif
@endsection