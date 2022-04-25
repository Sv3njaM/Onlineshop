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