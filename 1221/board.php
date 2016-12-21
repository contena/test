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
  <title>コメント一覧</title>
  <meta charset="utf-8" />
  <link rel="stylesheet" href="./CSS/board.css">
  <script src="./JS/jquery-2.1.3.js"></script>
  <script src="./JS/tool.js"></script>
</head>
<body>
<header>
  <nav class="navFlex">
    <a href="#">マイページ</a>
    <a href="board.php">タイムライン</a>
    <?php
    echo "<span>ログイン中:".$_SESSION["userID"]."</span>";
      ?>
  </nav>
</header>

<div class="wrapper">
  <div class="timeLineWrapper">
    <div class="typeText">
      <!-- <form action="CommentController.php" method="post"> -->
        <ul>
          <li>
            <textarea class="inputForm" name="typeBoard" placeholder="ここに入力"></textarea>
          </li>
          <li>
            <!-- <input type="submit" value="送信" class="goReplyPage"/> -->
            <input type="button" class="sendText" onclick="sendComment()" value="送信"/>
          </li>
          </ul>
      <!-- </form> -->
      <div class="showError">
      </div>
    </div>
<?php

    // $data = searchTextContent();
    $timeLineData = searchTimeLine();
    // $data2 = replyCount($r["content_id"]);

    foreach ($timeLineData as $r) {
      // $num = commentCount($r["content_id"]);
        if($r['content_id'] != null){
          $num = commentCount($r["content_id"]);
          // var_dump($num);
          echo '<div class="content">';
            echo '<div class="accountInfo">';
              echo  'レスNo：'.$r["content_id"].' 投稿日時：'.$r["date"].' 学生番号：'.$r["personalData"].'<br />';
            echo '</div>';
            echo '<div class="textContent">';
              echo $r["contentData"].'<br />';
            echo '</div>';
            echo '<div class="goReplyPage">';
              echo '<a href="replyBoard.php?content_id='.$r["content_id"].'">返信画面へ飛ぶ</a>';
              echo '<input type="button" class="replyDisplay'.$r["content_id"].'" name="'.$r["content_id"].'" onclick="showReply('.$r["content_id"].','.$num["count"].')" value="'.$num["count"].'件の返信">';
              echo '<div class="add'.$r["content_id"].'">';
              echo '</div>';
            echo '</div>';
          echo '</div>';
          // echo("content");
          // echo($r['content_id'].":::::::::::::".$r['date']);
        }else{
          $data = searchReturnOne($r["return_id"]);
          foreach ($data as $r) {
            echo '<div class="shareBoard">';
            echo "<span><b>共有されたコメント</b>  </span>";
              echo '<div class="accountInfo">';
                echo  '投稿日時：'.$r["date"].' 学生番号：'.$r["personalData"].'<br />';
              echo '</div>';
              echo '<div class="textContent">';
                echo $r["returnContent"].'<br />';
              echo '</div>';
            echo '</div>';
          }

      }

      // $num = commentCount($r["content_id"]);
      // echo '<div class="content">';
      //   echo '<div class="accountInfo">';
      //     echo  'レスNo：'.$r["content_id"].' 投稿日時：'.$r["date"].' 学生番号：'.$r["personalData"].'<br />';
      //   echo '</div>';
      //   echo '<div class="textContent">';
      //     echo $r["contentData"].'<br />';
      //   echo '</div>';
      //   echo '<div class="goReplyPage">';
      //     echo '<a href="replyBoard.php?content_id='.$r["content_id"].'">返信画面へ飛ぶ</a>';
      //     echo '<input type="button" class="replyDisplay'.$r["content_id"].'" name="'.$r["content_id"].'" onclick="showReply('.$r["content_id"].','.$num[0].')" value="'.$num[0].'件の返信">';
      //     echo '<div class="add'.$r["content_id"].'">';
      //     echo '</div>';
      //   echo '</div>';
      // echo '</div>';
    }
?>
  </div>
</div>
<footer>
  <form action="logout.php" method="post">
    <input type="submit" value="ログアウト" />
  </form>
  プロジェクト演習２
</footer>
</body>
</html>
