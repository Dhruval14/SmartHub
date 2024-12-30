<?php
       include('include/connect.php');
       include('include/header.php');
       include('include/sidebar1.php')
       
        ?>
<div id="content-wrapper">

        <div class="container-fluid">
 <h2>List of Employee(s)<a href="#" data-toggle="modal" data-target="#AddEmployee" class="btn btn-sm btn-info">Add New</a></h2> 
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Age</th>
                      <th>Address</th>
                      <th>Contact Number</th>
                      <th>Position</th>
                      <th>joining Date</th>
                      <th>Options</th>
                    </tr>
                  </thead>
                  
                  <?php
// Check if a delete request is made via URL parameter
if (isset($_GET['delete'])) {
    $emp_id = $_GET['delete'];

    // Delete the employee from the database
    $deleteQuery = "DELETE FROM employees WHERE emp_id = $emp_id";
    mysqli_query($db, $deleteQuery) or die(mysqli_error($db));

    // Insert the action into logs
    date_default_timezone_set("Asia/Manila"); 
    $date1 = date("Y-m-d H:i:s");
    $remarks = "employee with ID $emp_id was deleted";  
    mysqli_query($db, "INSERT INTO logs(action,date_time) VALUES('$remarks','$date1')") or die(mysqli_error($db));

    // Redirect to the same page after deletion
    echo "<script type='text/javascript'>
            alert('Employee deleted successfully!');
            window.location = 'employees.php';
          </script>";
}
?>
              <?php

