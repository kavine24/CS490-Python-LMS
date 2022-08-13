<?php
  //Kavin Elamurugan: Controller
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  if($_POST['requestType'] == "LoginRequestFTM"){
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $rqtp = $_POST['requestType'];

    //Make request to backend with credentials
    $url = 'http://cs490testcenter.ddns.net:50000/back/backDatabase.php';
    $post_data = array("user" => $user, "pass" => $pass, "requestType" => "CredentialCheckMTB");

    $output = post_with_curl($url, http_build_query($post_data));

    echo $output;

    exit(0);
  }
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  else if($_POST['requestType'] == "CreateQuestionFTM"){
    $difficulty = $_POST['difficulty'];
    $questionType = $_POST['questionType'];
    $prompt = $_POST['prompt'];
    $constraints = $_POST['constraints'];
    $inputvals = $_POST['inputvals'];
    $outputvals = $_POST['outputvals'];


    
    //Make request to backend with all the details
    $url = 'http://cs490testcenter.ddns.net:50000/back/backDatabase.php';
    $post_data = array('difficulty' => $difficulty, 'questionType' => $questionType, 'prompt' => $prompt, 
    'constraints' => $constraints, 'inputvals' => $inputvals, 'outputvals'=> $outputvals, 'requestType' => 'CreateQuestionMTB');

    $output = post_with_curl($url, http_build_query($post_data));

    echo $output;

    exit(0);
  }
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  else if($_POST['requestType'] == "DisplayQuestionsFTM"){
    $url = 'http://cs490testcenter.ddns.net:50000/back/backDatabase.php';
    $post_data = array("requestType" => "GetQuestionsMTB");

    $output = post_with_curl($url, http_build_query($post_data));

    echo $output;

    exit(0);
  }
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  else if($_POST['requestType'] == "CreateQuizFTM"){
    $examName = $_POST['examName'];
    $questions = $_POST['questions'];
    $numPoints = $_POST['numPoints'];
    $url = 'http://cs490testcenter.ddns.net:50000/back/backDatabase.php';
    $post_data = array("examName" => $examName, "questions" => $questions, "numPoints" => $numPoints, "requestType" => "CreateQuizMTB");

    $output = post_with_curl($url, http_build_query($post_data));

    echo $output;

    exit(0);
  }
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  else if($_POST['requestType'] == "DisplayExamsFTM"){
    $userID = $_POST['userID'];
    $requestType = "GetExamsMTB";
    
    $url = 'http://cs490testcenter.ddns.net:50000/back/backDatabase.php';
    $post_data = array('userID' => $userID, 'requestType' => $requestType);

    $output = post_with_curl($url, http_build_query($post_data));

    echo $output;

    exit(0);
  }
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  else if($_POST['requestType'] == "GetExamFTM"){
    $examID = $_POST['examID'];

    $url = 'http://cs490testcenter.ddns.net:50000/back/backDatabase.php';
    $post_data = array('examID' => $examID, "requestType" => "GetExamQuestionsMTB");

    $output = post_with_curl($url, http_build_query($post_data));

    echo $output;

    exit(0);
  }
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  else if ($_POST['requestType'] == 'SubmitExamFTM') {
    $userID = $_POST['userID'];
    $examID = $_POST['examID'];
    $answers = $_POST['inputsFormatted'];
    $requestType = "EnterAnswersMTB";
    
    $url = 'http://cs490testcenter.ddns.net:50000/back/backDatabase.php';
    $post_data = array('userID' => $userID, 'examID' => $examID, 'answers' => $answers, 'requestType' => $requestType);
        
    $output = post_with_curl($url, http_build_query($post_data));
    
    echo $output;

    exit(0); 
  }
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  else if ($_POST['requestType'] == 'ReviewExamFTM') {
    $userID = $_POST['userID'];
    $examID = $_POST['examID'];
    $requestType = "GetStudentsAnswersMTB";
    
    $url = 'http://cs490testcenter.ddns.net:50000/back/backDatabase.php';

    $post_data = array('userID' => $userID, 'examID' => $examID, 'requestType' => $requestType);
        
    $output = post_with_curl($url, http_build_query($post_data));
    
    echo $output;
    
    exit(0); 
  }
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  else if ($_POST['requestType'] == 'GetExamTeacherFTM') {
    $requestType = "GetExamsAndStudentsMTB";
    
    $url = 'http://cs490testcenter.ddns.net:50000/back/backDatabase.php';

    $post_data = array('requestType' => $requestType);
        
    $output = post_with_curl($url, http_build_query($post_data));
    
    echo $output;
    
    exit(0); 
  }
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  else if ($_POST['requestType'] == 'ReviewExamTeacherFTM') {
    $studentExamsID = $_POST['studentExamsID'];
    $requestType = "GetStudentsAnswersTeacherMTB";
    
    $url = 'http://cs490testcenter.ddns.net:50000/back/backDatabase.php';

    $post_data = array('studentExamsID' => $studentExamsID, 'requestType' => $requestType);
        
    $output = post_with_curl($url, http_build_query($post_data));
    
    echo $output;
    
    exit(0); 
  }
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  else if ($_POST['requestType'] == 'ChangeGradesFTM') {
    $gradeChangesFormatted = $_POST['gradeChangesFormatted'];
    $requestType = "ChangeGradeAndCommentsMTB";
    
    $url = 'http://cs490testcenter.ddns.net:50000/back/backDatabase.php';
    $post_data = array('gradeChangesFormatted' => $gradeChangesFormatted, 'requestType' => $requestType);
        
    $output = post_with_curl($url, http_build_query($post_data));
    
    echo $output;

    exit(0); 
  }
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  else if($_POST['requestType'] == "AutoGradeExamFTM"){
    $examName = $_POST['examName'];
    $requestType = "GetAllOfExamMTB";

    $url = 'http://cs490testcenter.ddns.net:50000/back/backDatabase.php';
    $post_data = array('examName' => $examName, 'requestType' => $requestType);

    $output = post_with_curl($url, http_build_query($post_data));

    $outputDecoded = json_decode($output);

    $studentAnswers = $outputDecoded -> examArray;
    $cases = $outputDecoded -> caseArray;

    // print_r($studentAnswers);

    $newGrades = array();
    $pointsTable = array();
    
    for ($i = 0; $i < count($studentAnswers); $i++)
    {
      $score = 0;
      $count = 0;
      for ($j = 0; $j < count($cases); $j++)
      {
        if($studentAnswers[$i] -> questionID == $cases[$j] -> questionID){
          $count++;
        }
      }

      $sanswer = $studentAnswers[$i] -> answer;
      $f = ($f + $w + $r);
      $w = $studentAnswers[$i] -> w;
      $r = $studentAnswers[$i] -> r;

      $constsNeeded = ($f + $w + $r) > 0;
      $numConsts = ($f + $w + $r);
      $studentfunctionBody = substr($sanswer,strpos($sanswer, ':') + 1);

      $fconst = $f ? (strpos($studentfunctionBody, 'for') === FALSE ? 0 : (0.1 * $studentAnswers[$i] -> points)/$numConsts): 0;
      $wconst = $w ? (strpos($studentfunctionBody, 'while') === FALSE ? 0 : (0.1 * $studentAnswers[$i] -> points)/$numConsts): 0;
      $rconst = $r ? (strpos($studentfunctionBody, substr($sanswer,4,strpos($sanswer, '(') - 4)) === FALSE ? 0 : (0.1 * $studentAnswers[$i] -> points)/$numConsts): 0;

      $consts = ($fconst && $wconst && $rconst) === FALSE ? 0 : 1;

      $header = 0;

      for ($j = 0; $j < count($cases); $j++)
      {
        if($studentAnswers[$i] -> questionID == $cases[$j] -> questionID){
          //make file
          $execFile = fopen("tempExecFile.py", "w") or die("Unable to open file!");

          
          $tanswer = $cases[$j] -> input;

          $studentfunctionHeader = substr($sanswer,0,strpos($sanswer, '('));
          $teacherfunctionHeader = "def " . substr($tanswer,0,strpos($tanswer, '('));

          $isNotDumb = strcmp($studentfunctionHeader, $teacherfunctionHeader);

          $header = $isNotDumb == 0 ? 1 : 0;

          $tanswer = $isNotDumb != 0
           ? substr($studentfunctionHeader, strpos($studentfunctionHeader, ' ')) . substr($tanswer,strpos($tanswer, '(')) 
           : $tanswer;

          $printstr = "\nprint(" . $tanswer . ")";

          $fullstr = $sanswer . $printstr;

          fwrite($execFile, $fullstr);
          fclose($execFile);
          $execperm = "chmod 777 tempExecFile.py";
          shell_exec($execperm);

          $cmdarg = "python3 tempExecFile.py";
          $output=null;
          $retval=null;

          exec($cmdarg, $output, $retval);

          // print_r(" " . $cases[$j] -> output);
          // print_r(" " . $output[0]);
          // print_r(" | ");

          //compare answers now

          $result = $retval === 0 ? ((strcmp($cases[$j] -> output, $output[0]) == 0) ? 1: 0) : 0;

          array_push($pointsTable, array("studentAnswersID" => $studentAnswers[$i] -> studentAnswersID, 
            "caseID" => $cases[$j] -> caseID, "output" => $output[0], "pointsEarned" => (($result / $count) * (0.8 * $studentAnswers[$i] -> points)) ));

          $score += $result;
        }
      }

      $finalScore = (($score / $count) * (0.8 * $studentAnswers[$i] -> points)) 
      + ($constsNeeded ? ((0.1 * $studentAnswers[$i] -> points) * $consts) : 0) 
      + ($constsNeeded ? ((0.1 * $studentAnswers[$i] -> points) * $header) : ((0.2 * $studentAnswers[$i] -> points) * $header));

      array_push($newGrades, array("studentAnswersID" => $studentAnswers[$i] -> studentAnswersID, 
        "pointsCorrect" => $finalScore, "consts" => ($constsNeeded ? ((0.1 * $studentAnswers[$i] -> points) * $consts) : 0), 
        "fconst" => $fconst, "wconst" => $wconst, "rconst" => $rconst, 
        "header" => ($constsNeeded ? ((0.1 * $studentAnswers[$i] -> points) * $header) : ((0.2 * $studentAnswers[$i] -> points) * $header)) ));
    }
    
    $execFile = fopen("tempExecFile.py", "w") or die("Unable to open file!");
    fclose($execFile);

    // print_r($newGrades);
    // print_r($pointsTable);

    //Make request to backend with all the details

    $url = 'http://cs490testcenter.ddns.net:50000/back/backDatabase.php';
    $post_data = array('examName' => $examName, 'newGrades'=> $newGrades, 'pointsTable'=> $pointsTable, 'requestType' => 'AutoUpdateGradesMTB');

    $output = post_with_curl($url, http_build_query($post_data));
    
    echo $output;

    exit(0);
  }
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  function post_with_curl($url, $postdata){
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    
    $output = curl_exec($ch);
    curl_close($ch);

    if ($output === FALSE) {
      echo "cURL Error: " . curl_error($ch);
    }else{
      return $output;
    }
  }
  
?>
