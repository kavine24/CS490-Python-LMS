2C5F2D

const options = {
          method:'POST',
          headers: {
              "Content-type": "application/json; charset=UTF-8"
          },
          body: JSON.stringify(data)
        };
        
        fetch('http://cs490testcenter.ddns.net:50000/portal/frontBrowser.php', options)
        .then(response => response.json())
        .then(data => {
          if (data.loginType === "student" && data.isValid === "yes") {
            location.assign('http://cs490testcenter.ddns.net:50000/portal/sHome.php');
          } else if (data.loginType === "teacher" && data.isValid === "yes") {
            location.assign('http://cs490testcenter.ddns.net:50000/portal/tHome.php');
          } else {
            if (!attemptMade) {
              const newDiv = document.createElement("div");

              const newContent = document.createTextNode("BAD LOGIN CREDENTIALS");
            
              newDiv.appendChild(newContent);
            
              const currentDiv = document.getElementById("divForm");
              document.body.insertBefore(newDiv, currentDiv);
              attemptMade = true;
            }
          }
        })
        .catch((error) => {
          console.error('Error:', error);
        });
        
        if (!$_SESSION['login12344321'] && $_SESSION['role'] == "1") {
  	header("refresh: 3; url=http://cs490testcenter.ddns.net:50000/");
  	exit();
  }
  
<script>
    
      const form = document.getElementById("myForm");
      function handleForm(event) { event.preventDefault(); } 
      form.addEventListener('submit', handleForm);
      
      // let attemptMade = false;
      
      function displayQuestions(){
        
        var user = document.getElementById('user').value;
        var pass = document.getElementById('pass').value;

        var requestType = 'DisplayQuestionsFTM';
        
        const data = {user, pass, requestType};
    
        const options = {
          method:'POST',
          headers: {
              "Content-type": "application/json; charset=UTF-8"
          },
          body: JSON.stringify(data)
        };
        
        fetch('http://cs490testcenter.ddns.net:50000/portal/frontBrowser.php', options)
        .then(response => response.json())
        .then(data => {
          if (data.loginType === "0") {
            location.assign('http://cs490testcenter.ddns.net:50000/portal/sHome.php');
          } else if (data.loginType === "1") {
            location.assign('http://cs490testcenter.ddns.net:50000/portal/tHome.php');
          } else {
            if (!attemptMade) {
              const newDiv = document.createElement("div");

              const newContent = document.createTextNode("BAD LOGIN CREDENTIALS");
            
              newDiv.appendChild(newContent);
            
              const currentDiv = document.getElementById("divForm");
              document.body.insertBefore(newDiv, currentDiv);
              attemptMade = true;
            }
          }
        })
        .catch((error) => {
          console.error('Error:', error);
        });
                
      };
      
    </script>
    
{
          if (!response.ok) {
            throw Error("ERROR");
          }
          return response.json();
        })
        
        
function createQuiz(){

        var requestType = 'CreateQuizFTM';
        
        const data = {requestType};
    
        const options = {
          method:'POST',
          headers: {
              "Content-type": "application/json; charset=UTF-8"
          },
          body: JSON.stringify(data)
        };
        
        fetch('http://cs490testcenter.ddns.net:50000/portal/frontBrowser.php', options)
        .then(response => response.json())
        .then(data => {})
        .catch((error) => {
          console.error('Error:', error);
        });
                
      };
      
$post_data = array('difficulty' => $difficulty, 'questionType' => $questionType, 'prompt' => $prompt, 
      'answer' => $answer, 'requestType' => $requestType), 'inputvals' => $inputvals;
      






