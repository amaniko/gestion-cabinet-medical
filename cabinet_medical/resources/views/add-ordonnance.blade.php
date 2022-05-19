@extends('layouts.app')
@section('content')
<div class="pull_left">
    <link rel="" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
    @if ($errors->any())
<div class="alert alert-danger">
<strong>whoops!!!</strong> there were some problems <br><br>
<ul>
@foreach ($errors->all() as $error)
<li> {{ $error }} </li>
@endforeach 
</ul>
</div>
@endif
<form action="{{route('save.ordonnance')}}" method="POST">
  @csrf
  <h2 style="text-align: center; margin-bottom: 1em;">Add new ordonnance</h2>
<div class="game-quiz-container">
        <div class="button-box">
        <strong style="margin-top: -10em;">Nom :</strong> <input type="text" class="input-field" name="nom" id="nom" value="">
        <strong> Prénom :</strong> <br><input type="text" class="input-field" name="prenom" id="prenom" value=""> </br>
        <strong>Médicaments : </strong><br><input type="text" class="input-field" name="medicament" id="" value=""> </br>
        <strong>Le temps de prise :</strong> <br><input type="text" class="input-field"  id="heure" name="heure" value="" > </br>
        <strong>Nombre de pilules par jour :</strong> <br><input type="text" class="input-field" name="nombre" id="nombre" value=""> </br>
        <strong>Date prochain rendez-vous :</strong> <br><input type="date" class="input-field" id="rendez"  name="rendez" value="" > </br>
        <strong>Conseil :</strong><textares><input style="margin-bottom: 1.5em;" type="text" class="input-field" id="conseil" name="conseil" value=""  ></textares>
        <p> Cachet & Signature  :</p> <br> <br>
        <div class="container">
          <div class="row">
              <div class="col-md-8 col-md-offset-2">
                  <br>
                 <!-- <?php echo isset($msg)?$msg:''; ?>-->
                  <div id="sig"></div>
                  <br>
                  <button type="button" class="btn btn-danger" id="reset-btn">Clear</button>
              </div>
              <form id="signatureform" action="" style="display:none" method="post">
                  <input type="hidden" id="signature" name="signature">
                  <input type="hidden" name="signaturesubmit" value="1">
              </form>
          </div>
      </div>
        <br> <br>
        <button type="submit" class="submit-btn"> submit </button>
</div>
  </div>
</form>
</div>
  <style>
    *{
    margin: 0;
    padding: 0;
    font-family: Serif;
    box-sizing: border-box;
}
html, body{
    height: 100%;   
}
main{
    width: 100%;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    position: absolute;
}
.input-field{
	width: 100%;
	padding: 10px 0;
	margin: 5px 0;
	border-left: 0;
	border-top: 0;
	border-right: 0;
	border-bottom: 1px solid rgb(61, 12, 50);
	outline: none;
	background: transparent;
}
.game-details-container{
    width: 80%;
    height: 4rem;
    display: flex;
    justify-content: space-around;
    align-items: center;
}
.game-quiz-container{
width: 30rem;
height: 100rem;
background-color: rgb(245, 245, 245);
display: flex;
flex-direction: column;
align-items: center;
justify-content: space-around;
border-radius: 30px;  
}
.submit-btn{
	width: 50%;
	padding: 10px 20px;
	cursor: pointer;
	display: block;
	margin: auto;
	background: rgb(0, 0, 128)  ;
	border: 0;
	outline: none;
	border-radius: 30px;
}
.button-box{
	width: 25rem;
    height: 52rem;
	margin: 35px auto;
	position: relative;
	border-radius: 30px;
}
   
    </style>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
