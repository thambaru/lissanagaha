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

            @if (Cookie::get('userID') !== null)
            {{Cookie::get('userID')}}
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
                @if(isset($message))
                {{$message}}
                @endif
            </form>
            @else
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
            @endif


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
            if (event.elapsed) {
                window.location.reload(false);
            }

        });
</script>

@endif
@endsection