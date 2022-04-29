<!--
    Winhweel.js wheel of fortune example by Douglas McKechie @ www.dougtesting.net
    See website for tutorials and other documentation.

    The MIT License (MIT)

    Copyright (c) 2016 Douglas McKechie

    Permission is hereby granted, free of charge, to any person obtaining a copy
    of this software and associated documentation files (the "Software"), to deal
    in the Software without restriction, including without limitation the rights
    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the Software is
    furnished to do so, subject to the following conditions:

    The above copyright notice and this permission notice shall be included in all
    copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
    SOFTWARE.
-->
<html>
    <head>
        <title>Lucky wheel</title>
        <link rel="stylesheet" href="{{ static_asset('assets/css/wheel.css') }}" type="text/css" />
        <script type="text/javascript" src="{{ static_asset('assets/js/Winwheel.min.js') }}"></script>
        <script src="{{ static_asset('assets/js/TweenMax.min.js') }}"></script>
        <script src="{{ static_asset('assets/js/vendors.js') }}"></script>
    </head>
    <body>
        <div align="center">
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="438" height="582" class="the_wheel" align="center" valign="center">
                        <canvas id="canvas" width="800" height="800"
                            data-responsiveMinWidth="180"
                            data-responsiveScaleHeight="true"
                            data-responsiveMargin="0"
                        >
                            <p style="{color: white}" align="center">Sorry, your browser doesn't support canvas. Please try another.</p>
                        </canvas>
                    </td>
                </tr>
            </table>
            
            <table class="winning_prize" id="winning_prize">
                <tr>
                    <th>Quà tặng</th>
                    <th>Người trúng thưởng</th>
                </tr>
                @php
                    $giftWheelDecode = json_decode($giftWheel);
                    $wheelResultDecode = json_decode($wheelResult);
                @endphp
                @foreach($giftWheelDecode as $gift)
                    @php
                        $giftUser = '';
                        for($i=0; $i<$current_turn; $i++){
                            if(isset($wheelResultDecode[$i])){
                                if($gift->uuid == $wheelResultDecode[$i]->uuid){
                                    $giftUser = $wheelResultDecode[$i]->user->name;
                                }
                            }
                        }
                    @endphp
                    <?php 
                    ?>
                    <tr>
                        <td> {{ $gift->name }} </td>
                        <td id="{{ $gift->uuid }}"> {{ $giftUser }}</td>
                    </tr>
                @endforeach
                
            </table>
        </div>
        <script>
            let userInWheel = '{!! $userInWheel !!}';
            let giftWheel = '{!! $giftWheel !!}';
            let numberOfPin = '{!! $numberOfPin !!}';
            let wheelResult = '{!! $wheelResult !!}';
            let current_turn = '{!! $current_turn !!}';
            let max_turn = '{!! $max_turn !!}';
            let duration = 10;
            // Create new wheel object specifying the parameters at creation time.
            let theWheel = new Winwheel({
                'outerRadius'     : 400,
                'innerRadius'     : 75,
                'textFontSize'    : 24,
                'responsive'   : true, 
                'textOrientation' : 'vertical', 
                'textAlignment'   : 'outer',
                'numSegments'     : numberOfPin,
                'segments': JSON.parse(userInWheel),
                'animation' : 
                {
                    'type'     : 'spinToStop',
                    'duration' : duration,
                    'spins'    : 3,
                    'callbackFinished' : resetWheel,
                    'callbackSound'    : playSound,
                    'soundTrigger'     : 'pin'
                },
                'pins' :
                {
                    'number'     : numberOfPin,
                    'fillStyle'  : 'silver',
                    'outerRadius': 4,
                    'responsive' : true,
                }
            });

            // Loads the tick audio sound in to an audio object.
            let audio = new Audio("{{ static_asset('assets/media/tick.mp3') }}");

            // This function is called when the sound is to be played.
            function playSound()
            {
                audio.pause();
                audio.currentTime = 0;
                audio.play();
            }


            let wheelPower    = 1;
            let wheelSpinning = false;

            function startSpin(position)
            {
                if (wheelSpinning == false) {
                    if (wheelPower == 1) {
                        theWheel.animation.spins = 3;
                    } else if (wheelPower == 2) {
                        theWheel.animation.spins = 6;
                    } else if (wheelPower == 3) {
                        theWheel.animation.spins = 10;
                    }
                    calculatePrize(position);

                    theWheel.startAnimation();

                    wheelSpinning = true;
                }
            }

            function calculatePrize(position) {
                var stopAt = theWheel.getRandomForSegment(position);
                theWheel.animation.stopAngle = stopAt;
                theWheel.startAnimation();
            }

            function resetWheel()
            {
                let angle = theWheel.getRotationPosition();
                theWheel.stopAnimation(false);
                theWheel.rotationAngle = angle;
                theWheel.draw();

                wheelSpinning = false;
            }

            function timer(ms) { return new Promise(res => setTimeout(res, ms)); }

            async function task(i, time) {
                $.ajax({
                    url: '{{route("lucky_wheel.sync_wheel_turn")}}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        market_id: "{{ $marketId }}",
                        currentTurn: parseInt(i)+1
                    },
                    success: function(data){
                        
                    }
                });
                await startSpin((wheelResult[i].position)+1);
                await timer(time);

                theWheel.segments[wheelResult[i].position+1].text = "";
                theWheel.draw();
                $(`#${wheelResult[i].uuid}`).html(wheelResult[i].user.name);
            }

            $(document).ready(async function(){
                wheelResult = JSON.parse(wheelResult);
                
                for(var j = 0; j < current_turn-1; j++){
                    theWheel.segments[wheelResult[j].position+1].text = "";
                }
                theWheel.draw();

                var intervalTime = (duration+4)*1000;
                await timer(4000);

                for (var i = current_turn; i < max_turn; i++) {
                    await task(i, intervalTime);
                }
            });
        </script>
    </body>
</html>
