<?php
require "tool.php";

$data = searchTextContent();

foreach ($data as $dataPiece) {
  # code...
  foreach ($dataPiece as $createData) {
    # code...
    // echo ("
    //   <div class='content'>
    //     <div class='accountInfo'>
    //       学生番号　5月11日　0555555<br />
    //     </div>
    //     <div class='textContent'>
    //       hogehoge<br />
    //     </div>
    //     <div class='goReplyPage'>
    //       <a href='#''>返信画面へ飛ぶ</a>
    //     </div>
    // </div>
    //
    // ");
    // echo $createData["textcontent"];
  }
}

?>
