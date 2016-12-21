<?php
require "tool.php";

$data = searchReturnComment($_POST["data"]);

$i = 1;
// echo var_dump($data);

foreach ($data as $r) {
  echo '<div class="reply">';
    echo '<div class="accountInfo">';
      echo  '返信No：'.$i.' 投稿日時：'.$r["date"].' 学生番号：'.$r["personalData"].'<br />';
    echo '</div>';
    echo '<div class="textContent">';
      echo $r["returnContent"].'<br />';
    echo '</div>';
    echo '<div class="share">';
      //echo '<form action="ReTweetController.php" method="post">';
      //   echo '<input type="hidden" name="returnCommentID" value='.$r["returnContent_id"].' />';
      //   echo '<input type="hidden" name="returnContentID" value='.$_GET["data"].' />';
      //   echo '<input type="submit" value="このコメントを共有する" />';
      //echo '</form>';
    echo '</div>';
  echo '</div>';
  $i++;
}
 ?>