$query = "SELECT * FROM employees";
                    $result = mysqli_query($db, $query) or die (mysqli_error($db));
                  
                        while ($row = mysqli_fetch_assoc($result)) {
                                             
                            echo '<tr>';
                             echo '<td>'. $row['name'].'</td>';
                             echo '<td>'. $row['age'].'</td>';
                              echo '<td>'. $row['address'].'</td>';
                               echo '<td>'. $row['contact_number'].'</td>';
                              
                               echo '<td>'. $row['position'].'</td>';
                               echo '<td>'. $row['joining_date'].'</td>';
                               echo " ";
                               
                              //  echo '<td><a type="button" class="btn btn-sm btn-warning fa fa-edit fw-fa" href="#" data-toggle="modal" data-target="#UpdateEmployee'.$row['emp_id'].'">Edit</a>';

                              
                               echo '<td>
        <a type="button" class="btn btn-sm btn-warning fa fa-edit fw-fa" href="#" data-toggle="modal" data-target="#UpdateEmployee'.$row['emp_id'].'">Edit</a>
        <a href="employees.php?delete='.$row['emp_id'].'" class="btn btn-sm btn-danger fa fa-trash" onclick="return confirm(\'Are you sure you want to delete this employee?\');">Delete</a>
      </td>';
      ?>

 <div id="UpdateEmployee<?php echo $row['emp_id'];?>" class="modal fade" role="dialog">
              <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content" style="width: 130%">
                  <div class="modal-header"><h3>Modify Employee</h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <div class="modal-body">
                      
                        
                          <form method="POST" action="#">
                            <div class="form-group">
                            <div class="form-label-group">
                            <input type="text" id="inputName1" class="form-control" placeholder="Name" name="name" value="<?php echo $row['name']; ?>" autofocus="autofocus" required>
                            <input type="hidden" id="inputName1" class="form-control" name="id" value="<?php echo $row['emp_id']; ?>" autofocus="autofocus" required>
                            <label for="inputName1">Name</label>
                            </div>
                            </div>
                            <div class="form-group">
                            <div class="form-label-group">
                            <input type="number" id="inputAge1" class="form-control" placeholder="Age" name="age" value="<?php echo $row['age']; ?>" required>
                            <label for="inputAge1">Age</label>
                            </div>
                            </div>
                            <div class="form-group">
                            <div class="form-label-group">
                            <input type="text" id="inputAddress1" class="form-control" placeholder="Address" value="<?php echo $row['address']; ?>" name="add" required>
                            <label for="inputAddress1">Address</label>
                            </div>
                            </div>
                            <div class="form-group">
                            <div class="form-label-group">
                            <input type="text" id="inputContact1" class="form-control" placeholder="Contact Number" value="<?php echo $row['contact_number']; ?>" name="contact" required>
                            <label for="inputContact1">Contact Number</label>
                            </div>
                            </div>
                            <div class="form-group">
                            <div class="form-label-group">
                            <input type="text" id="position" class="form-control" placeholder="Position" value="<?php echo $row['position']; ?>" name="position" required>
                            <label for="position">Position</label>
                            </div>
                            </div>
                            <div class="form-group">
                            <div class="form-label-group">
                            <input type="date" id="joining_date" class="form-control" placeholder="joining_date" value="<?php echo $row['joining_date']; ?>" name="joining_date" required>
                            <label for="joining_date">joining date</label>
                            </div>
                            </div>
                            
                          
                 
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                      Close
                      <span class="glyphicon glyphicon-remove-sign"></span>
                    </button>
                    <input type="submit" name="update" value="Update" class="btn btn-success">
                  </div>
                  </form>
               
</div>
</div>
              </div>
            </div>
            <?php

            if(isset($_POST['update'])){
              $id = $_POST['id'];
  $name = $_POST['name'];
  $age = $_POST['age'];
  $add = $_POST['add'];
  $contact = $_POST['contact'];
  $position = $_POST['position'];
  $joining_date = $_POST['joining_date'];

date_default_timezone_set("Asia/Manila"); 
  // $date1 = date("Y-m-d H:i:s");
  $joining_date = date('Y-m-d', strtotime($_POST['joining_date']));

 $remarks="employee $name was updated";  
  $query = "UPDATE `employees` SET `name`='$name',`age`='$age',`address`='$add',`contact_number`='$contact',`position`='$position',`joining_date`='$joining_date' WHERE `emp_id`='$id'";
                mysqli_query($db,$query)or die (mysqli_error($db));
  mysqli_query($db,"INSERT INTO logs(action,date_time) VALUES('$remarks','$date1')")or die(mysqli_error($db));

                ?>
                <script type="text/javascript">
      alert("Employee Updated Successfully!.");
      window.location = "employees.php";
    </script>
    <?php
}
                            echo '</td> ';
                            echo '</tr> ';

                               
                        }
                        
            ?> 
           
                </table>
              </div>
              </div>
              <div id="AddEmployee" class="modal fade" role="dialog">
              <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content" style="width: 130%">
                  <div class="modal-header"><h3>Add New Employee</h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <div class="modal-body">
                      
                        
                          <form method="POST" action="#">
                            <div class="form-group">
                            <div class="form-label-group">
                            <input type="text" id="inputName" class="form-control" placeholder="Name" name="name" autofocus="autofocus" required>
                            <label for="inputName">Name</label>
                            </div>
                            </div>
                            <div class="form-group">
                            <div class="form-label-group">
                            <input type="number" id="inputAge" class="form-control" placeholder="Age" name="age" required>
                            <label for="inputAge">Age</label>
                            </div>
                            </div>
                            <div class="form-group">
                            <div class="form-label-group">
                            <input type="text" id="inputAddress" class="form-control" placeholder="Address" name="add" required>
                            <label for="inputAddress">Address</label>
                            </div>
                            </div>
                            <div class="form-group">
                            <div class="form-label-group">
                            <input type="text" id="inputContact" class="form-control" placeholder="Contact Number" name="contact" required>
                            <label for="inputContact">Contact Number</label>
                            </div>
                            </div>
                            <div class="form-group">
                            <div class="form-label-group">
                            <input type="text" id="position1" class="form-control" placeholder="Position" name="position" required>
                            <label for="position1">Position</label>
                            </div>
                            <br>
                            <div class="form-group">
                            <div class="form-label-group">
                            <input type="date" id="joining_date" class="form-control" placeholder="joining_date" name="joining_date" required>
                            <label for="joining_date">Joining Date</label>
                            </div>
                            </div>
                            
                          
                 
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                      Close
                      <span class="glyphicon glyphicon-remove-sign"></span>
                    </button>
                    <input type="submit" name="submit" value="Save" class="btn btn-success">
                  </div>
                  </form>
               
</div>
</div>
              </div>
            </div>
              <?php
if(isset($_POST['submit'])){
  $name = $_POST['name'];
  $age = $_POST['age'];
  $add = $_POST['add'];
  $contact = $_POST['contact'];
  $position = $_POST['position'];
  $joining = $_POST['joining_date'];

  date_default_timezone_set("Asia/Manila"); 
  // $date1 = date("d-m-Y H:i:s");
  $joining_date = date('Y-m-d', strtotime($_POST['joining_date'])); // Convert input to proper format
  // Ye change kiya hai jisse dikh rha hai date. 

 $remarks="employee $name was Added";  
  $query = "INSERT INTO employees(name,age,address,contact_number,position,joining_date)
                VALUES ('".$name."','".$age."','".$add."','".$contact."','".$position."','".$joining_date."')";
                mysqli_query($db,$query)or die (mysqli_error($db));
  mysqli_query($db,"INSERT INTO logs(action,date_time) VALUES('$remarks','$date1')")or die(mysqli_error($db));

                ?>
                <script type="text/javascript">
      alert("New Employee Added Successfully!.");
      window.location = "employees.php";
    </script>
    <?php
}

              include('include/scripts.php');
       include('include/footer.php');
       
        ?>