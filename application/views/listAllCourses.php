<html>
<head>
<title>Choose Your Courses for this semester</title>
</head>
<body>

<?php echo form_open('SchedulerBuilder/listAllCourses'); ?>
    <?php foreach ($courseList as $course ):
        echo "<input type='checkbox' name=''value=''/>".$course[2]."<br/>";
    endforeach;
    ?>
    <div><input type="submit" value="Submit" /></div>
</form>

</body>
</html>
