
<?php
$con=mysqli_connect("localhost","root","a130573062","movie");
/*if(mysqli_connect_errno($con)){
	echo "連接失敗" .mysqli_connect_error();
}
else{
	echo "連接成功";
}*/
mysqli_select_db($con,"movie");
mysqli_query($con,"SET CHARACTER SET UTF8");
//$sql="select * from contact";
	$mid=array();
	$select_value = $_POST['genre'];
	$city=$_POST['city'];
	$star=$_POST['star'];
	if($_POST['time1'])$time1=$_POST['time1'];
	else $time1="0000";
	
	if($_POST['time2'])$time2=$_POST['time2'];
	else $time2="2020";

	$sqltemp="";
	if($_POST['like']!=""){
		$qid=$_POST['like'];
		$sqltemp = "UPDATE movies
		SET favorite= not favorite
		WHERE id= ".$_POST['like']; 
		echo $movie;
	}
	else if($_POST['rating']!=""){
		$score=$_POST['rating']%10;
		$qid=intval($_POST['rating']/10);
		$sqltemp = "UPDATE movies
		SET rate= ".$score."
		WHERE id= ".$qid; 
		echo "id=".$qid."\r\n";
		echo "score=".$score."\r\n";
		echo $city;
		echo $movie;
	}
	$feature=$_POST['genre'];
	$my_favorite=$_GET['favorite'];
	$button=$_POST['button'];
	if($feature=="All"){
		$feature="";
	}

	mysqli_query($con,$sqltemp);

	

	if($my_favorite==0){
	$data=mysqli_query($con,"select id ,c.title as name ,JSON_EXTRACT(c.cast,'$[0 to 10].name'),m.favorite,left(CAST(m.release_date AS CHAR),4),m.vote_average,m.homepage,JSON_EXTRACT(m.genres,'$[0 to 10].name'),m.rate from credits as c,movies as m  where c.movie_id =m.id  and c.title like '%$city%'and c.cast_back like '%$star%'and m.genres like'%$feature%' and left(CAST(m.release_date AS CHAR),4) between $time1 and $time2  order by vote_average desc");
		
	}
	else if($my_favorite==1){
		$data=mysqli_query($con,"select id ,c.title as name ,JSON_EXTRACT(c.cast,'$[0 to 10].name'),m.favorite,left(CAST(m.release_date AS CHAR),4),m.vote_average,m.homepage,JSON_EXTRACT(m.genres,'$[0 to 10].name'),m.rate from credits as c,movies as m  where c.movie_id =m.id and m.favorite=1 and c.title like '%$city%'and c.cast_back like '%$star%'and m.genres like'%$feature%' and left(CAST(m.release_date AS CHAR),4) between $time1 and $time2  order by vote_average desc");
		
	}


?>
<!doctype html>
<html>
<head>

