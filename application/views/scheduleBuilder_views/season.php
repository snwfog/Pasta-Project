<html>
<head>
<title>My Form</title>
</head>
<body>

<!-- return form validator error if there is any -->
<?php echo validation_errors(); ?>


<?php echo form_open('schedulebuilder/listAllAllowedCourses'); ?>
    <table border="1">
      <tr>
        <th> Time Preference</th>
        <th> Do you want long weekends?</th>
        <th> Fall or Winter? </th>
      </tr>
      <tr>
        <td>
          <select name="time">
              <option value="0" > </option>
              <option value="day" >Day</option>
              <option value="night" >Night</option>
          </select>
        </td>
        <td>
          <input type='checkbox' name='longweekend[]' value="1" />
        </td>
        <td>
           <select name="season">
              <option value="2" >Fall</option>
              <option value="4" >Winter</option>
          </select>
        </td>
      </tr>
    </table>
    <br/>
    <div><input type="submit" value="Proceed to Choosing Available Courses" /> </div>
</form>

</body>
</html>