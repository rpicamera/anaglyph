<!DOCTYPE html>
<html>
   <head>
      <meta name="viewport" content="width=550, initial-scale=1">
      <title> Download </title>
      <link rel="stylesheet" href="css/style_minified.css" />
      <script src="js/style_minified.js"></script>
   </head>
   <body>
      <div class="container-fluid">
         <input class='btn btn-primary' onclick="window.location.href='anaglyph.php' " value='Back'>
         <hr>
         <form action="previewana.php" method="GET">
           <table style="width:100%">
             <?php
                $files = scandir('/var/www/picam/img');
                if(count($files) == 0) echo "<p>No videos/images saved</p>";
                else 
                {
                   foreach($files as $file) 
                   {
                      if($file!="." && $file!=".." && $file[0]=="t")
                      {  
                         echo "<tr style=\"border-bottom: 1px solid black;margin-top:2px;margin-bottom:2px;\" >";
                         echo "<td><img src='img/$file' width='100'></td>";
                         $ffile = substr($file,6);
                         echo "<td><input class='btn btn-primary' onclick=\"window.location.href='img/$ffile'\" value='download'></td>";
                         echo "<td><button class='btn btn-primary' type='submit' name='previewana' value='$ffile'>preview</button></td>";
                         echo "</tr>";
                      }
                   }
                }
             ?>
           </table>
         </form>
      </div>
   </body>
</html>
