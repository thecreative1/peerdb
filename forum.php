<!DOCTYPE html>
<!--HEAD-->
<html lang="en-US">
<head>
  <title>MainPage</title>
  <link rel="stylesheet" type="text/css" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">  
  <meta charset="UTF-8">
  <script type="text/javascript" src="jquery-1.11.2.min.js"></script>
  <script type="text/javascript" src="js/moments.js"></script>
</head>
<!--BODY-->
<body>

<?php include 'dbcon.php'; 
session_start();
if(isset($_SESSION['lastID']))
{
$lastID = mysqli_real_escape_string($conn,$_SESSION['lastID']);
$sql1 = "SELECT * FROM student WHERE studentID='$lastID'";
$result = mysqli_query($conn,$sql1);
  $row = mysqli_fetch_array($result);
  $groupID = $row['groupID'];
  echo "<p>Welcome: ".$row['studentName']."</p>";

  /* Start search button */
  echo '<input id="searchbox"/>';
  echo '<button class="btn btn-default" id="search-submit-button">search</button>';
  /* End Search button*/

  //get group for logged in student:   SELECT * FROM `group`
  $sql2 = "SELECT * FROM groups WHERE groupID='$groupID'";
  $result2 = mysqli_query($conn,$sql2);
  $rowG = mysqli_fetch_array($result2);
  $myForumId = $rowG['forumID'];
  $sql3 = "SELECT * FROM forum WHERE forumID='$myForumId'";
  $result3 = mysqli_query($conn,$sql3);

  echo "<ul id='threads'>";
while ($rowF = mysqli_fetch_array($result3, MYSQL_ASSOC)) {
  printf("<li><a href='%s'>%s </a> </li>", "thread.php?thread=" . $rowF["threadID"], $rowF["threadName"]);
}

  echo "</ul>";
}
?> 

<!-- OUTPUT FOR FOUND MESSAGE, CONTAING SEARCH QUERY -->
<h3 id="message-search-header">Messages containing search query:</h3>
<ul id="message-search-results">

</ul>


<!-- INPUT FIELD AND BUTTON TO ADD NEW THREAD -->
<h2>Add new thread:</h2>
<input type="text" class="input" id="new-thread-name" placeholder="New thread name"/>
<button class="btn btn-default" id="create-new-thread">add</button>

<!-- Script to add new thread -->
<script type="text/javascript">
$('#create-new-thread').on('click', function() {
  var threadname = $('#new-thread-name').val();
  $("#threads").append('<li>' + threadname + '</li>');
  <?php
    echo "$.post('newThread.php', {forum:" . $myForumId . ", tname:" . "threadname" . ", user:" . $_SESSION['lastID'] . "});";
  ?>
});
</script>

<!-- Script for search button -->
<script>
  $(function() {
    $('#search-submit-button').click(function () {
      // RETRIVE SEARCH QUERY FROM INPUT FIELD:
      var searchquery = $('#searchbox').val();
      $.ajax( {
        type:'POST',
        url:'searchForumNames.php',
        data: {'searchQuery': searchquery, 'forumID': "<?php echo $myForumId; ?>", 'groupID': "<?php echo $groupID; ?>"},
        success:function(data) {
        $("#threads").empty();
        data.forums.forEach(function(d) {
          console.log(data);
          $("#threads").append('<li><a href="thread.php?thread=' + d.forum.threadID + '">' + d.forum.threadName + '</a></li>');
        });
        $("#message-search-results").empty();
        $("#message-search-header").hide();
        var tmpDate = new Date(0);
        // APPEND FOUND MESSAGES TO OUTPUT:
        data.messages.forEach(function(d) {          
          tmpDate.setUTCSeconds(d.message.dateTime);
          var mdate = moment(tmpDate);
          //var printDate = mdate.fromNow();
          var printDate = tmpDate.toLocaleString();
          $("#message-search-results").append('<li>SenderName: ' + d.senderName + ', send at: ' + printDate + '<br>'  + d.message.message + '<br><a href="thread.php?thread=' + d.message.threadID + '">Go to thread</a></li>');
          $("#message-search-header").show();
        });
      }
      });
      });
  });
</script>

</body>
</html>