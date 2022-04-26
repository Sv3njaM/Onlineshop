<!--All functions wich are needed to run the programms proper like a log
and flashmessages-->
<?php
//function isPost gives a true back if a post message is send after a button is pressed
function isPost():bool{
  return strtoupper($_SERVER['REQUEST_METHOD']) === "POST";
}
//to escape strings for html output
function escape(string $value):string{
  return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

//log information to find flaws and other logininformations
function logData(string $errorLevel, string $errorMessage, ?array $data = null){
    $today = date('Y-m-d');
    $now = date('Y-m-d H:i:s');
    $logFile = LOG_DIR.'/log-'.$today.'.log';
    // the \n needs "" not '' else it will not make a break but write the slash and letter in
    $logData = '['.$now.'-'.$errorLevel.']'.$errorMessage."\n";
    if($data){
      //true in print_r will return result and not print it. Default = false
      $dataString = print_r($data,true)."\n";
      $logData .= $dataString;
    }
    $logData .= str_repeat('*',100)."\n";
    file_put_contents($logFile,$logData,FILE_APPEND);
  }

  function flashMessage(?string $message = null){
    //check if Session variable is set else sets it
    if(!isset($_SESSION['message'])){
      $_SESSION['message'] = [];
    }
    if(!$message){
      $messages = $_SESSION['message'];
      $_SESSION['message'] = [];
      return $messages;
    }
    $_SESSION['message'][] = $message;
  }

  //creates a randomhash for the Registration
function getRandomHash(int $length):string{
  $randomInt = random_int(0, time());
  $hash = md5($randomInt);
  $start = random_int(0, strlen($hash)-$length);
  $hashShort = substr($hash, $start, $length);
  return $hashShort;
}

function redirectIfNotLoggedIn(string $sourceTarget){
  if(isLoggedIn()){
    return;
  }
    $_SESSION['redirectTarget'] = BASE_URL.'index.php'.$sourceTarget;
    header("Location: ".BASE_URL."index.php/login");
    exit();
}