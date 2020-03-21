<html>
  <head>
  </head>
  <body>
    <form action='addstudent.php' method="post">
      <input name='Name' type="text" placeholder="Name">
      <input name='Roll' type="text" placeholder="Roll Number">
      <select name='gender'>
        <option>Male</option>
        <option>Female</option>
      </select>
      <select name='category'>
        <option>JEE</option>
        <option>DASA</option>
      </select>
      <input name="DOB" type='date' placeholder="DOB">
      <input name="email" type='text' placeholder="Email ID">
      <input name="contact" type='number' placeholder="Phone Number">
      <input name="address" type='text' placeholder="Address">
      <input name='tenth' type="text" placeholder="Tenth Percentage">
      <input name='twelfth' type="text" placeholder="Twelfth Percentage">
      <input name='jee_roll' type='text' placeholder="JEE Roll Number">
      <input name='jee_rank' type="text" placeholder="JEE AIR">
      <span>First year batch</span>
      <select name='first_batch'>
        <option>B</option>
        <option>J</option>
      </select>
      <span>Current batch</span>
      <select name='batch'>
        <option>A</option>
        <option>B</option>
      </select>
      <input type="Submit">
    </form>
  </body>
</html>
