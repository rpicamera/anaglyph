<?php
  define('MEDIA_DIR','img/');
  $filename = "vrset.jpg";
  if(isset($_GET['previewpano']))
  {
      $filename = $_GET['previewpano'];
  }
?>

<!doctype html>
<html>
  <head>
    <title>Anaglyph</title>
  </head>
  <body>
	    <img id="panoimg" src="<?php echo MEDIA_DIR; echo $filename; ?>">
  </body>
</html>