<script>
   $(document).ready(() => {
       var sig = document.getElementById('sig');
       var canvas = document.createElement('canvas');
       canvas.setAttribute('id', 'canvas');
       sig.appendChild(canvas);
       $("#canvas").attr('height', $("#sig").outerHeight());
       $("#canvas").attr('width', $("#sig").width());
       if (typeof G_vmlCanvasManager != 'undefined') {
           canvas = G_vmlCanvasManager.initElement(canvas);
       }
       
       context = canvas.getContext("2d");
       $('#canvas').mousedown(function(e) {
           var offset = $(this).offset()
           var mouseX = e.pageX - this.offsetLeft;
           var mouseY = e.pageY - this.offsetTop;

           paint = true;
           addClick(e.pageX - offset.left, e.pageY - offset.top);
           redraw();
       });

       $('#canvas').mousemove(function(e) {
           if (paint) {
               var offset = $(this).offset()
               //addClick(e.pageX - this.offsetLeft, e.pageY - this.offsetTop, true);
               addClick(e.pageX - offset.left, e.pageY - offset.top, true);
               console.log(e.pageX, offset.left, e.pageY, offset.top);
               redraw();
           }
       });

       $('#canvas').mouseup(function(e) {
           paint = false;
       });

       $('#canvas').mouseleave(function(e) {
           paint = false;
       });

       var clickX = new Array();
       var clickY = new Array();
       var clickDrag = new Array();
       var paint;

       function addClick(x, y, dragging) {
           clickX.push(x);
           clickY.push(y);
           clickDrag.push(dragging);
       }

       $("#reset-btn").click(function() {
           context.clearRect(0, 0, window.innerWidth, window.innerWidth);
           clickX = [];
           clickY = [];
           clickDrag = [];
       });

       $(document).on('click', '#btn-save', function() {
           var mycanvas = document.getElementById('canvas');
           var img = mycanvas.toDataURL("image/png");
           anchor = $("#sign");
           anchor.val(img);
           $("#sig").submit();
       });
       var drawing = false;
       var mousePos = {
           x: 0,
           y: 0
       };
       var lastPos = mousePos;
       canvas.addEventListener("touchstart", function(e) {
           mousePos = getTouchPos(canvas, e);
           var touch = e.touches[0];
           var mouseEvent = new MouseEvent("mousedown", {
               clientX: touch.clientX,
               clientY: touch.clientY
           });
           canvas.dispatchEvent(mouseEvent);
       }, false);
       canvas.addEventListener("touchend", function(e) {
           var mouseEvent = new MouseEvent("mouseup", {});
           canvas.dispatchEvent(mouseEvent);
       }, false);
       canvas.addEventListener("touchmove", function(e) {
           var touch = e.touches[0];
           var offset = $('#canvas').offset();
           var mouseEvent = new MouseEvent("mousemove", {
               clientX: touch.clientX,
               clientY: touch.clientY
           });
           canvas.dispatchEvent(mouseEvent);
       }, false);

       // Get the position of a touch relative to the canvas
       function getTouchPos(sig, touchEvent) {
           var rect = sig.getBoundingClientRect();
           return {
               x: touchEvent.touches[0].clientX - rect.left,
               y: touchEvent.touches[0].clientY - rect.top
           };
       }
       var elem = document.getElementById("canvas");
       var defaultPrevent = function(e) {
           e.preventDefault();
       }
       elem.addEventListener("touchstart", defaultPrevent);
       elem.addEventListener("touchmove", defaultPrevent);
       function redraw() {
           //
           lastPos = mousePos;
           for (var i = 0; i < clickX.length; i++) {
               context.beginPath();
               if (clickDrag[i] && i) {
                   context.moveTo(clickX[i - 1], clickY[i - 1]);
               } else {
                   context.moveTo(clickX[i] - 1, clickY[i]);
               }
               context.lineTo(clickX[i], clickY[i]);
               context.closePath();
               context.stroke();
           }
       }
   })

</script>
<style>
 #sig{
     position: relative;
     border: 2px dashed grey;
     height:150px;
     width:300px;
 }
</style>


</form>
 @endsection