<?php
session_start();
require "tool.php";
sessionProtect($_SESSION["userID"]);

// ini_set("display_errors", 0);
// ini_set("display_startup_errors", 0);
// error_reporting(E_ALL);

?>
<!DOCTYPE html>
<html>
<head>
  <title>menu</title>
  <meta charset="utf-8" />
    <link rel="stylesheet" href="./CSS/board.css">
</head>
<body>
<header>
  <nav id="navFlex">
    <a href="#">トップページ</a>
    <a href="#">タイムライン</a>
    <a href="#">コメント一覧</a>
  </nav>
</header>

<div class="wrapper">
  <div class="timeLineWrapper">
    <div class="typeText">
      <!-- <form action="#" method="post">
        <ul>
          <li>
            <textarea class="inputForm" name="typeBoard" placeholder="ここに入力"></textarea>
          </li>
          <li>
            <input type="submit" value="送信" class="goReplyPage"/>
          </li>
          </ul>
      </form> -->
      マイページ
    </div>
    <?php
    $date = searchTextContent();
    $i = 1;

    foreach ($date as $r) {
      echo '<div class="content">';
        echo '<div class="accountInfo">';
          echo  'レスNo：'.$r["content_id"].' 投稿日時：'.$r["date"].' 学生番号：'.$r["personalData"].'<br />';
        echo '</div>';
        echo '<div class="textContent">';
          echo $r["contentData"].'<br />';
        echo '</div>';
        echo '<div class="goReplyPage">';

          echo '<a href="replyBoard.php?content_id='.$r["content_id"].'">返信画面へ飛ぶ</a>';
          echo '<input type="button" class="replyDisplay'.$r["content_id"].'" name="'.$r["content_id"].'" onclick="clicku('.$r["content_id"].')" value="'.$r["content_id"].'番">';
          echo '<div class="add'.$r["content_id"].'">';
          echo '</div>';
        echo '</div>';
      echo '</div>';
      $i++;
    }

    ?>

  </div>
</div>
<footer>
  <form action="#" method="post">
    <input type="submit" value="ログアウト" />
  </form>
  プロジェクト演習２
</footer>
</body>
</html>
