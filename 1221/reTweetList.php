<?php
require "tool.php";
session_start();
sessionProtect($_SESSION["userID"]);
?>
<!DOCTYPE html>
<html>
<head>
  <title>コメント一覧</title>
  <meta charset="utf-8" />
    <link rel="stylesheet" href="./CSS/board.css">
    <script src="jquery-2.1.3.js"></script>
</head>
<body>
<header>
  <nav id="navFlex">
    <a href="MyPage.php">マイページ</a>
    <a href="board.php">タイムライン</a>
    <a href="reTweetList.php">共有コメント一覧</a>
  </nav>
</header>

<div class="wrapper">
  <div class="timeLineWrapper">
    <div class="top">
      <h1>共有一覧</h1>
    </div>
<?php
    $data = searchReTweetNum();

    foreach ($data as $r) {
      $data2 = searchReTweet($r["return_id"]);
      // echo var_dump($data2["returnContent"]);
      echo '<div class="content">';
        echo '<div class="accountInfo">';
          echo  '投稿日時：'.$data2["date"].' 学生番号：'.$data2["personalData"].'<br />';
        echo '</div>';
        echo '<div class="textContent">';
          echo $data2["returnContent"].'<br />';
        echo '</div>';
        echo '<div class="goReplyPage">';
          echo '<a href="replyBoard.php?content_id='.$data2["textContent_id"].'">返信画面へ飛ぶ</a>';
        echo '</div>';
      echo '</div>';
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
