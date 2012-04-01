<html>
<head>
<title>My Form</title>
</head>
<body>

<!-- return form validator error if there is any -->
<?php echo validation_errors(); ?>


<?php echo form_open($url); ?>
    <table border="1">
      <tr>
        <th> Schedule Preference</th>
        <th> Do you want long weekends?<small> (Friday Off)</small></th>
        <th> Fall or Winter? </th>
        <!-- <th> Year </th> --!>
      </tr>
      <tr>
        <td>
          <select name="time">
              <option value="0" >Both</option>
              <option value="day" >Day</option>
              <option value="night" >Night</option>
          </select>
        </td>
        <td>
          <select name="longWeekend">
              <option value=0 > No</option>
              <option value=1 >Yes</option>
          </select>
        </td>
        <td>
           <select name="season">
              <option value="2" >Fall <?php echo date("Y")-1; ?></option>
              <option value="4" >Winter <?php echo date("Y"); ?></option>
          </select>
        </td>
        <!-- Removed because our scope for the database is only for one year
        <td>
           <select name="year">
              <?php
                $current_year = date("Y") -1;
                for($i=0; $i < 5; $i++){ ?>
                    <option value=<?php echo $current_year+$i?> > <?php echo $current_year+$i?> </option>
                <?php }?>
          </select>
        </td>
        -->
      </tr>
    </table>
    <br/>
    <div><input type="submit" value="Proceed to Choosing Available Courses" /> </div>
</form>

</body>
</html>