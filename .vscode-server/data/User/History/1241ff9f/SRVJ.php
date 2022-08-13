<?php
  if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
  
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  if (!isset($_SESSION['login12344321']) || !isset($_SESSION['role'])) {
  	header("refresh: 1; url=http://cs490testcenter.ddns.net:50000/");
    exit();
  } else {
    if (!$_SESSION['login12344321'] || $_SESSION['role'] != "1") {
      header("refresh: 1; url=http://cs490testcenter.ddns.net:50000/");
      exit();
   }
  }
  
?>

<!DOCTYPE html>
<html>
  <head>
    <title>NJIT Teacher Page</title>
    <link rel="stylesheet" href="/style.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  </head>
  <body>
    <header class="mainHeader">
      <h1 class="header">TEACHER LANDING PAGE</h1>
      <ul class="navLIST">
          <li><a href="http://cs490testcenter.ddns.net:50000/portal/t/Home.php">Home</a></li>
          <li><a href="http://cs490testcenter.ddns.net:50000">Sign Out</a></li>
        </ul>
      <br>
    </header>
    
    <div id=mainDiv>
      <a id="makeQuestionButton" href="http://cs490testcenter.ddns.net:50000/portal/t/CreateQuestion.html">
        <input class="btn btn-success userSubmit" type="submit" placeholder="Submit" value="Create Questions"/>
      </a>
      <br>
      <a id="makeIdButton" href="http://cs490testcenter.ddns.net:50000/portal/t/CreateQuiz.html">
        <input class="btn btn-success userSubmit" type="submit" placeholder="Submit" value="Create Quiz"/>
      </a>
      <br>
      <a id="makeIdButton" href="http://cs490testcenter.ddns.net:50000/portal/t/ReviewAndGradeExams.html">
        <input class="btn btn-success userSubmit" type="submit" placeholder="Submit" value="Grade Quizzes"/>
      </a>
    </div>

    <script>
      const newDiv = document.getElementById("mainDiv");
      var fname = "Welcome <?echo $_SESSION["name"]?>";
      const newContent = document.createTextNode(fname);

      newDiv.insertBefore(newContent, document.getElementById("makeQuestionButton"));
      newDiv.insertBefore(document.createElement("br"), document.getElementById("makeQuestionButton"));

    </script>
  </body>
</html>
