<div id="content">

	<table id="course_selection_table">
	<?php foreach($soft_eng_courses as $year => $semesters): ?>
		<tr><td colspan='5'><h1><?=$year?></h1></td></tr>
		<?php foreach($semesters as $semester => $course_list): ?>
            <?php
            if ( $semester == 'Fall' ) {
                $semesterID = 2;
            }
            else {
                $semesterID = 4;
            }
            ?>
			<tr><td colspan='5'><h2><?=$semester?></h2></td></tr>
			<?php foreach($course_list as $course): ?>
            <?php
            $scrapeURL = "/scrape/debug/".$course['code'].'/'.$course['number'].'/'.$semesterID;
            ?>
				<tr>
					<td><?php echo (isset($course['code']) ? 
										$course['code'] : "Unknown")?></td>
					<td><?php echo (isset($course['number']) ? 
										$course['number'] : "Unknown")?></td>
					<td><?php echo (isset($course['title']) ? 
										$course['title'] : anchor( site_url($scrapeURL), "Unknown; test parser." ) )?></td>
					<td><?php echo (isset($course['credit']) ? 
										$course['credit'] : "Unknown")?></td>
					<td><?php echo anchor('http://fcms.concordia.ca/fcms/asc002_stud_all.aspx?yrsess=2011'.$semesterID.'&course='.$course['code'].'&courno='.$course['number'],'View FCMS page');  ?>
             
                    <!-- Place a link to the parser here. At the end, generate links to all courses. -->
                    <td><?php echo anchor( site_url($scrapeURL), "Test parser" ) ?></td>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php endforeach; ?>	
	<?php endforeach; ?>
	
	</table>
	
	
	
</form>

</div>