<?php
//DB接続関数
function DBconnect(){
  try{
    $dsn = __DIR__;
    $dsn = preg_replace('/\\\/u','/',$dsn);
    $dsn .= '/test.sqlite3';
    //$connect = new PDO("mysql:host=localhost;dbname=unknown.db;charset=utf8","root","");	//データベース接続開始
    $connect = new PDO("sqlite:".$dsn);
    $connect->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }catch(Exception $e){
      echo "通信エラーが発生しました<br>";
      return null;
    }
	return $connect;
}
//DB接続関数終わり

//ログイン判定関数
function loginJudge($password,$name){// $password:パスワード　$name:名前
	$conn = DBconnect();
  try{
  if($conn == null){
    // header("Location:login.html");
    throw new Exception("error");
    // return false;
  }
  // connectionCheck($conn);
	/*$result = $conn ->query(
							"SELECT * FROM logindata WHERE userID = '{$name}'"//$nameに該当するデータ行を$resultに代入
							);*/


	$result = $conn->prepare(
	"SELECT * FROM logindata WHERE userID =:name");
	$result->execute(array(":name"=>$name));
	$r = $result->fetch(); //$rに１行代入

}catch(Exception $e){
  return false;
}
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
try{
  if($conn === null){
    throw new Exception("エラー");
  }
	$date = date("Y-m-d H:i:s"); // 2001-03-10 17:16:18 (MySQL の DATETIME フォーマット)
												//(主ナンバー,'コメント内容','日付','投稿者データ','','')
	//$conn ->exec("INSERT INTO textcontent VALUES(NULL,'$Content','$date','$userID')");//コメント挿入

	$statment=$conn->prepare(
	"INSERT INTO textcontent VALUES(NULL,:Content,:date,:userID)");
	$statment->execute(array(":Content"=>$Content,":date"=>$date,":userID"=>$userID));

}catch (Exception $e){
  // echo "error";
  return false;
}

	$c = $conn->query("SELECT COUNT(content_id) AS count FROM textcontent");
  $count = $c->fetch();
  	if($count["count"] >= 5){//50件に達したら一つ削除
  		contentDelete($conn);//データ一件削除
  	}


	$conn = null;
  return true;
}

//コメント入力関数終わり


//コメント一覧表示関数
function searchTextContent(){//
	$conn = DBconnect();
  try{
    if($conn === null){
      throw new Exception("エラー");
    }

	$data = $conn->query("SELECT content_id,contentData,date,personalData FROM textcontent ORDER BY content_id DESC");
}catch(Exception $e){
  // echo "error";
}
	return $data;

}
//コメント一覧表示関数終わり

//返信入力関数
function addReturnComment($content_id,$personalData,$returnContent){//五十件に達したら処理しないようにする
	$conn = DBconnect();
  try{
    if($conn === null){
      throw new Exception("Error Processing Request");
    }
												//(返信ナンバー,主ナンバー,'返信内容','日付','投稿者データ')
	$date = date("Y-m-d H:i:s"); // 2001-03-10 17:16:18 (MySQL の DATETIME フォーマット)
	//$conn ->exec("INSERT INTO textcontent VALUES(NULL,'$Content','$date','$userID')");//コメント挿入

	$statment=$conn->prepare(
	"INSERT INTO returntextDB VALUES(NULL,:content_id,:returnContent,:date,:personalData)");
	$statment->execute(array(":content_id"=>$content_id,":returnContent"=>$returnContent,":date"=>$date,":personalData"=>$personalData));
  }catch(Exception $e){
    return false;
  }
	$conn = null;
  return true;
}
//返信入力関数終わり

//返信一覧表示関数
function searchReturnComment($content_id){
	$conn = DBconnect();
  try{
    if($conn === null){
      throw new Exception("Error Processing Request");
    }
	$data = $conn->query("SELECT returnContent_id,returnContent,date,personalData FROM returntextDB WHERE textContent_id = $content_id");
}catch(Exception $e){
return null;
}
	// $data = $conn->query("SELECT returnContent,date,personalData FROM returntextDB WHERE textContent_id = $content_id");
	return $data;
}
//返信一覧表示関数終わり

//リツイート返信検索開始
function searchReturnOne($return_id){
  $conn = DBconnect();
  $data = $conn->query("SELECT returnContent,date,personalData FROM returntextDB WHERE returnContent_id = $return_id");
  return $data;
}
//リツイート返信検索終わり

//タイトル表示関数
function titleView($content_id){
	$conn = DBconnect();
  try{
    if($conn === null){
      throw new Exception("Error Processing Request");
    }

	$data = $conn->query("SELECT content_id,contentData,date,personalData FROM textcontent WHERE Content_id = $content_id");
  }catch(Exception $e){
    return null;
  }
	return $data;
}
//タイトル表示関数終わり

