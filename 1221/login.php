<?php
session_start();
	$userID = $_POST["userID"];
	$password = $_POST["password"];



	require "tool.php";



	$judge = loginJudge($password,$userID); //ログイン判定呼び出し


	if($judge){
	unset($_POST["password"]);
		$password = null;
		$_SESSION["userID"] = $userID;
    echo("<script>window.location.href = 'board.php';</script>");
		// header("Location:board.php");//成功
		//echo("<meta http-equiv='refresh' content='1;URL=passcheck.php'");

	}else{
		// header("Location:login.html"); //失敗
    echo("ログインに失敗しました");
	}

?>
