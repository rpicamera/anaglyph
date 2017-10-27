<?php
   define('BASE_DIR', dirname(__FILE__));
   require_once(BASE_DIR.'/config.php');

   if (isset($_POST['shoot'])) 
   {
      startShooting();
   } 

   function startShooting() {
      writeLog("start take ana pictures");
      exec("python anaglyph.py");
      writeLog("Photo taking finished");
   }
?>

<!doctype html>
<html>
  <head>
    <title>Dual Camera</title>
    <link rel="stylesheet" href="css/style_minified.css" />
    <script src="js/style_minified.js"></script>
  </head>
  <body>
    <div class="container-fluid">
      <div id="background" onclick="toggle_fullscreen(this);">
        <img style="width:320" id="mjpeg_left">
        <img style="width:320" id="mjpeg_right">
        <hr>
        <table style='margin-left: 80px;' >
          <form action="panoindex.php" method="POST">
            <td><button style='margin-left:10px;' class='btn btn-primary' type='submit' name='shoot'>shoot</button></td>
            <br>
          </form> 
          <td><input style='margin-left:20px' onclick="window.location.href = 'downloadana.php' " class="btn btn-default" value="Download" ></td>
        </table>
        <hr>
      </div>

    <script src="http://code.jquery.com/jquery-1.11.1.js"></script>
    <script type="text/javascript">
      //
      // MJPEG
      //
      var $mjpeg_left_img =$("#mjpeg_left");
      var $mjpeg_right_img=$("#mjpeg_right");
      
      var localhost=location.host;
      var ip = localhost;
      var ip_left ="http://"+ip+":80/picam";
      var ip_right="http://"+ip+":80/picam"; 
      $mjpeg_left_img[0].src =ip_left +"/loading.jpg"
      $mjpeg_right_img[0].src=ip_right+"/loading.jpg"
      
      var halted = 0;
      var previous_halted = 99;
      var mjpeg_mode = 0;
      var preview_delay = 50000;

      $(function() {
          
          reload_img();
          reload_slave_img();
          updatePreview(true);
      });

      function toggle_fullscreen(e) {

          var background = document.getElementById("background");

          if(!background) {
              background = document.createElement("div");
              background.id = "background";
              document.body.appendChild(background);
          }
        
          if(e.className == "fullscreen") {
              e.className = "";
              background.style.marginTop = 0 + 'px';
          }
          else {
              e.className = "fullscreen";
              background.style.marginTop = 50 + 'px';
          }
      }

      function reload_img () {
          if(!halted) 
          {
              $mjpeg_left_img[0].src = ip_left+"/cam_pic.php?time=" + new Date().getTime() + "&pDelay=" + preview_delay;
          }
          else 
          {
              setTimeout("reload_img()", 500);
          }
      }

      function reload_slave_img(){
          if(!halted) 
          {
              $mjpeg_left_img[0].src  = ip_right +"/cam_slave_pic.php?time=" + new Date().getTime() + "&pDelay=" + preview_delay;
          }
          else 
          {
              setTimeout("reload_slave_img()", 1000);
          }
      }

      function error_img () {
          setTimeout("mjpeg_left_img.src  = "+ip_left +"'/cam_pic.php?time='       + new Date().getTime();", 100);
          setTimeout("mjpeg_right_img.src = "+ip_right+"'/cam_slave_pic.php?time=' + new Date().getTime();", 100);
      }

      function updatePreview(cycle)
      {
          if (cycle !== undefined && cycle == true)
          {
              $mjpeg_left_img[0].src = ip_left +"/updating.jpg";
              $mjpeg_right_img[0].src= ip_right+"/updating.jpg";
              setTimeout("$mjpeg_left_img[0].src = \" " + ip_left + "/cam_pic_new.php?time=\"       + new Date().getTime()  + \"&pDelay=\" + preview_delay;", 1000);
              setTimeout("$mjpeg_right_img[0].src= \" " + ip_right+ "/cam_slave_pic_new.php?time=\" + new Date().getTime()  + \"&pDelay=\" + preview_delay;", 1000);
              return;
          }
        
          if (previous_halted != halted)
          {
              if(!halted)
              {
                  $mjpeg_right_img[0].src = ip_right +"/cam_slave_pic.php?time=" + new Date().getTime() + "&pDelay=" + preview_delay;
                  $mjpeg_left_img[0].src  = ip_left  +"/cam_pic.php?time="       + new Date().getTime() + "&pDelay=" + preview_delay;
              }
              else
              {
                  $mjpeg_left_img[0].src  = ip_left +"/updating.jpg";
                  $mjpeg_right_img[0].src = ip_right+"/updating.jpg";
              }
          }
          previous_halted = halted;

      }
    </script>
  </div>
  </body>
</html>


