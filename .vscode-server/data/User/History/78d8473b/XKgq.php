<?php

  session_start();
  
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  
  $json = file_get_contents("php://input");
  $data = json_decode($json, true);
  
  
  if ($data['requestType'] == 'LoginRequestFTM') {
    $user = $data['user'];
    $pass = $data['pass'];
    $requestType = $data['requestType'];
    
    $url = 'http://cs490testcenter.ddns.net:50000/middle/middleController.php';

    $post_data = array('user' => $user, 'pass' => $pass, 'requestType' => $requestType);
        
    $output = post_with_curl($url, $post_data);
    //print_r($output);
    $r = json_decode($output, true);

    if($r['loginType'] == "1"){
      $_SESSION['login12344321'] = true;
      $_SESSION['name'] = $r['fname'] . ' ' . $r['lname'];
      $_SESSION['role'] = $r['loginType'];
      $_SESSION['userID'] = $r['userID'];
    }
    else if($r['loginType'] == "0"){
      $_SESSION['login43211234'] = true;
      $_SESSION['name'] = $r['fname'] . ' ' . $r['lname'];
      $_SESSION['role'] = $r['loginType'];
      $_SESSION['userID'] = $r['userID'];
    }

    echo $output;
    
    exit(0);   
  }
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  else if ($data['requestType'] == 'CreateQuestionFTM') {
   
    $difficulty = $data['difficulty'];
    $questionType = $data['questionType'];
    $prompt = $data['prompt'];
    $constraints = $data['constraints'];
    $inputvals = $data['inputvals'];
    $outputvals = $data['outputvals'];
    $requestType = $data['requestType'];
    

    $url = 'http://cs490testcenter.ddns.net:50000/middle/middleController.php';

    $post_data = array('difficulty' => $difficulty, 'questionType' => $questionType, 'prompt' => $prompt, 
      'constraints' => $constraints, 'inputvals' => $inputvals, 'outputvals' => $outputvals, 'requestType' => $requestType);
        
    $output = post_with_curl($url, http_build_query($post_data));
    
    echo $output;
    
    exit(0); 
  }
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  else if ($data['requestType'] == 'DisplayQuestionsFTM') {
   
    $requestType = $data['requestType'];
    

    $url = 'http://cs490testcenter.ddns.net:50000/middle/middleController.php';

    $post_data = array('requestType' => $requestType);
        
    $output = post_with_curl($url, http_build_query($post_data));
    
    echo $output;
    
    exit(0); 
  }
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  else if ($data['requestType'] == 'CreateQuizFTM') {
    $examName = $data['examName'];
    $questions = $data['submitted'];
    $numPoints = $data['totalPoints'];
    $requestType = $data['requestType'];
    

    $url = 'http://cs490testcenter.ddns.net:50000/middle/middleController.php';

    $post_data = array('examName' => $examName, 'questions' => $questions, 'numPoints' => $numPoints, 'requestType' => $requestType);
        
    $output = post_with_curl($url, http_build_query($post_data));
    
    echo $output;
    
    exit(0); 
  }
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  else if ($data['requestType'] == 'DisplayExamsFTM') {
    $userID = $_SESSION['userID'];
    $requestType = $data['requestType'];
    

    $url = 'http://cs490testcenter.ddns.net:50000/middle/middleController.php';

    $post_data = array('userID' => $userID, 'requestType' => $requestType);
        
    $output = post_with_curl($url, http_build_query($post_data));
    
    echo $output;
    
    exit(0); 
  }
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  else if ($data['requestType'] == 'GetExamFTM') {
    $examID = $data['examID'];
    $requestType = $data['requestType'];
    
    $url = 'http://cs490testcenter.ddns.net:50000/middle/middleController.php';

    $post_data = array('examID' => $examID, 'requestType' => $requestType);
        
    $output = post_with_curl($url, http_build_query($post_data));
    
    echo $output;
    
    exit(0); 
  }
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  else if ($data['requestType'] == 'SubmitExamFTM') {
    $userID = $_SESSION['userID'];
    $examID = $data['examID'];
    $inputsFormatted = $data['inputsFormatted'];
    $requestType = $data['requestType'];
    
    $url = 'http://cs490testcenter.ddns.net:50000/middle/middleController.php';

    $post_data = array('userID' => $userID, 'examID' => $examID, 'inputsFormatted' => $inputsFormatted, 'requestType' => $requestType);
        
    $output = post_with_curl($url, http_build_query($post_data));

    echo $output;
    
    exit(0); 
  }
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  else if ($data['requestType'] == 'ReviewExamFTM') {
    $userID = $_SESSION['userID'];
    $examID = $data['examID'];
    $requestType = $data['requestType'];
    
    $url = 'http://cs490testcenter.ddns.net:50000/middle/middleController.php';

    $post_data = array('userID' => $userID, 'examID' => $examID, 'requestType' => $requestType);
        
    $output = post_with_curl($url, http_build_query($post_data));
    
    echo $output;
    
    exit(0); 
  }
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  else if ($data['requestType'] == 'GetExamTeacherFTM') {
    $requestType = $data['requestType'];
    
    $url = 'http://cs490testcenter.ddns.net:50000/middle/middleController.php';

    $post_data = array('requestType' => $requestType);
        
    $output = post_with_curl($url, http_build_query($post_data));
    
    echo $output;
    
    exit(0); 
  }
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  else if ($data['requestType'] == 'ReviewExamTeacherFTM') {
    $studentExamsID = $data['studentExamsID'];
    $requestType = $data['requestType'];
    
    $url = 'http://cs490testcenter.ddns.net:50000/middle/middleController.php';

    $post_data = array('studentExamsID' => $studentExamsID, 'requestType' => $requestType);
        
    $output = post_with_curl($url, http_build_query($post_data));
    
    echo $output;
    
    exit(0); 
  }
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  else if ($data['requestType'] == 'ChangeGradesFTM') {
    $gradeChangesFormatted = $data['gradeChangesFormatted'];
    $requestType = $data['requestType'];
    
    $url = 'http://cs490testcenter.ddns.net:50000/middle/middleController.php';

    $post_data = array('gradeChangesFormatted' => $gradeChangesFormatted, 'requestType' => $requestType);
        
    $output = post_with_curl($url, http_build_query($post_data));

    echo $output;
    
    exit(0); 
  }
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  else if ($data['requestType'] == 'AutoGradeExamFTM') {
    $examName = $data['examName'];
    $requestType = $data['requestType'];
    
    $url = 'http://cs490testcenter.ddns.net:50000/middle/middleController.php';

    $post_data = array('examName' => $examName, 'requestType' => $requestType);
        
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
