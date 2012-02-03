<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Test Page</title>
  </head>
  <body>

  <div id="container">
    <h1>Courses</h1>

    <?php
      $i=9;
      for($i; $i<=sizeOf($row)-1; $i++){
      echo "<p>{$i}:{$row[$i]} \n</p>";
      }
    ?>
  </div>

  <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>

  </body>
</html>