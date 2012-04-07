<div id="content">


    <?php echo "$code $number  - $title" ?>

    <!--
    <table>
        <tr><td>Code </td><td><? echo $code; ?></td></tr>
        <tr><td>Number </td><td><?php echo $number ?></td></tr>
        <tr><td>Title </td><td><?php echo $title ?></td></tr>
    </table>
    -->

    <hr />
    Section: <br />
    <?php print_r($section); ?>
    <hr />

    <br />
    <br />
    Prerequisites: <br />
    <?php print_r($prerequisite); ?> <br />
    <hr />

    <!--
    foreach ( $course['prerequisite'] as $prereqGroup ) {
        foreach ( $prereqGroup as $prereq ) {
    -->
    
    <br />
    <div id="container">


        <?php
            if(!empty($course_lecture)) {
                foreach ( $course_lecture as $lectureSection => $lectureInfo ) {
                    echo "Section: "  . $lectureSection 		 . '<br />' .
                         "Teacher: "  . $lectureInfo['Teacher']  . '<br />' .
                         "Location: " . $lectureInfo['Location'] . '<br />' .
                         "Time: " 	  . $lectureInfo['Time'] 	 . '<br />';
                    // TODO: Move in-line CSS into a CSS file.
                    if(!empty($lectureInfo['Tutorials'])){
                        foreach ( $lectureInfo['Tutorials'] as $tutorialSection => $tutorialInfo ) {
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
                    } else if(!empty($lectureInfo["Labs"])) {
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

        ?>
    </div>

    <!-- <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p> -->
</div>