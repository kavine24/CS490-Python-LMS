<?php
  session_start();
  
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  if (!$_SESSION['login43211234'] || $_SESSION['role'] != "0") {
  	header("refresh: 3; url=http://cs490testcenter.ddns.net:50000/");
  	exit();
  }
  
  //$_SESSION['student'] = true;
  //unset($_SESSION['logIN']);
  //unset($_SESSION['user_SESSION']);

?>

<!DOCTYPE html>
<html>
  <head>
    <title>NJIT Student Page</title>
    <link rel="stylesheet" href="../style.css">
  </head>
  <body>
    <h1>STUDENT LANDING PAGE</h1>
    <br><br>
    <div id="mainDiv">
      <a id="takeExamButton" href="http://cs490testcenter.ddns.net:50000/portal/sPickQuiz.html">
        <input class="userSubmit" type="submit" placeholder="Submit" value="Take Exam"/>
      </a>
      <br>
      <a id="viewExamButton" href="">
        <input class="userSubmit" type="submit" placeholder="Submit" value="View Final Results"/>
      </a>
    </div>
    <script>
      const newDiv = document.getElementById("mainDiv");
      var fname = "Welcome <?echo $_SESSION["name"]?>";
      const newContent = document.createTextNode(fname);

      newDiv.insertBefore(newContent, document.getElementById("takeExamButton"));
      newDiv.insertBefore(document.createElement("br"), document.getElementById("takeExamButton"));
    </script>
  </body>
</html>
