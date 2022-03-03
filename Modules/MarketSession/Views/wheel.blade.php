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
        <script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js"></script>
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
                        onClick="startSpin();"
                    >
                        <p style="{color: white}" align="center">Sorry, your browser doesn't support canvas. Please try another.</p>
                    </canvas>
                </td>
            </tr>
        </table>
        
        <script>
            // Create new wheel object specifying the parameters at creation time.
            let theWheel = new Winwheel({
                'outerRadius'     : 400,        // Set outer radius so wheel fits inside the background.
                'innerRadius'     : 75,         // Make wheel hollow so segments don't go all way to center.
                'textFontSize'    : 24,         // Set default font size for the segments.
                'responsive'   : true, 
                'textOrientation' : 'vertical', // Make text vertial so goes down from the outside of wheel.
                'textAlignment'   : 'outer',    // Align text to outside of wheel.
                'numSegments'     : 24,         // Specify number of segments.
                'segments'        :             // Define segments including colour and text.
                [                               // font size and test colour overridden on backrupt segments.
                   {'fillStyle' : '#ee1c24', 'text' : '300'},
                   {'fillStyle' : '#3cb878', 'text' : '450'},
                   {'fillStyle' : '#f6989d', 'text' : '600'},
                   {'fillStyle' : '#00aef0', 'text' : '750'},
                   {'fillStyle' : '#f26522', 'text' : '500'},
                   {'fillStyle' : '#000000', 'text' : 'BANKRUPT', 'textFontSize' : 16, 'textFillStyle' : '#ffffff'},
                   {'fillStyle' : '#e70697', 'text' : '3000'},
                   {'fillStyle' : '#fff200', 'text' : '600'},
                   {'fillStyle' : '#f6989d', 'text' : '700'},
                   {'fillStyle' : '#ee1c24', 'text' : '350'},
                   {'fillStyle' : '#3cb878', 'text' : '500'},
                   {'fillStyle' : '#f26522', 'text' : '800'},
                   {'fillStyle' : '#a186be', 'text' : '300'},
                   {'fillStyle' : '#fff200', 'text' : '400'},
                   {'fillStyle' : '#00aef0', 'text' : '650'},
                   {'fillStyle' : '#ee1c24', 'text' : '1000'},
                   {'fillStyle' : '#f6989d', 'text' : '500'},
                   {'fillStyle' : '#f26522', 'text' : '400'},
                   {'fillStyle' : '#3cb878', 'text' : '900'},
                   {'fillStyle' : '#000000', 'text' : 'BANKRUPT', 'textFontSize' : 16, 'textFillStyle' : '#ffffff'},
                   {'fillStyle' : '#a186be', 'text' : '600'},
                   {'fillStyle' : '#fff200', 'text' : '700'},
                   {'fillStyle' : '#00aef0', 'text' : '800'},
                   {'fillStyle' : '#ffffff', 'text' : 'LOOSE TURN', 'textFontSize' : 12}
                ],
                'animation' :           // Specify the animation to use.
                {
                    'type'     : 'spinToStop',
                    'duration' : 10,    // Duration in seconds.
                    'spins'    : 3,     // Default number of complete spins.
                    'callbackFinished' : alertPrize,
                    'callbackSound'    : playSound,   // Function to call when the tick sound is to be triggered.
                    'soundTrigger'     : 'pin'        // Specify pins are to trigger the sound, the other option is 'segment'.
                },
                'pins' :				// Turn pins on.
                {
                    'number'     : 24,
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
                // Stop and rewind the sound if it already happens to be playing.
                audio.pause();
                audio.currentTime = 0;

                // Play the sound.
                audio.play();
            }

            // Vars used by the code in this page to do power controls.
            let wheelPower    = 1;
            let wheelSpinning = false;

            // -------------------------------------------------------
            // Click handler for spin button.
            // -------------------------------------------------------
            function startSpin()
            {
                // Ensure that spinning can't be clicked again while already running.
                if (wheelSpinning == false) {
                    // Based on the power level selected adjust the number of spins for the wheel, the more times is has
                    // to rotate with the duration of the animation the quicker the wheel spins.
                    if (wheelPower == 1) {
                        theWheel.animation.spins = 3;
                    } else if (wheelPower == 2) {
                        theWheel.animation.spins = 6;
                    } else if (wheelPower == 3) {
                        theWheel.animation.spins = 10;
                    }

                    // Disable the spin button so can't click again while wheel is spinning.
                    // document.getElementById('spin_button').src       = "spin_off.png";
                    // document.getElementById('spin_button').className = "";

                    // Begin the spin animation by calling startAnimation on the wheel object.
                    theWheel.startAnimation();

                    // Set to true so that power can't be changed and spin button re-enabled during
                    // the current animation. The user will have to reset before spinning again.
                    wheelSpinning = true;
                }
            }

            // -------------------------------------------------------
            // Function for reset button.
            // -------------------------------------------------------
            function resetWheel()
            {
                theWheel.stopAnimation(false);  // Stop the animation, false as param so does not call callback function.
                theWheel.rotationAngle = 0;     // Re-set the wheel angle to 0 degrees.
                theWheel.draw();                // Call draw to render changes to the wheel.

                document.getElementById('pw1').className = "";  // Remove all colours from the power level indicators.
                document.getElementById('pw2').className = "";
                document.getElementById('pw3').className = "";

                wheelSpinning = false;          // Reset to false to power buttons and spin can be clicked again.
            }

            // -------------------------------------------------------
            // Called when the spin animation has finished by the callback feature of the wheel because I specified callback in the parameters.
            // -------------------------------------------------------
            function alertPrize(indicatedSegment)
            {
                // Just alert to the user what happened.
                // In a real project probably want to do something more interesting than this with the result.
                if (indicatedSegment.text == 'LOOSE TURN') {
                    alert('Sorry but you loose a turn.');
                } else if (indicatedSegment.text == 'BANKRUPT') {
                    alert('Oh no, you have gone BANKRUPT!');
                } else {
                    alert("You have won " + indicatedSegment.text);
                }
            }
        </script>
    </body>
</html>
