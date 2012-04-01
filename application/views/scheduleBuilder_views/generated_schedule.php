<html>
<head>
<title>This is your Possible Schedule</title>
</head>
<body>

<?php echo form_open('/somewhereFARFARAWAY');?>

      <?php
        foreach($possible_sequence as $sequence){
          echo "<hr/><br/>";
          foreach($sequence as $course){
            echo $course["id"]." ".$course["code"].$course["number"].
                 "<br/> ".$course["lecture"]["id"]." Lecture(".$course["lecture"]["section"].") ".$course["lecture"]["start_time"]."-".$course["lecture"]["end_time"].$course["lecture"]["day"]."<br/>";
            if(isset($course["tutorial"])){
              echo $course["tutorial"]["id"]."tutorial(".$course["tutorial"]["section"].") ".$course["tutorial"]["start_time"]."-".$course["tutorial"]["end_time"].$course["tutorial"]["day"]."<br/>";
            }
            if(isset($course["lab"])){
              echo "lab(".$course["lab"]["section"].")";
            }
            echo "<br/>";
          }
        echo "End of One Sequence <br/><br/>";
        echo "<hr/><br/>";
        }
      ?>

</form>

<?php echo $this->benchmark->memory_usage();  ?>

</body>
</html>
