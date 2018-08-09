<?php
//Mysql
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password);

$mysql = "CREATE TABLE mission4_2 "
. "("
. "id INT,"
. "name char(32),"
. "comment TEXT,"
. "date TEXT,"
. "pass varchar(20)" 
. ");" ;
$stmt = $pdo -> query($mysql);

//編集
if(!empty($_POST['edit'])){
	$edit = $_POST['edit'];
	$editpass = $_POST['editpass'];
	
	$sql9 = 'SELECT * FROM mission4_2 ORDER BY id';
	$result8 = $pdo -> query($sql9);
	
	foreach($result8 as $row5){
		if($row5['id'] == $edit && $row5['pass'] == $editpass){
			$editname = $row5['name'];
			$editcom = $row5['comment'];
		}
	}
}
?>

<!DOCTYPE html>
<html lang = "ja">
<head>
<meta charset = "UTF-8">
<title>MySQL</title>
</head>
<body>
<form action ="mission_4.php" method = "post">

<label for = "name">名前 : </label>
<?php if(!empty($_POST['edit'])){ ?>
<input type = "text" name = "name" value = "<?php echo $editname; ?>"><br>
<?php } else{ ?>
<input type = "text" name = "name"><br>
<?php } ?>

<label for = "comment">コメント : </label>
<?php if(!empty($_POST['edit'])){ ?>
<input type = "text" name = "comment" value = "<?php echo $editcom; ?>"><br><br>
<?php } else{ ?>
<input type = "text" name = "comment">	<br>
<?php } ?>

<?php if(!empty($_POST['edit'])){ ?>
<input type = "text" name = "editnum" value = "<?php echo $edit; ?>">
<?php } else{ ?>
<input type = "hidden" name = "editnum">	
<?php } ?>

<label for = "pass">pass : </label>
<input tyape = "password" name = "pass">

<input type = "submit" value = "送信"><br><br>
<label for = "delete">削除対象番号 : </label>
<input type = "text" name = "delete"><br>
<label for = "pass">pass : </label>
<input tyape = "password" name = "delpass">
<input type = "submit" value = "削除"><br><br>

<label for = "edit">編集対象番号 : </label>
<input type = "text" name = "edit"><br>
<label for = "pass">pass : </label>
<input tyape = "password" name = "editpass">
<input type = "submit" value = "編集"><br><br>
</form>
</body>
</html>

<?php
//新規投稿
if(!empty($_POST['comment']) && !empty($_POST['name']) && empty($_POST['editnum'])){
	$sqlc = 'SELECT * FROM mission4_2 ORDER BY id';
	$resc = $pdo -> query($sqlc);
	$count = 0;
	$id = 0;
	foreach($resc as $rowc){
		$count = $rowc['id'];
	}
	$id = $count + 1;
		
	$sql = $pdo -> prepare("INSERT INTO mission4_2 (id, name, comment, date, pass) VALUES(:id, :name, :comment, :date, :pass)");
	$sql -> bindValue(':id', $id, PDO::PARAM_INT);
	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	$sql -> bindParam(':date', $date, PDO::PARAM_STR);
	$sql -> bindParam(':pass', $pass, PDO::PARAM_STR);

	$name = $_POST['name'];
	$comment = $_POST['comment'];
	$date =  date("Y/m/d/ H:i:s");
	$pass = $_POST['pass'];
	$sql -> execute();
	
	$sql2 = 'SELECT * FROM mission4_2 ORDER BY id';
	$result = $pdo -> query($sql2);
	foreach($result as $row){
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].',';
		echo $row['date'].'<br>';
	}
}

//編集作業
if(!empty($_POST['editnum'])){
	$id2 = $_POST['editnum'];
	$name2 = $_POST['name'];
	$comment2 = $_POST['comment'];
	$date2 =  date("Y/m/d/ H:i:s");
	$edipass = $_POST['pass'];
	
	$sql3 = 'SELECT * FROM mission4_2 ORDER BY id';
	$result2 = $pdo -> query($sql3);

	foreach($result2 as $row2){
		if($row2['id'] == $id2 && $row2['pass'] == $edipass){
	
			$sql4 = "update mission4_2 set name = '$name2', comment = '$comment2', date = '$date2' where id = $id2";
			$result3 = $pdo -> query($sql4);
	
			$sql5 = 'SELECT * FROM mission4_2 ORDER BY id';
			$result4 = $pdo -> query($sql5);
		
			foreach($result4 as $row3){
				echo $row3['id'].',';
				echo $row3['name'].',';
				echo $row3['comment'].',';
				echo $row3['date'].'<br>';
			}
		}
	}

}

//削除
if(!empty($_POST['delete'])){
	$id3 = $_POST['delete'];
	$delpass = $_POST['delpass'];
	
	$sql6 = 'SELECT * FROM mission4_2 ORDER BY id';
	$result5 = $pdo -> query($sql6);
	
	foreach($result5 as $row4){
		if($row4['id'] == $id3 && $row4['pass'] == $delpass){
			$sql7 = "delete from mission4_2 where id = $id3";
			$result6 = $pdo -> query($sql7);

			$sql8 = 'SELECT * FROM mission4_2 ORDER BY id';
			$result7 = $pdo -> query($sql8);
		
			foreach($result7 as $row5){
				echo $row5['id'].',';
				echo $row5['name'].',';
				echo $row5['comment'].',';
				echo $row5['date'].'<br>';
			}
		}
	}
}
?>
