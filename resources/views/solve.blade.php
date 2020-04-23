@extends('layouts.main')
@section('content')
@include('lissangaha')

<div class="sash">
    <div class="row">
        <div class="col">
            @if( !App\Filters\Common::hasAnyoneReachedLimit() ) @if (Cookie::get('userID') !==null) @if($lg::isExisting() && !$lg::isEligible()) @if(count($errors)>0)

                <h3 class="mt-2 text-center text-{{ $errors->all()[1]}}"> {{$errors->all()[0]}}</h3>
                @endif

                <h2>Please wait...</h2>
                <p class="text-center">
                    Your next question will appear in <span id="time-to-go"></span>
                </p>
                @else

                <form action="{{route('answer.store')}}" method="POST" id="answerForm">
                    {{csrf_field()}}
                    <section id="quiz" class="text-center">
                        <h2>Solve this quick</h2>
                        <p class="quiz">{{$question}}</p>
                        <input type="hidden" class="form-control" name="q" value="{{$q}}">
                        <input type="text" class="form-control" required id="answer" name="answer" {{$lg::isEligible()?'':'disabled'}} placeholder="Your Answer">
                        <button class="btn btn-lg btn-primary" {{$lg::isEligible()?'':'disabled'}}>Climb Now!</button>
                        @if($lg::isEligible())
                        <p>Question expires in <span id="q-expire"></span> seconds</p>
                        @endif
                    </section>
                </form>
                @endif



                @else
                @if(count($errors)>0)
                <div class="text-center alert alert-danger alert-dismissible fade show hide-print" id="absolute-alert" role="alert">

                    @foreach($errors->all() as $err )
                    {{$err}}
                    @endforeach

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <section id="teamSelect">
                    <h2>Select your team</h2>
                    <form action="{{route('user.store')}}" method="POST">
                        {{csrf_field()}}
                        <input type="hidden" class="form-control mb-3" name="ip" placeholder="Your Employee ID" value="{{$_SERVER['REMOTE_ADDR']}}">
                        <input type="text" class="form-control mb-3" name="emp_id" placeholder="Your Employee ID" value="{{old('emp_id')}}" required>
                        <select id="team" class="form-control" name="division" required>
                            <option value="">Select your team...{{old('division')}}</option>
                            @foreach(\App\Filters\Common::$divisions as $key=>$val)
                            <option value="{{$key}}" {{(old('division') != "" && old('division') == $key) ? 'selected': ''}}>{{$val}}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-lg btn-primary">Select</button>
                    </form>
                </section>
                @endif
                @else
                <h2>Game Over!</h2>
                <p class="text-center">Thank you for participating</p>
                <a href="{{route('home')}}" class="btn btn-lg btn-primary">Back to home</a>
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
            $(this).text(event.strftime('%M minutes and %S seconds'));
            if (event.elapsed) {
                window.location.reload(false);
            }

        }).SECONDS;
</script>

@endif


@if($lg::isEligible())
<script type="text/javascript">
    var counter = {{$lg::$config['questionAnswerSeconds']}};
    var isPaused;

    var interval = setInterval(function() {
        counter--;
        $("#q-expire").html(counter);
        if (counter == 0) {
            $("#answerForm").submit();
            clearInterval(interval);
        }
    }, 1000);
</script>
@endif
@endsection