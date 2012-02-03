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
      // JUST OUTPUT TESTING. DELETE AFTER DONE OR COMMENT OUT // FUCKEN BUNCH OF LOOPS
      foreach($course_lecture as $title => $information){
        echo "<br><br>Title: ".$title."<br>";
        foreach($information as $type => $value){
          if(strcmp($type,"Tutorials")===0){
            foreach($value as $key => $value){
              echo "----------------------------------------------------<br>".$key."<br>";
               foreach($value as $key => $value){
                 if(strcmp($key,"Labs")===0){
                   foreach($value as $key => $value){
                     echo "<br>".$key."<br>";
                     foreach($value as $key => $value){
                       echo $key.": ".$value."<br>";
                     }
                   }
                 }
                 echo $key.": ".$value."<br>";
               }
            }
          }else{
            echo $type.": ".$value."<br>";
          }

        }
      }
      // END OF OUTPUT TESTING
      $i=9;
      for($i; $i<=sizeOf($row)-1; $i++){
      echo "<p>{$i}:{$row[$i]} \n</p>";
      }


    ?>
  </div>

  <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>

  </body>
</html>