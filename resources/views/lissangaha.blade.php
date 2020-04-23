<div class="lissanagaha">
    <div class="flag"></div>
    <div class="pole"></div>
    <div class="teams">
        @foreach($teams as $key=>$val)
        @if($score[$key] > -10)
        <?php
        $climb =   $score[$key] / 250 * 10;
        if($climb > 80){
            $climb = 80;
        }elseif($climb == 0){
            $climb = -10;
        }
          

        ?>
        <div class="team {{$key%2==0 ? 'right' : ''}}" style="bottom:{{$climb}}vh">
            <div class="point"></div>
            <div class="arrow"></div>
            <div class="box">{{$teams[$key]}}</div>
        </div>
        @endif
        @endforeach
    </div>
</div>