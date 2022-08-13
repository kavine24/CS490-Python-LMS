<?php
  session_start();
  
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  // if (!$_SESSION['login43211234'] || $_SESSION['role'] != "0") {
  // 	header("refresh: 3; url=http://cs490testcenter.ddns.net:50000/");
  // 	exit();
  // }

  if (!isset($_SESSION['login43211234']) || !isset($_SESSION['role'])) {
  	header("refresh: 1; url=http://cs490testcenter.ddns.net:50000/");
    exit();
  } else {
    if (!$_SESSION['login43211234'] || $_SESSION['role'] != "0") {
      header("refresh: 1; url=http://cs490testcenter.ddns.net:50000/");
      exit();
   }
  }
  
  //$_SESSION['student'] = true;
  //unset($_SESSION['logIN']);
  //unset($_SESSION['user_SESSION']);

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Home</title>
    <!--<link rel="stylesheet" href="style.css">-->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  </head>
  <body>
    <h1>Home</h1>
    <div id="takeExam">
      Take Exams<br>
    </div>
    <br><br>
    <div id="reviewExam">
      Review Exam<br>
    </div> 

    <script>
      function displayExams(){

        var requestType = 'DisplayExamsFTM';
        
        const data = {requestType};


        const options = {
          method:'POST',
          headers: {
              "Content-type": "application/json; charset=UTF-8"
          },
          body: JSON.stringify(data)
        };
        
        fetch('http://cs490testcenter.ddns.net:50000/portal/frontBrowser.php', options)
        .then(response => {
          return response.json();
        })
        .then(data => {
          const examsToTake = data.examsToTake;
          for(let i = 0; i < examsToTake.length; i++){

            button = document.createElement("input")
            button.setAttribute("type", "button");
            button.setAttribute("class", "examTakeButtons");
            button.value = "Quiz Name: " + examsToTake[i].examName + " Pts: " + examsToTake[i].totalPoints;
            
            button.addEventListener("click", function(){
              location.assign('http://cs490testcenter.ddns.net:50000/portal/s/TakeQuiz.html?examID=' + examsToTake[i].examID);
            });
            

            document.getElementById("takeExam").appendChild(button);
            document.getElementById("takeExam").appendChild(document.createElement("br"));
          }

          const examsTaken = data.examsTaken;
          for(let i = 0; i < examsTaken.length; i++){

            button = document.createElement("input")
            button.setAttribute("type", "button");
            button.setAttribute("class", "examReviewButtons");
            button.value = "Quiz Name: " + examsTaken[i].examName + " Pts: " + examsTaken[i].totalPoints;
            
            button.addEventListener("click", function(){
              location.assign('http://cs490testcenter.ddns.net:50000/portal/s/ReviewQuiz.html?examID=' + examsTaken[i].examID);
            });
            

            document.getElementById("reviewExam").appendChild(button);
            document.getElementById("reviewExam").appendChild(document.createElement("br"));
          }
        })
        .catch((error) => {
          console.error('Error:', error);
        });
                
      }; 
      
      displayExams();
    </script>
    
  </body>
</html> 