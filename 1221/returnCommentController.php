<?php
session_start();
require "tool.php";
sessionProtect($_SESSION["userID"]);

  $rContent = $_POST["rTypeBoard"];
  $content_id = $_POST["content_id"];
  $userID = $_SESSION["userID"];
  $check = False;
  $isThereContent = False;

  $contCheck = titleView($content_id);
  foreach ($contCheck as $r) {
    // $check = True;
    $isThereContent = True;
    }
  if($isThereContent){
      $rContent = nl2br(htmlspecialchars($rContent,ENT_QUOTES));

      $pattern="^(\s|　)+$";//正規表現のパターン
      if(!empty($rContent)){
        if(!mb_ereg_match($pattern,$rContent)){
          $check = addReturnComment($content_id,$userID,$rContent);
        }
      }
    if($check === True){
      echo '<script>
            window.location.reload(true);
        </script>';
    }
  }else{
    $name = gethostname();
    $hostName = gethostbyname($name);
    $out = 'HostName:'.$name."　ip:".$hostName;
    echo " ( (c ：; ］ﾐ >-";
    echo $out;
    error_log(date("[Y/m/d H:i:s] ").rtrim($out).PHP_EOL, 3, 'app.log');
  }
	// header("Location:replyBoard.php?content_id=".$content_id);
?>
