<?php
require "tool.php";
session_start();
sessionProtect($_SESSION["userID"]);



$content_id = $_POST["returnContentID"];//ここ直してください
$return_id = $_POST["returnCommentID"];//ここ直してください
$userID = $_SESSION["userID"];
$iThereContent = False;
$isThereReply = False;
$content_id;
//$userID = "E16C0000";
$contCheck = titleView($content_id);
  foreach ($contCheck as $r) {
    // $check = True;
    $content_id = $r["content_id"];
    $isThereContent = True;
    }
$returnContCheck = getReturnComment($return_id);
  foreach ($returnContCheck as $r) {
    echo $r["returnContent"];
    if($content_id === $r["textContent_id"]){
      $isThereReply = True;
    }
  }

if($isThereContent && $isThereReply){
  reTweet($content_id,$return_id,$userID);
  // echo "good man";
  header("Location:replyBoard.php?content_id=".$content_id);
}else{
  echo "fuck you";
}
//retweet($return_id,$userID);

?>
