<div class="lissanagaha">
    <div class="flag"></div>
    <div class="pole"></div>
    <div class="teams">
        @foreach($teams as $key=>$teamName)
        @if($score[$key] > -10)
        <?php 
        $climb =   $score[$key] / 250 * 10;

        if($climb > 75){
            $climb = 75;
        }elseif($climb == 0){
            $climb = -15;
        }
          

        ?>
        <div class="team {{$key%2==0 ? 'right' : ''}}" style="bottom:{{$climb}}vh">
            <div class="point"></div>
            <div class="arrow"></div>
            <div class="box">{{$teamName}}</div>
        </div>
        @endif
        @endforeach
    </div>
</div>