<?php
  error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
	ini_set('display_errors' , 1);
	
  // database connection stuff
  $servername = "db";
  $username = "dbdev";
  $password = "dbdevpass";
  $dbname = "cs490db";
	
  $db = mysqli_connect($servername, $username, $password, $dbname);
  if (mysqli_connect_errno()) {
    echo 'Failed to connect to MySQL:' . mysqli_connect_error( $db );
	  exit(0);
  }
	
  // get variables via cURL and POST
  if ($_POST['requestType'] == "CredentialCheckMTB")
  {
    $name = $_POST['user']; $pass = $_POST['pass'];
  	
  	
 	  $s = "SELECT * FROM users WHERE username = '$name'";
 	  ($t = mysqli_query ($db, $s)) or die( mysqli_error( $db )); // username check. if it exists, continue, if not, login invalid
  	$number = mysqli_num_rows($t);
  	if ($number == 0)
  		$resp = array("loginType"=>"invalid"); 
    else
    {
  	  $r = mysqli_fetch_array($t, MYSQLI_ASSOC); // get row associated with found username, then get password
      $hash = $r['password'];
   
  	  if (password_verify($pass, $hash)) // check password against hash in DB
  	  {	
  			$resp = array("loginType"=>$r['role'],"fname"=>$r['firstName'], "mname"=>$r['middleName'], 
          "lname"=>$r['lastName'], "userID"=>$r['userID']);
  	  }
  	  else
        $resp = array("loginType"=>"invalid"); // invalid if fails
    }
   // now give back a JSON of $resp
   $resp_str = json_encode($resp);
   echo $resp_str;
   mysqli_close($db);
   exit(0); 
   }

    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  
   /* MOCKUP OF HOW I THINK CODE MAY LOOK. */
  
   // creating a question
  else if ($_POST['requestType'] == 'CreateQuestionMTB')
  {
    // get all the stuff from post
    $questType = $_POST['questionType'];
    $constraints = $_POST['constraints'];
    $testIn = $_POST['inputvals'];
    $testOut = $_POST['outputvals'];
    $difficulty = $_POST['difficulty'];
    $question = $_POST['prompt'];
    
    // setting contraint values
    $f = $constraints['for'];
    $w = $constraints['while'];
    $r = $constraints['recursive'];

    // query to create the question
    $questQuery = "SELECT * FROM questions WHERE question = '$question'";
    $pointer = $db->query($questQuery);
    if ($pointer->num_rows == 0) // insert the question if it does not exist
    {
      $addQuest = "INSERT INTO questions (question, difficulty, questiontype, f, w, r) VALUES ('$question', '$difficulty', '$questType', $f, $w, $r);";
      $db->query($addQuest) or die('Error saving question!');

      $questionID = $db->insert_id;
      $questReturn = array("didWork"=>1);
      for ($i = 0; $i < count($testIn); $i++)
      {
        $addCases = "INSERT INTO cases (questionID, input, output) VALUES ($questionID,'$testIn[$i]', '$testOut[$i]');";
        $db->query($addCases) or die('Error saving test cases!');
      }
    }
    else
      $questReturn = array("didWork"=>0);

    echo json_encode($questReturn);
    mysqli_close($db);
    exit(0); 
  }
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  // getting and listing questions
  else if ($_POST['requestType'] == 'GetQuestionsMTB')
  {
    $getQuests = "SELECT * FROM questions";
    $pointer = $db->query($getQuests);
    $questions = array();
    while ($row = $pointer->fetch_array()) // while questions still exist, push the questions out
    {
      $questionID = $row[0];
      $question = $row[1];
      $difficulty = $row[2];
      $type = $row[3];

      array_push($questions, array("questionID" => $questionID, "question" => $question, "difficulty" => $difficulty, "type" => $type));
    }
    echo json_encode($questions);
    exit(0);
  }
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  // creating an exam. gotta make a new table for this one...
  else if ($_POST['requestType'] == 'CreateQuizMTB')
  {
    $examName = $_POST['examName'];
    $questions = $_POST['questions'];
    $totalPoints = $_POST['numPoints'];

    $examQuery = "SELECT * FROM exams WHERE examName = '$examName'"; // check if exam name exists already
    $pointer = $db->query($examQuery);
    
    if ($pointer->num_rows == 0)
    {
      $addExam = "INSERT INTO exams (examName, totalPoints) VALUES ('$examName', $totalPoints);";
      $db->query($addExam) or die('Error saving exam!');
      $examID = $db->insert_id;
      $examReturn = array("didWork"=>1);
      for ($i = 0; $i < count($questions); $i++)
      {
        $questionID = $questions[$i]['questionID'];
        $points = $questions[$i]['points'];
        $addExamQuestions = "INSERT INTO examQuestions (examID, questionID, points) VALUES ($examID, $questionID, $points);";
        $db->query($addExamQuestions) or die('Error saving exam questions!');
      }
    }
    else
      $examReturn = array("didWork"=>0);
    
    echo json_encode($examReturn);
    exit(0);
  }
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  // getting and listing exams
  else if ($_POST['requestType'] == 'GetExamsMTB')
  { 
    $userID = $_POST['userID'];
    
    $getExamsToTake = "SELECT * FROM exams WHERE exams.examID NOT IN (SELECT examID FROM studentExams WHERE userID = $userID)";
    $pointer1 = $db->query($getExamsToTake);
    $examsToTake = array();
    while ($row = $pointer1->fetch_array()) // while exams still exist, push the exams out
    {
      $examID = $row[0];
      $examName = $row[1];
      $totalPoints = $row[2];

      array_push($examsToTake, array("examID" => $examID, "examName" => $examName, "totalPoints" => $totalPoints));
    }

    $getExamsTaken = "SELECT * FROM exams WHERE exams.examID IN (SELECT examID FROM studentExams WHERE userID = $userID)";
    $pointer2 = $db->query($getExamsTaken);
    $examsTaken = array();
    while ($row = $pointer2->fetch_array()) // while exams still exist, push the exams out
    {
      $examID = $row[0];
      $examName = $row[1];
      $totalPoints = $row[2];

      array_push($examsTaken, array("examID" => $examID, "examName" => $examName, "totalPoints" => $totalPoints));
    }
    $r = array("examsToTake" => $examsToTake, "examsTaken" => $examsTaken);
    
    echo json_encode($r);
    exit(0);
  }
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  // getting and listing exam questions
  else if ($_POST['requestType'] == 'GetExamQuestionsMTB')
  {
    $examID = $_POST['examID'];
    $getExamData = "SELECT examName, totalPoints FROM exams WHERE examID = $examID";
    $pointer = $db->query($getExamData);

    $questions = array();
    array_push($questions, $pointer->fetch_array());

    $getExam = "SELECT Q.questionID, Q.question, Q.difficulty, Q.questiontype, points FROM questions as Q " . 
    "INNER JOIN examQuestions AS E ON Q.questionID = E.questionID WHERE examID = $examID;";

    $pointer = $db->query($getExam);
    
    while ($row = $pointer->fetch_array()) // while questions still exist, push the questions out
    {
      $questionID = $row[0];
      $question = $row[1];
      $difficulty = $row[2];
      $type = $row[3];
      $points = $row[4];

      array_push($questions, array("questionID" => $questionID, "question" => $question, "difficulty" => $difficulty, "type" => $type, "points" => $points));
    }

    echo json_encode($questions);
    exit(0);
  }
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  else if ($_POST['requestType'] == 'EnterAnswersMTB')
  {
    $userID = $_POST['userID'];
    $examID = $_POST['examID'];
    $answers = $_POST['answers'];
    $totalPoints = 0;
    $pointsCorrect = 0;
    $comments = "";
    
    $submitExam = "INSERT INTO studentExams (userID, examID, totalPoints) VALUES ($userID, $examID, $totalPoints);";
    $db->query($submitExam) or die('Error submitting exam!');
    $studentExamsID = $db->insert_id;

    for ($i = 0; $i < count($answers); $i++)
    {
      $questionID = $answers[$i]['questionID'];
      $answer = $answers[$i]['answer'];
      $submitAnswers = "INSERT INTO studentAnswers (studentExamsID, questionID, answer, pointsCorrect, comments, headerCorrect, fCorrect, wCorrect, rCorrect) VALUES ($studentExamsID, $questionID, '$answer', $pointsCorrect, '$comments', 0, 0, 0, 0);";
      $db->query($submitAnswers) or die('Error saving exam answers!');
    }

    $examReturn = array("didWork"=>1);

    echo json_encode($examReturn);
    exit(0);
  }
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  else if ($_POST['requestType'] == 'GetStudentsAnswersMTB')
  {
    $userID = $_POST['userID'];
    $examID = $_POST['examID'];

    $getExamData = 
    "SELECT S.studentExamsID, S.examID, E.examName, S.totalPoints as PointsEarned, E.totalPoints as TotalPoints " .
    "FROM studentExams as S " . 
    "INNER JOIN exams as E on S.examID = E.examID " .
    "WHERE (S.userID = $userID AND S.examID = $examID);";

    $pointer1 = $db->query($getExamData) or die('Error getting exam!');
    $row = $pointer1->fetch_array();
    $examData = array("studentExamsID" => $row[0], "examID" => $row[1], "examName" => $row[2], "PointsEarned" => $row[3], "TotalPoints" => $row[4]);
    $studentExamsID = $row[0];

    $answers = array();

    $getAnswers = 
    "SELECT A.studentExamsID, A.questionID, Q.questiontype, Q.difficulty, Q.question, A.answer, " . 
    "A.pointsCorrect, E.points, A.comments, A.headerCorrect, fCorrect, wCorrect, rCorrect, Q.f, Q.w, Q.r " .
    "FROM studentAnswers as A " .
    "INNER JOIN questions as Q ON A.questionID = Q.questionID " .
    "INNER JOIN studentExams as S on A.studentExamsID = S.studentExamsID " . 
    "INNER JOIN (Select * from examQuestions where examID in (Select examID from studentExams where studentExamsID = $studentExamsID)) as E ON E.questionID = Q.questionID " .
    "WHERE (A.studentExamsID = $studentExamsID);";

    $pointer2 = $db->query($getAnswers);

    while ($row = $pointer2->fetch_array())
    {
      $getCases = "Select c.caseID, c.input as Input, c.output as Expected, p.output as Recieved, p.pointsEarned " . 
      "From pointsTable as p " . 
      "Inner Join cases as c on c.caseID = p.caseID " . 
      "Where p.studentAnswersID in (Select studentAnswersID from studentAnswers " . 
      "Where studentExamsID = $row[0] and questionID = $row[1]);";

      $pointsTable = array();
      $pointer3 = $db->query($getCases);

      while ($row2 = $pointer3->fetch_array())
      {
        array_push($pointsTable, array("caseID" => $row2[0], "input" => $row2[1], "expected" => $row2[2], 
          "recieved" => $row2[3], "correct" => $row2[4]));
      }

      array_push($answers, array("studentExamsID" => $row[0], "questionID" => $row[1], "type" => $row[2], 
        "difficulty" => $row[3], "question" => $row[4], "answer" => $row[5], "pointsCorrect" => $row[6], 
        "points" => $row[7], "comments" => $row[8], "headerCorrect" => $row[9],  
        "fCorrect" => $row[10], "wCorrect" => $row[11], "rCorrect" => $row[12], 
        "fNeeded" => $row[13], "wNeeded" => $row[14], "rNeeded" => $row[15], "pointsTable" => $pointsTable));
    }
      
    //echo json_encode(array("examData" => $examData));
    echo json_encode(array("examData" => $examData, "answers" => $answers));
    exit(0);
  }
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  else if ($_POST['requestType'] == 'GetExamsAndStudentsMTB')
  {
    $getExams = "Select * From exams;";
    $result = array();
    $pointer1 = $db->query($getExams);

    while ($row1 = $pointer1->fetch_array())
    {
      $examID = $row1[0];
      $getStudentExams = 
      "SELECT S.studentExamsID, S.userID, S.examID, S.totalPoints, U.firstName, U.lastName FROM studentExams AS S " .
      "INNER JOIN users AS U ON S.userID = U.userID " .
      "WHERE examID = $examID;";

      $subresult = array();
      $pointer2 = $db->query($getStudentExams);
      while ($row2 = $pointer2->fetch_array())
      {
        array_push($subresult, array("studentExamsID" => $row2[0], "userID" => $row2[1], "examID" => $row2[2], 
        "totalPoints" => $row2[3], "firstName" => $row2[4], "lastName" => $row2[5]));
      }
      $result[$row1[1]] = $subresult;
    }
    
    echo json_encode($result);
    exit(0);
  }
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  else if ($_POST['requestType'] == 'GetStudentsAnswersTeacherMTB')
  {
    $studentExamsID = $_POST['studentExamsID'];

    $getExamData = 
    "SELECT S.studentExamsID, S.examID, E.examName, S.totalPoints as PointsEarned, E.totalPoints as TotalPoints " .
    "FROM studentExams as S " . 
    "INNER JOIN exams as E on S.examID = E.examID " .
    "WHERE (S.studentExamsID = $studentExamsID);";

    $pointer1 = $db->query($getExamData) or die('Error getting exam!');
    $row = $pointer1->fetch_array();
    $examData = array("studentExamsID" => $row[0], "examID" => $row[1], "examName" => $row[2], "PointsEarned" => $row[3], "TotalPoints" => $row[4]);

    $answers = array();

    $getAnswers = 
    "SELECT A.studentExamsID, A.questionID, Q.questiontype, Q.difficulty, Q.question, A.answer, " . 
    "A.pointsCorrect, E.points, A.comments, A.headerCorrect, fCorrect, wCorrect, rCorrect, Q.f, Q.w, Q.r " .
    "FROM studentAnswers as A " . 
    "INNER JOIN questions as Q ON A.questionID = Q.questionID " .
    "INNER JOIN studentExams as S on A.studentExamsID = S.studentExamsID " . 
    "INNER JOIN (Select * from examQuestions where examID in (Select examID from studentExams where studentExamsID = $studentExamsID)) as E ON E.questionID = Q.questionID " .
    "WHERE (A.studentExamsID = $studentExamsID);";

    $pointer = $db->query($getAnswers);

    while ($row = $pointer->fetch_array())
    {
      $getCases = "Select p.pointsTableID, c.caseID, c.input as Input, c.output as Expected, p.output as Recieved, p.pointsEarned " . 
      "From pointsTable as p " . 
      "Inner Join cases as c on c.caseID = p.caseID " . 
      "Where p.studentAnswersID in (Select studentAnswersID from studentAnswers " . 
      "Where studentExamsID = $row[0] and questionID = $row[1]);";
      
      $pointsTable = array();
      $pointer3 = $db->query($getCases);

      while ($row2 = $pointer3->fetch_array())
      {
        array_push($pointsTable, array("pointsTableID" => $row2[0], "caseID" => $row2[1], "input" => $row2[2], "expected" => $row2[3], 
          "recieved" => $row2[4], "correct" => $row2[5]));
      }

      array_push($answers, array("studentExamsID" => $row[0], "questionID" => $row[1], "type" => $row[2], 
        "difficulty" => $row[3], "question" => $row[4], "answer" => $row[5], "pointsCorrect" => $row[6], 
        "points" => $row[7], "comments" => $row[8], "headerCorrect" => $row[9],  
        "fCorrect" => $row[10], "wCorrect" => $row[11], "rCorrect" => $row[12], 
        "fNeeded" => $row[13], "wNeeded" => $row[14], "rNeeded" => $row[15], "pointsTable" => $pointsTable));
    }

    //echo json_encode(array("examData" => $examData));
    echo json_encode(array("examData" => $examData, "answers" => $answers));
    
    exit(0);
  }
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  else if ($_POST['requestType'] == 'ChangeGradeAndCommentsMTB')
  {
    $gradeChangesFormatted = $_POST['gradeChangesFormatted'];
    $sum = 0.0;
    $studentExamsID = "";
    for ($i = 0; $i < count($gradeChangesFormatted); $i++)
    {
      $studentExamsID = $gradeChangesFormatted[$i]['studentExamsID'];
      $questionID = $gradeChangesFormatted[$i]['questionID'];
      $totalPoints = $gradeChangesFormatted[$i]['totalPoints'];
      $newPointsTable = $gradeChangesFormatted[$i]['newPointsTable'];
      $functionCorrect = $gradeChangesFormatted[$i]['newConstraints']['functionCorrect'];
      $fCorrect = $gradeChangesFormatted[$i]['newConstraints']['fCorrect'];
      $wCorrect = $gradeChangesFormatted[$i]['newConstraints']['wCorrect'];
      $rCorrect = $gradeChangesFormatted[$i]['newConstraints']['rCorrect'];
      $comments = $gradeChangesFormatted[$i]['comments'];
      
      $sum += $totalPoints;

      $changeQuestion = "UPDATE studentAnswers " .
      "SET pointsCorrect = $totalPoints, headerCorrect = $functionCorrect, fCorrect = $fCorrect, wCorrect = $wCorrect, rCorrect = $rCorrect, comments = '$comments' " .
      "WHERE studentExamsID = $studentExamsID AND questionID = $questionID;";

      $db->query($changeQuestion) or die('Error saving question grade!');
      if($newPointsTable != "emptyLOL"){
        for ($j = 0; $j < count($newPointsTable); $j++){
          $pointsEarned = $newPointsTable[$j]['pointsEarned'];
          $pointsTableID = $newPointsTable[$j]['pointsTableID'];
  
          $updatePointsTable = "UPDATE pointsTable " .
          "SET pointsEarned = $pointsEarned " .
          "WHERE pointsTableID = $pointsTableID";
  
          $db->query($updatePointsTable) or die('Error saving pointsTable!');
        }
      }
    }

    $changeExam = "UPDATE studentExams " .
    "SET totalPoints = $sum " .
    "WHERE studentExamsID = $studentExamsID;";
      
      $db->query($changeExam) or die('Error saving exam grade!');

    $examReturn = array("didWork"=>1);

    echo json_encode($examReturn);
    exit(0);
  }
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  else if($_POST['requestType'] == 'GetAllOfExamMTB')
  {
    $examName = $_POST['examName'];

    $getExam = 
    "SELECT studentAnswersID, studentExamsID, questions.questionID, answer, pointsCorrect, points, f, w, r " . 
    "FROM studentAnswers " . 
    "INNER JOIN questions ON studentAnswers.questionID = questions.questionID " . 
    "INNER JOIN (Select * from examQuestions where examID in (SELECT examID FROM exams WHERE examName = '$examName')) as E ON studentAnswers.questionID = E.questionID " . 
    "WHERE studentExamsID IN (SELECT studentExamsID FROM studentExams " . 
    "WHERE examID IN (SELECT examID FROM exams WHERE examName = '$examName'));";

    $pointer1 = $db->query($getExam) or die('Error getting exam!');

    $getCases = "SELECT * FROM cases " .
    "WHERE questionID IN (SELECT questionID FROM examQuestions " .
    "WHERE examID IN (SELECT examID FROM exams WHERE examName = '$examName'));";
    
    $pointer2 = $db->query($getCases) or die('Error getting cases!');

    $examArray = array();
    $caseArray = array();

    while ($row1 = $pointer1->fetch_array())
    {
      array_push($examArray, array("studentAnswersID" => $row1[0], "studentExamsID" => $row1[1], 
        "questionID" => $row1[2], "answer" => $row1[3], "pointsCorrect" => $row1[4], 
        "points" => $row1[5],"f" => $row1[6], "w" => $row1[7], "r" => $row1[8]));
    }

    while ($row2 = $pointer2->fetch_array())
    {
      array_push($caseArray, array("caseID" => $row2[0], "questionID" => $row2[1], "input" => $row2[2], "output" => $row2[3]));
    }

    echo json_encode(array("examArray" => $examArray, "caseArray" => $caseArray));

    exit(0);
  }
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  else if ($_POST['requestType'] == 'AutoUpdateGradesMTB')
  {
    $examName = $_POST['examName'];
    $newGrades = $_POST['newGrades'];
    $pointsTable = $_POST['pointsTable'];

    // print_r($pointsTable);

    for ($i = 0; $i < count($newGrades); $i++)
    {
      $p = $newGrades[$i]['pointsCorrect'];
      $h = $newGrades[$i]['header'];
      $f = $newGrades[$i]['fconst'];
      $w = $newGrades[$i]['wconst'];
      $r = $newGrades[$i]['rconst'];
      $studentAnswersID = $newGrades[$i]['studentAnswersID'];

      $updateGrade = "UPDATE studentAnswers " .
      "SET pointsCorrect = $p, headerCorrect = $h, " .
      "fCorrect = $f, wCorrect = $w, rCorrect = $r " . 
      "WHERE studentAnswersID = $studentAnswersID;";
      $db->query($updateGrade) or die('Error updating test grades!');
    }

    for ($i = 0; $i < count($pointsTable); $i++)
    {
      $s = $pointsTable[$i]['studentAnswersID'];
      $c = $pointsTable[$i]['caseID'];
      $o = $pointsTable[$i]['output'];
      $p = $pointsTable[$i]['pointsEarned'];

      $updatepointsTable = 
      "INSERT INTO pointsTable " . 
      "(studentAnswersID, caseID, output, pointsEarned) " . 
      "VALUES ($s, $c, '$o', $p) " . 
      "ON DUPLICATE KEY UPDATE output= '$o', pointsEarned= $p;";

      $db->query($updatepointsTable) or die('Error updating test grades!');
    }

    $changeExam = 
    "WITH newGrades AS (SELECT studentExamsID, SUM(pointsCorrect) AS totalPoints " .
    "FROM studentAnswers GROUP BY studentExamsID) " .
    "UPDATE studentExams as S " .
    "INNER JOIN newGrades ON S.studentExamsID = newGrades.studentExamsID " .
    "SET S.totalPoints = newGrades.totalPoints;";
    
    $db->query($changeExam) or die('Error updating test grades!');

    $examReturn = array("didWork"=>1);

    echo json_encode($examReturn);
  }
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
?>
