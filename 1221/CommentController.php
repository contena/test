<?php
session_start();
require "tool.php";
sessionProtect($_SESSION["userID"]);

	$content = $_POST["typeBoard"];
	$userID = $_SESSION["userID"];
	//$userID = "E15C0000";

	$content = nl2br(htmlspecialchars($content,ENT_QUOTES));

  //変更要素
	// if($ContentCheck != "UTF-8"){
	// 	$content = "";
	// }
  $check = False;

	$pattern="^(\s|　)+$";//正規表現のパターン
  if(!mb_ereg_match($pattern,$content)){
    if(!empty($content)){
      $check = addTextContent($content,$userID);
    }
}

	// $check = addTextContent($content,$userID);
if($check === True){
	echo '<script>
	          window.location.reload(true);
	      </script>';
	}
	// header("Location:board.php");

?>
