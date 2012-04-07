<div id="content">

	<table id="course_selection_table">
	<?php foreach($soft_eng_courses as $year => $semesters): ?>
		<tr><td colspan='6'><h1><?=$year?></h1></td></tr>
		<?php foreach($semesters as $semester => $course_list): ?>
            <?php
            if ( $semester == 'Fall' ) {
                $semesterID = 2;
            }
            else {
                $semesterID = 4;
            }
            ?>
			<tr><td colspan='6'><h2><?=$semester?></h2></td></tr>
			<?php foreach($course_list as $course): ?>
            <?php
            $scrapeURL = "/scraper/scrapetest/debug/".$course['code'].'/'.$course['number'].'/'.$semesterID;
            ?>
				<tr>
					<td><?php echo (isset($course['code']) ? 
										$course['code'] : "Unknown")?></td>
					<td><?php echo (isset($course['number']) ? 
										$course['number'] : "Unknown")?></td>
					<td><?php echo (isset($course['title']) ? 
										$course['title'] : anchor( site_url($scrapeURL), "Unknown; test scraper." ) )?></td>
					<td><?php echo (isset($course['credit']) ? 
										$course['credit'] : "Unknown")?></td>
					<td><?php echo anchor('http://fcms.concordia.ca/fcms/asc002_stud_all.aspx?yrsess=2011'.$semesterID.'&course='.$course['code'].'&courno='.$course['number'],'View FCMS page');  ?>
             
                    <!-- Place a link to the parser here. At the end, generate links to all courses. -->
                    <td><?php echo anchor( site_url($scrapeURL), "Test scraper" ) ?></td>
				</tr>
			<?php endforeach; ?>
		<?php endforeach; ?>	
	<?php endforeach; ?>
	
	</table>

    <br />

    <?php
    function displayOptionalCourse( $course ) {
        ?>
        <td><?php echo $course['code'] ?></td>
        <td><?php echo $course['number'] ?></td>
        <td>
        <?php
        if ( isset($course['title']) ) {
            echo $course['title'];
        }
        else {
            if ( (!$course['Fall']) && (!$course['Winter']) ) {
                echo "Course not offered.";
            }
            else {
                if ( !$course['Fall'] ) {
                    echo "<b>Failed to scrape fall.</b>";
                }
                else {
                    echo "<b>Failed to scrape winter.</b>";
                }
            }
        }
        ?>
        </td>
        <td><?php echo $course['credit'] ?></td>
        
        <?php
        $fcmsFallLinkText = 'FCMS Fall';
        $scraperFallLinkText = "Test scraper (Fall)";
        if ( ! $course['Fall'] ) {
            $fcmsFallLinkText = 'N/A';
            $scraperFallLinkText = "N/A";
        }
        
        $fcmsWinterLinkText = 'FCMS Winter';
        $scraperWinterLinkText = "Test scraper (Winter)";
        if ( ! $course['Winter'] ) {
            $fcmsWinterLinkText = 'N/A';
            $scraperWinterLinkText = "N/A";
        }
        ?>
        
        <td><?php echo anchor('http://fcms.concordia.ca/fcms/asc002_stud_all.aspx?yrsess=2011'.'2'.'&course='.$course['code'].'&courno='.$course['number'],$fcmsFallLinkText);  ?></td>
        <td><?php echo anchor('http://fcms.concordia.ca/fcms/asc002_stud_all.aspx?yrsess=2011'.'4'.'&course='.$course['code'].'&courno='.$course['number'],$fcmsWinterLinkText);  ?></td>
 
        <!-- Place a link to the parser here. At the end, generate links to all courses. -->
        <?php $scrapeURLFall = "/scraper/scrape/debug/".$course['code'].'/'.$course['number'].'/2'; ?>
        <?php $scrapeURLWinter = "/scraper/scrape/debug/".$course['code'].'/'.$course['number'].'/4'; ?>
        <td><?php echo anchor( site_url($scrapeURLFall), $scraperFallLinkText ) ?></td>
        <td><?php echo anchor( site_url($scrapeURLWinter), $scraperWinterLinkText ) ?></td>
        
        <?php
    }
    ?>
    
    <h1>Optional Courses:</h1>
    <table id="option-courses" class="course-list">
        <?php foreach($option_courses as $groupName => $groupCourses): ?>
            <tr><td colspan="8"><b><?php echo $groupName; ?></b></td></tr>
            <?php if ( (array_key_exists(0, $groupCourses)) &&
                       (array_key_exists('code', $groupCourses[0])) ): ?>
                <!--  foreach on the courses. -->
                <?php foreach( $groupCourses as $course ): ?>
                <tr>
                <?php displayOptionalCourse($course) ?>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <?php foreach ( $groupCourses as $subGroup => $subGroupCourses ): ?>
                    <tr><td colspan="8"><b><?php echo $groupName.' / '.$subGroup; ?></b></td></tr>
                    <!-- foreach on the courses. -->
                    <?php foreach( $subGroupCourses as $course ): ?>
                    <tr>
                    <?php displayOptionalCourse($course) ?>
                    </tr>
                    <?php endforeach; ?>

                <?php endforeach; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>

</div>
