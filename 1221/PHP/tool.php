<?php
//DB接続関数
function DBconnect(){
	$connect = new PDO("mysql:host=localhost;dbname=test;charset=utf8","root","");	//データベース接続開始
	return $connect;

}
//DB接続関数終わり

//ログイン判定関数
function loginJudge($password,$name){// $password:パスワード　$name:名前
	$conn = DBconnect();


	$result = $conn ->query(
							"SELECT * FROM logindata WHERE userID = '{$name}'"//$nameに該当するデータ行を$resultに代入
							);

	$r = $result->fetch(); //$rに１行代入

	if(empty($r)){
		return false;

	}else if($r["pass"] == $password){ //パスワード判定
		$conn = null;
		return true;

	}else{
		$conn = null;
		return false;//パスワードが間違っている場合
	}

	//データベース接続終了

}
//ログイン判定関数終わり


//コメント入力関数
function addTextContent($Content,$userID){ //引き数　コメント内容：投稿者情報
	$conn = DBconnect();

	$date = date("Y-m-d H:i:s"); // 2001-03-10 17:16:18 (MySQL の DATETIME フォーマット)
												//(主ナンバー,'コメント内容','日付','投稿者データ','','')
	$conn ->exec("INSERT INTO textcontent VALUES(NULL,'$Content','$date','$userID')");//コメント挿入

	/*$count = $conn->query("SELECT COUNT(*) FROM textcontent");//コメント数確認*/

	/*if($count => 50){//50件に達したら一つ削除
		//データ一件削除
	}*/
	$conn = null;

}
//コメント入力関数終わり


//コメント一覧表示関数
function searchTextContent(){//
	$data = $conn->query("SELECT FROM textcontent content_id,contentData,date,personalData");
	return $data;

}
//コメント一覧表示関数終わり

//返信入力関数
function addReturneoment(){//五十件に達したら処理しないようにする

}
//返信入力関数終わり

//共有機能関数
function retweet(){
	//指定されたコメントをリツイートDBに追加していく
	//array_reverse(data.true) 配列を逆にして渡す
}
//共有機能関数
?>
