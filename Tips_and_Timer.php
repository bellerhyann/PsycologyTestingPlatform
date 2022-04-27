<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"> 
	<title>Bootstrap</title>
	<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <title>Timer</title>
    <script>
        var hour,minute,second;//
        hour=minute=second=0;//
        var millisecond=0;//millisecond
        var int;
        function reset()//reset
        {
            window.clearInterval(int);
            millisecond=hour=minute=second=0;
            console.log("Reset called");
        }
 
        function start()//start
        {
            int=setInterval(timer,50);
        }
 
        function timer()//count
        {
            millisecond=millisecond+50;
            if(millisecond>=1000)
            {
                millisecond=0;
                second=second+1;
            }
            if(second>=60)
            {
                second=0;
                minute=minute+1;
            }
 
            if(minute>=60)
            {
                minute=0;
                hour=hour+1;
            }
        }
 
        function stop()//stop
        {
            window.clearInterval(int);
        }
    </script>
</head>
<body onload="reset();start();">
<div style="text-align: center">
    <!--<button type="button" onclick="start()">Start</button> 
	<button type="button" onclick="stop()">Stop</button> 
	<button type="button" onclick="Reset()">Reset</button>-->
	
	<!--cancel the comment can see the button and just call the stop()function can stop the Timer-->
</div>
	
	
<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
	?
</button>
<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					   tips
				</h4>
			</div>
			<div class="modal-body">
				Type the tips here
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">close
				
				</button>
				
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal -->
</div>
</body>
</html>