<!DOCTYPE html>
<html>
  <head>
    <title>Create Quiz</title>
    <link rel="stylesheet" href="../style.css">
  </head>
  <body>
    <h1>Quiz Creation</h1>
    
    <div id="showQuestions">
      
    </div>
    
    <script>
      function displayQuestions(){

        var requestType = 'DisplayQuestionsFTM';
        
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
          if (!response.ok) {
            throw Error("ERROR");
          }
          return response.json();
        })
        .then(data => {
          const display = data.data
            .map(user => {
              return '<div class="quizQuestions"><p><input type="radio">${user.prompt}<input></p></div>';
            })
            .join("");
          document
            .querySelector('#showQuestions')
            .insertAdjacentHTML("afterbegin", display)
              
        })
        .catch(error => {
          console.error('Error:', error);
        });
                
      };
    </script>
    
  </body>
</html>





<script>
      const inputs = [];
      var questions;
      var attemptMade = false;

      function displayQuestions(){

        var requestType = 'DisplayQuestionsFTM';
        
        const data = {requestType};
        
        const form = document.getElementById("createExamForm");
        function handleForm(event) { event.preventDefault(); } 
        form.addEventListener('submit', handleForm);


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
          questions = data;
          for(let i = 0; i < data.length; i++){
            const div = document.createElement("div");

            const question = document.createElement("label");
            question.setAttribute("class", "container")
            question.innerHTML = data[i].question;

            checkbox = document.createElement("input")
            checkbox.setAttribute("type", "checkbox");
            span = document.createElement("span")
            span.setAttribute("type", "checkmark");

            // points for that quiz quesiton should be added here

            question.appendChild(checkbox);
            question.appendChild(span);

            div.appendChild(question);

            document.getElementById("createExamForm").insertBefore(div, document.getElementById("submit"));
            document.getElementById("createExamForm").insertBefore(document.createElement("br"), document.getElementById("submit"));
            document.getElementById("createExamForm").insertBefore(document.createElement("br"), document.getElementById("submit"));

            inputs.push(question);
          }
        })
        .catch((error) => {
          console.error('Error:', error);
        });
                
      };
      
      function submitForm(){
        
        questionIDs = [];
        numPoints = 0;
        for(let i = 0; i < inputs.length; i++){
          if(inputs[i].children[0].checked){
            questionIDs.push(questions[i].questionID);
            numPoints += questions[i].difficulty*5;
          }
        }

        examName = document.getElementById("quizName").value;
        requestType = "CreateQuizFTM";

        if(numPoints == 0){
          if (!attemptMade) {
            const newDiv = document.createElement("div");
            const newContent = document.createTextNode("Cannot Submit: Need 1 or more questions");
            newDiv.appendChild(newContent);

            document.getElementById("createExamForm").appendChild(document.createElement("br"));
            document.getElementById("createExamForm").appendChild(newDiv);
            attemptMade = true;
          }
          else{
              document.getElementById("createExamForm").lastChild.innerHTML = "Cannot Submit: Need 1 or more questions";
          }
        }else{
          const data = {examName, questionIDs, numPoints, requestType};
          
          const options = {
            method:'POST',
            headers: {
                "Content-type": "application/json; charset=UTF-8"
            },
            body: JSON.stringify(data)
          };      
          
          fetch('http://cs490testcenter.ddns.net:50000/portal/frontBrowser.php', options)
          .then(response =>  response.json())
          .then(data => {
            //console.log(data);
            if(data.didWork == 1){
                location.assign('http://cs490testcenter.ddns.net:50000/portal/t/CreateQuiz.html');
              }else{
                if (!attemptMade) {
                const newDiv = document.createElement("div");
                const newContent = document.createTextNode("Quiz already exists");
                newDiv.appendChild(newContent);

                document.getElementById("createExamForm").appendChild(document.createElement("br"));
                document.getElementById("createExamForm").appendChild(newDiv);
                attemptMade = true;
                }
                else{
                  document.getElementById("createExamForm").lastChild.innerHTML = "Quiz already exists";
                }
              } 
          })
          .catch((error) => {
            console.error('Error:', error);
          });
        }   
      };
      
      displayQuestions();
    </script>