<meta charset="utf-8">
<title>資料庫網頁建置</title>
</head>
<body>
	<form id="form1" name="form1" method="post" action="">
		<p>電影名稱包含:
		<input name="city" type="text" id="city" value="<?php echo $city?>"/>
		</p>
		<p>電影明星包含:
		<input name="star" type="text" id="star" value="<?php echo $star?>"/>
		</p>
		<p>發布時間(start):
		<input name="time1" type="text" id="time1" value="<?php echo $time1?>"/>
		</p>
		<p>發布時間(end):
		<input name="time2" type="text" id="time2" value="<?php echo $time2?>"/>
		</p>
		<p>類型選單:
	    <select name="genre",id="select">
		  <option value="All">All</option>
	      <option value="Animation"<?php
		  echo $select_value=='Animation'?'selected':''?>> Animation</option>
	      <option value="Adventure"<?php
		  echo $select_value=='Adventure'?'selected':''?>>Adventure</option>
	      <option value="Action"<?php
		  echo $select_value=='Action'?'selected':''?>>Action</option>
	      <option value="Comedy"<?php
		  echo $select_value=='Comedy'?'selected':''?>>Comedy</option>
	      <option value="Science Fiction"<?php
		  echo $select_value=='Science Fiction'?'selected':''?>>Science Fiction</option>
	      <option value="Fantasy"<?php
		  echo $select_value=='Fantasy'?'selected':''?>>Fantasy</option>
	      <option value="Crime"<?php
		  echo $select_value=='Crime'?'selected':''?>>Crime</option>
	      <option value="Thriller"<?php
		  echo $select_value=='Thriller'?'selected':''?>>Thriller</option>
	      <option value="Family"<?php
		  echo $select_value=='Family'?'selected':''?>>Family</option>
	      <option value="Drama"<?php
		  echo $select_value=='Drama'?'selected':''?>>Drama</option>
	      <option value="Romance"<?php
		  echo $select_value=='Romance'?'selected':''?>>Romance</option>
	      <option value="Horror"<?php
		  echo $select_value=='Horror'?'selected':''?>>Horror</option>
	      <option value="History"<?php
		  echo $select_value=='History'?'selected':''?>>History</option>
	      <option value="Music"<?php
		  echo $select_value=='Music'?'selected':''?>>Music</option>
	      <option value="Mystery"<?php
		  echo $select_value=='Mystery'?'selected':''?>>Mystery</option>
	      <option value="War"<?php
		  echo $select_value=='War'?'selected':''?>>War</option>
		</select>
		
	
<p>
			
		<input type="submit" name ="button" id ="button" value="搜尋"/>
		<?php
		if($_GET['favorite']==0)
			echo "<a href=p8.php?favorite=1>我的最愛</a>";
		else
			echo "<a href=p8.php?favorite=0>所有</a>";
		?>
		</p>
<table width="700" border="1">

    <tr>
      <td>movie_id</td>
      <td>name</td>
	  <td>cast</td>
	  <td>favorite</td>
	  <td>time</td>
	  <td>vote_avg</td>
	  <td>homepage</td>
	  <td>genres</td>
	  <td>rating</td>
	  <td>rating2</td>

    </tr>

<?php

for($i=1;$i<=mysqli_num_rows($data);$i++){
$rs=mysqli_fetch_row($data);
	
?>
    <tr>
      <td><?php echo $rs[0];?></td>
      <td><?php echo $rs[1];?></td>
	  <td><?php echo $rs[2];?></td>
      <td><p>
		<?php   
		$movie=$rs[0];
		array_push($mid,$rs[0]);
		if($rs[3]==1) $img="https://obs.line-scdn.net/0hw7zT292rKBhHLQID8AxXT317K3d0QTsbIxt5BxhDdiw4Gz0dK01gLWt4JS1uSW9GLkhgeWIoMyliTmYae0xg/w644";
		else {$img="https://img.tukuppt.com/png_preview/00/52/36/fsaLObkAaD.jpg!/fw/780";}

	    echo "<button type=submit name=like value=$movie><img src=$img height=30 length=30></button>";
		echo $movie;
		?>
		</p></td> 		
		
		<td><?php echo $rs[4];?></td>
		<td><?php echo $rs[5];?></td>
		<td><?php echo "<a href=$rs[6]>$rs[6]</a>";?></td>
		<td><?php echo $rs[7];?></td>
		<td><?php for($j=1;$j<=5;$j++){
				$snd=$movie*10+$j;
				if($rs[8]>=$j) $img2="https://img.lovepik.com/element/40053/1111.png_860.png";
				else $img2="https://lh3.googleusercontent.com/proxy/9jDa7IbAD1D9Xx4VHN2seXKpp6HuoY-nWY8S6CtosT2jPRLhOswwZi5gA_5l0SfFL1zo7m9o2-b2koeB_v-iwjTbDJvUTXnk0-lxkKbOVUYj";
				echo "<button type=submit name=rating value=$snd><img src=$img2 height=30 length=30></button>";
}
			?></td>
		<td><?php echo $rs[8];?></td>
    </tr>
	    
	<p>
<?php
}
	?>
</table>
	<p>&nbsp;</p>
</body>
</html>
