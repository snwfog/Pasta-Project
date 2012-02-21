<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Test Page</title>
</head>
<body>
	<div id="container">
        <?php if(isset($title)){ ?>
            <h1><?php echo $name . ' ' . $number . ': ' . $title ?></h1>
            <?php echo anchor(site_url("/scrape"), "NEW SEARCH", null); ?>
            <hr />
    
            Prerequisites: <?php echo $prerequisites ?><br />
            <br />
        <?php }else{
          echo "<h2>Sorry, ".$name." ".$number." is not available for this semester</h1>";
          }?>

        
        <?php
            if(!empty($course_lecture)){
                foreach ( $course_lecture as $lectureSection => $lectureInfo ){
                    echo "Section: "  . $lectureSection 		 . '<br />' .
                         "Teacher: "  . $lectureInfo['Teacher']  . '<br />' .
                         "Location: " . $lectureInfo['Location'] . '<br />' .
                         "Time: " 	  . $lectureInfo['Time'] 	 . '<br />';
        			// TODO: Move in-line CSS into a CSS file.
        	         if(!empty($lectureInfo['Tutorials'])){
                             foreach ( $lectureInfo['Tutorials'] as $tutorialSection => $tutorialInfo ){
                                 echo '<div style="margin-left:50px; border:1px; border-style:solid;">';
                                      echo "Tutorial section: " . $tutorialSection 		  . '<br />' .
                                           "Location: " 		  . $tutorialInfo['Location'] . '<br />' .
                                           "Time: " 			  . $tutorialInfo['Time'];
                                     foreach( $tutorialInfo['Labs'] as $labSection => $labInfo ) {
                                              echo '<div style="margin-left:50px; border:1px; border-style:solid;">';
        	                                   echo "Lab section: " . $labSection          . '<br />' .
               		                                "Location: "    . $labInfo['Location'] . '<br />' .
               		                                "Time: "    . $labInfo['Time']     . '<br />';
                                              echo '</div>';
                                     }
                                 echo '</div>';
                             }
                         }else if(!empty($lectureInfo["Labs"])){
                             foreach ( $lectureInfo['Labs'] as $tutorialSection => $tutorialInfo ){
                                 echo '<div style="margin-left:50px; border:1px; border-style:solid;">';
                                     echo "Lab section: " . $tutorialSection .
                                          "<br> Location: " . $tutorialInfo['Location'] .
                                          "<br> Time: " . $tutorialInfo['Time'];
                                 echo '</div>';
                             }
                         }
                  }
              }
    
        /*
          foreach( $course_lecture as $title => $information ) {
            echo "<h1>Derp " . $title . "</h1><br>";
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
                     else{
                       echo '(GenKey) ' . $key.": ".$value."<br>";
                     }
                   }
                }
              }else{
                echo '(GenType) ' . $type.": ".$value."<br>";
              }
    
            }
          }
          // END OF OUTPUT TESTING
          $i=9;
          for($i; $i<=sizeOf($row)-1; $i++){
          echo "<p>DERPDERP{$i}:{$row[$i]} \n</p>";
          }
    
        */
        ?>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>

	</body>
</html>