//共有機能関数
function reTweet($content_id,$return_id,$personalData){
	$conn = DBconnect();

	$date = date("Y-m-d H:i:s"); // 2001-03-10 17:16:18 (MySQL の DATETIME フォーマット)

  $bool = $conn->query("SELECT * FROM retweet
     WHERE  return_id = '$return_id' AND personalData = '$personalData'");
     $bool = $bool->fetch();

  if($bool){
    $bool = $conn->query("UPDATE retweet SET date = '$date' WHERE return_id = '$return_id' AND personalData = '$personalData'");
  }else{
    $statment=$conn->prepare(
  	"INSERT INTO retweet VALUES(NULL,:content_id,:return_id,:date,:personalData)");
  	$statment->execute(array(":content_id"=>$content_id,":return_id"=>$return_id,":date"=>$date,":personalData"=>$personalData));
  	$conn = null;
  }


	//指定されたコメントをリツイートDBに追加していく
	//array_reverse(data.true) 配列を逆にして渡す
}
//共有機能関数終わり

//共有関数に必要なID取得関数開始
function searchReTweetNum(){
	$conn = DBconnect();
	$data = $conn->query("SELECT return_id,date,personalData FROM retweet");
	return $data;

}
//共有関数に必要なID取得関数終わり

//共有された返信一覧開始
function searchReTweet($returnContent_id){
	$conn = DBconnect();
	$num = $conn->query("SELECT textContent_id FROM returntextdb WHERE returnContent_id = '$returnContent_id'");
	$num = $num->fetch();
	$d = $conn->query("SELECT * FROM textcontent,returntextdb WHERE textcontent.content_id = '$num[textContent_id]' AND returntextdb.returnContent_id = '$returnContent_id'");

	$data = $d->fetch();
	return $data;
}
//共有された返信一覧関数終わり


//TimeLine一覧開始(ver2.0)
function searchTimeLine(){
	$conn = DBconnect();
	$num = $conn->query("SELECT DISTINCT return_id FROM retweet");
	$array = array();

		foreach($num as $n){
			$ar = $conn->query("SELECT NULL AS content_id,return_id,date,personalData FROM retweet WHERE return_id={$n['return_id']} ORDER BY date DESC");
			// var_dump($ar);
			// echo("<br>");
			$ar1 = $ar->fetch(PDO::FETCH_ASSOC);
			array_push($array,$ar1);
		}

		$content = searchTextContent();
		foreach($content as $c){
			array_push($array,$c);
		}
    $id = array();
		foreach ($array as $key => $value) {

		  $id[$key] = $value['date'];
		}

		array_multisort($id, SORT_DESC, $array);//http://www.flatflag.nir87.com/sort-385参照
		return $array;
}
//TimeLine一覧終わり(ver2.0)

//返信数count関数開始
function commentCount($content_id){
	$conn = DBconnect();
	$c = $conn->query("SELECT COUNT(textContent_id = '$content_id' or null) AS count FROM returntextDB");
	$count = $c->fetch();
	return $count;

}
//返信数count関数終わり

//セッション管理関数開始
function sessionProtect($session){
	if($session == null){
		header("Location:login.html");
	}
}
//セッション管理関数終わり

function connectionCheck($conn){
  if($conn === null){
    return "エラーが発生しました";
  }
}

//コメント削除関数開始
function contentDelete($conn){
  echo("ｃｄ1行目<br>");
  //$conn = DBconnect();
  echo("ｃｄ2行目<br>");
  $num = $conn->query("SELECT content_id FROM textcontent");
  echo("ｃｄ3行目<br>");
  $numId = $num->fetch();
  echo("ｃｄ4行目<br>");
	$c = $conn->prepare("DELETE FROM textcontent WHERE content_id = :numId");
  echo("ｃｄ5行目<br>");
  $c->execute(array(":numId"=>$numId["content_id"]));
  echo("ｃｄ4行目aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa<br>");
  returnCommentDelete($conn,$numId["content_id"]);
    echo("ｃｄ５行目");
  retweetDelete($conn,$numId["content_id"]);
    echo("ｃｄ６行目");
}
//コメント削除関数終わり

//返信削除関数開始
function returnCommentDelete($conn,$numId){
	$c = $conn->prepare("DELETE FROM returntextDB WHERE textContent_id = :numId");
  $c->execute(array(":numId"=>$numId));
}
//返信削除関数終わり

function retweetDelete($conn,$numId){
	$c = $conn->prepare("DELETE FROM retweet WHERE content_id = :numId");
  $c->execute(array(":numId"=>$numId));
}

function getReturnComment($return_id){
    $conn = DBconnect();
    $data = $conn->query("SELECT textContent_id,returnContent,date,personalData FROM returntextDB WHERE returnContent_id = $return_id");
    return $data;

}



//UPDATE textcontent SET contentData = 'aiueo' WHERE content_id = 1


?>
