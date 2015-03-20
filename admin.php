<!DOCTYPE html>
<?php include 'dbcon.php'; 
session_start();

$sqladmin="SELECT * FROM admin";
$resultadmin = mysqli_query($conn,$sqladmin);
$rowadmin=mysqli_fetch_array($resultadmin);
$adminID=$rowadmin["adminID"];

if(isset($_SESSION['lastID'])&&$_SESSION['lastID']==$adminID)
{
//Admin information to be retrieved from database
$lastID = mysqli_real_escape_string($conn,$_SESSION['lastID']);
$sql = "SELECT * FROM admin WHERE adminID='$lastID'";
$result = mysqli_query($conn,$sql);
$row=mysqli_fetch_array($result);

//Student information to be retrieved from database
$sql1 = "SELECT * FROM student";
$result1 = mysqli_query($conn,$sql1);

//Group information to be retrieved from database
$sql2 = "SELECT * FROM groups";
$result2 = mysqli_query($conn,$sql2);

//Criteria information to be retrieved from database
$sql3 = "SELECT * FROM criteria";
$result3 = mysqli_query($conn,$sql3);

//Non-allocated students
$sql4 = "SELECT student.studentName FROM student WHERE student.groupID IS NULL";
$result4 = mysqli_query($conn,$sql4);

//Assessment Allocation tab
//Gets group names to assess and to be assessed
$result5 = mysqli_query($conn,$sql2);
$result6 = mysqli_query($conn,$sql2);

//Student-Group Allocation Summary
$sql7 = "SELECT COUNT(student.groupID) FROM student WHERE student.groupID IS NOT NULL"; //checks the number of "full" groupIDs
$result7 = mysqli_query($conn,$sql7);
$row7=mysqli_fetch_array($result7);

//Student and Group print
$sql8 = "SELECT student.studentName, groups.groupName FROM student INNER JOIN groups ON student.groupID = groups.groupID";
$result8 = mysqli_query($conn,$sql8);

$sql9 = "SELECT COUNT(student.studentName) FROM student WHERE student.groupID IS NULL"; //checks the number of "null" groupIDs
$result9 = mysqli_query($conn,$sql9);
$row9=mysqli_fetch_array($result9);

//assessment allocation summary
$sql10="SELECT * FROM allocation";
$result10 = mysqli_query($conn,$sql10);

?>

<!DOCTYPE html>
<!--HEAD-->
<html lang="en-US">
<head>
  <title>LoginPage</title>
  <link rel="stylesheet" type="text/css" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="css/docs.min.css">
  <link rel="stylesheet" type="text/css" href="css/formlar.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <script src="js/gen_validatorv4.js" type="text/javascript"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

  <script src="//use.edgefonts.net/mr-bedfort;bubbler-one;english-small-caps;nova-cut.js"></script>
  
  <!--JS for Submit Criteria-->
  <script src="js/submitCrit.js" type="text/javascript"></script>
  
  <!--JS for Allocate Assessment-->
  <script src="js/allocateAssessment.js" type="text/javascript"></script> 
  
  <!--JS for Allocate Group-->
  <script src="js/allocateGroup.js" type="text/javascript"></script>

  <!-- JS for default operations such as selection and activating tab content -->
  <script src="js/script.js" type="text/javascript"></script> 

  <meta charset="UTF-8">
</head>

<!--BODY-->
<body>
  <!--Title div--
  <!--Log in div-->
<div id="wrapper">
  <div class="nav-container">
    <header id="top" class="navbar bs-docs-nav" role="banner">
      <div class="container">
        <!--Navigation Bar-->
        <div class="navbar-header"></div>
        </div>
        <div class="container">
        <div class="navbar-collapse bs-navbar-collapse collapse horizontal-line-break">
          <ul id="categories" class="nav navbar-nav "> 
            <li id="toptabprofile" class="toptab profiletab active" onclick="myFunction()" role="presentation">
              <a class="toptabcontent" href="#">Profile</a>
            </li>
        
            <li id="toptabstudents" class="toptab studenttab" onclick="myFunction()" role="presentation">
              <a class="toptabcontent" href="#">Student Allocation</a>
            </li>

            <li id="toptabcriteria" class="toptab criteriatab" onclick="myFunction()" role="presentation">
              <a class="toptabcontent" href="#">Criteria</a>
            </li>

            <li id="toptabgroups" class="toptab grouptab" onclick="myFunction()" role="presentation">
              <a class="toptabcontent" href="#">Assessment Allocation</a>
            </li>

            <li id="toptabranks" class="toptab rankstab" onclick="myFunction()" role="presentation">
              <a class="toptabcontent" href="#">Ranks</a>
            </li>
          </ul>

          <!--LOGOUT button -->
          <form action="logout.php" method="post"> <!--posts to logout.php-->
            <div align="right">
              <p> </p>
              <button id="logoutbutton" type="submit" name="logout" class="button-style btn-primary">Log Out</button>
            </div>        
          </form>
      
        </div>
      </div>
    </header>
  </div>
   
  <div id="outer-container" class="conatainer bs-docs-masthead" role="main">
    <div id="inner-container" class="container">    
      <div id="profilecontent" class="panel panel-default">
        <table class="table">
          <thead>
            <th>Details</th>
            <th></th>
          </thead>
          <tbody>
            <tr>
              <td>Name:</td>
              <td>
               <?php
                echo $row['adminName'];
                ?>
              </td>
            </tr>
            </tr>
              <td>Email:</td>
              <td>
                <?php
                echo $row['adminEmail'];
                ?>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

     
      <div id="studentcontent">
        <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Student Search</h3>
            </div>
            <form id="search">
            <table class="table table-striped">
              <thead id="ammendedhead">
                <tr>
                  <th><input id="studentsearchfield" type="text" name="search"/></th>
                  <th colspan="2"=><button id="searchbutton" type="submit" name="searchbutton" class="button-style btn-primary">Search</button></th>
                </tr>
              </thead>
              <tbody id="searchResults">
              </tbody>
            </table>
             </form>
        </div>
          <script>
            $('form#search').submit(function(e){
                  e.preventDefault();

                  var $form = $(this);
                    $.ajax({
                      type:"POST",
                      url:"../peerdb/studentSearch.php",
                      data: $form.serialize(),
                      success: function(data) {
                        $('#searchResults').html(data);
                      }
                    });

                  });
          </script>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Student to Group Allocation</h3>
          </div>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Students</th>
                <th>Groups</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <!--DropDown for Student Selection-Shows all the registered students-->
              <form name='allocateGroup' method='post' id='assigntogroup'>
                <tr>
                  <td>
                    <select id='selectstudent' name='selectstudent' onchange='showForm(this)'>
                      <?php
                        while($row = mysqli_fetch_array($result1)){
                        echo "<option value='".$row['studentName']."'>".$row['studentName']."</option>";   
                        }
                      ?>
                    </select>
                  </td>
                  <!--DropDown for Group Selection--shows all of the available groups in the database-->
                  <td>
                    <select id='selectgroup' name='selectgroup' onchange='showForm(this)'>
                      <?php
                      while($row2 =  mysqli_fetch_array($result2)){
                         echo "<option value='".$row2['groupName']."'>".$row2['groupName']."</option>";     
                        }
                      ?>
                    </select>
                  </td>
                  <!--Submit button for Allocation-->
                  <td>
                    <button id='allocategroup' type="submit" class="button-style btn-primary" value='Submit'>Submit</button>
                  </td>
                </tr>
              </form>       
              <tr>
                <td colspan="3">
                  <!--Alert-->
                  <div class="alert alert-danger" style="display:none" id="alertDiv1">
                    <p id="alert1"></p>
                  </div>
                  <!--Success-->
                  <div class="alert alert-success" style="display:none" id="successDiv1">
                    <p id="success1"></p>
                  </div> 
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Students not yet Assigned to a Group</h3>
          </div>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Students</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if($row9['COUNT(student.studentName)']>=1){ //if there is at least one "null" groupID (at least one student without a group)
                  while($row4=mysqli_fetch_array($result4)){
                  
                    echo "<tr><td>".$row4['studentName']."</td>"."</tr>"; //prints the students who are waiting to be allocated to a group
                  }     
                }else{ //all groupIDs are "full" (not null)
                  echo "<tr><td>There are no students left to be allocated.</td></tr>";
                } 
              ?>    
            </tbody>
          </table>
        </div>

        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Members Within Groups</h3>
          </div>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Members</th>
                <th>Groups</th>
              </tr>
            </thead>
            <tbody>
              
              <?php
                if($row7['COUNT(student.groupID)']>=1){ //if there is at least one "non-null" value (i.e.there is at least one allocation)
                  while($row8=mysqli_fetch_array($result8)){
                  
                    echo "<tr><td>".$row8['studentName']."</td>"."<td>".$row8['groupName']."</td></tr>"; //get the matching student-group pairs
                  }
                  
                }else{ //none of the students are allocated to a group yet
                  
                  echo "<tr><td>No allocated Students were found.</td></tr>";
                }   
              ?>   

            </tbody>
          </table>
        </div>

      </div>

      <div id="criteriacontent">
        <!--Set Criteria Content-->
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Set / Change Criteria</h3>
          </div>
          <form  class="form" name="criteria" method="post">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Current Criteria</th>
                  <th>Change Criteria</th>
                </tr>
              </thead>
              <tbody>
                <form  class="form" name="criteria" method="post">

                  <?php
                    $count = 1;
                    while($row3 = mysqli_fetch_array($result3)){
                    echo "<tr><td>Criteria ".$row3['criteriaID']."</td><td class='crit'>".$row3['criteriaData']."</td>";
                    echo "<td><input type='text' id='crit".$count."' name='crit".$count."'></td></tr>";
                    $count++;
                    }
                    ?>

                </form>
                <tr>
                  <td colspan="3"><input type="submit" id="submitcriteria" value="Submit" style="float: right" class="button-style btn-primary"></td>
                  <br>
                  <!--Alert-->
                    <div class="alert alert-danger" style="display:none" id="alertDiv">
                      <p id="alert"></p>
                    </div>
                    <!--Success-->
                    <div class="alert alert-success" style="display:none" id="successDiv">
                      <p id="success"></p>
                    </div>
                </tr>
        
              </tbody>
            </table>      
          </form>
        </div>
      </div>

        <!--Assessment Content-->
        <div id="assessmentcontent">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Group to Group Assessment Allocation</h3>
            </div>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Group Assessing</th>
                  <th>Group Assessed</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <!--DropDown for Group Selection(as the Assessor)-->
                <form name='allocassessment' method='post' id='allocassessment'>
                  <tr>
                    <td>
                      <select id='fromgroup' name='fromgroup' onchange='showForm(this)'>
                        <?php
                          while($row5 = mysqli_fetch_array($result5)){
                           echo "<option value='".$row5['groupName']."'>".$row5['groupName']."</option>";
                          }
                        ?>
                      </select>
                    </td>
                    <!--DropDown for Group Selection(as the Assessed)-->
                    <td>
                      <select id='togroup' name='togroup' onchange='showForm(this)'>
                          <?php
                            while($row6=mysqli_fetch_array($result6)){
                            echo "<option value='".$row6['groupName']."'>".$row6['groupName']."</option>"; 
                            }
                          ?>
                      </select>
                    </td>
                    <!--Submit button for Allocation-->
                    <td><input type='submit' id='allocateassessment' value='Submit' class="button-style btn-primary"> </td>
                  </tr>
                </form>
              </tbody>
            </table>
            <!--Alert-->
            <div class="alert alert-danger" style="display:none" id="alertDiv2">
              <p id="alert2"></p>
            </div>
            <!--Success-->
            <div class="alert alert-success" style="display:none" id="successDiv2">
              <p id="success2"></p>
            </div>  
          </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">Groups Allocated to be Assessed</h3>
                </div>
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Group Assessing</th>
                      <th>Group Assessed</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $assessCheck=false;
                      while($row10=mysqli_fetch_array($result10)){
                        $assessCheck=true;
                        if($assessCheck==true){
                          echo "<tr><td>".$row10['senderName']."</td>"."<td>".$row10['receiverName']."</td></tr>";
                          }   
                      }
                      if($assessCheck==false){
                      echo "<tr><td>There are no allocated assessments.</td></tr>";
                      }
                    ?>    
                  </tbody>
                </table>
            </div>
        </div>
        <div id="rankstabcontent">
          <?php
            include 'rankings.php';?>
        </div>

    </div>
  </div>
 </div>

    <!--Footer Content-->
    <div id="footer"></div>

</body>

</html>
<?php } 
else{
echo "<script type='text/javascript'>
  alert('Please login first');
  url='http://localhost/project/login.html';
  window.location.replace(url);
  </script>";
}
?>