
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
	$select_value = $_POST['genre'];
    $select_sort = $_POST['sort'];
	$city=$_POST['city'];
	$star=$_POST['star'];
	$people="";
	$final="";
	$moviename="";
	$finalmoviename="";
	//echo $star[1];
	if($_POST['star']){
	for($z=0;$z<=strlen($star)-1;$z++){
	if(("a"<=$star[$z]&&$star[$z]<="z")||("A"<=$star[$z]&&$star[$z]<="Z")){
		$people.=$star[$z];
	}
	if($star[$z]=="+"){
		$final.="and c.cast_back like '%";
		$final.=$people;
		$final.="%' ";
		$people="";
	}
		if($z==strlen($star)-1){
			$final.="and c.cast_back like '%";
		$final.=$people;
		$final.="%' ";
		$people="";
			
		}
		
		
		
	}
	}
		//echo $final;
	if($_POST['city']){
	for($o=0;$o<=strlen($city)-1;$o++){
	if(("a"<=$city[$o]&&$city[$o]<="z")||("A"<=$city[$o]&&$city[$o]<="Z")){
		$moviename.=$city[$o];
	}
	if($city[$o]=="+"){
		$finalmoviename.="and c.title like '%";
		$finalmoviename.=$moviename;
		$finalmoviename.="%' ";
		$moviename="";
	}
		if($o==strlen($city)-1){
			$finalmoviename.="and c.title like '%";
		$finalmoviename.=$moviename;
		$finalmoviename.="%' ";
		$moviename="";
			
		}
		
		
		
	}
	}echo $finalmoviename;

	if($_POST['time1'])$time1=$_POST['time1'];
	else $time1="0000";
	
	if($_POST['time2'])$time2=$_POST['time2'];
	else $time2="2020";

	$sqltemp="";
	if($_POST['like']!=""){
		$like_id=intval($_POST['like']/10);
		$like=$_POST['like']%10;
		$sqltemp = "UPDATE movies
		SET favorite= ".$like."
		WHERE id= ".$like_id; 

	}
	if($_POST['rating']!=""){
		$score=$_POST['rating']%10;
		$rate_id=intval($_POST['rating']/10);
		$sqltemp = "UPDATE movies
		SET rate= ".$score."
		WHERE id= ".$rate_id; 

	}
	$feature=$_POST['genre'];
	$my_favorite=$_GET['favorite'];
	$button=$_POST['button'];
	if($feature=="All"){
		$feature="";
	} 	
    $sort=$_POST['sort'];
	if($sort==""||$sort=="popular_desc"){
		$order="popularity";
		$bigsmall="desc";
	}
    else if($sort=="popular_asc"){
		$order="popularity";
		$bigsmall="asc";
		
	}
   else if($sort=="vote_avg_desc"){
		$order="vote_average";
		$bigsmall="desc";
		
	}
   else if($sort=="vote_avg_asc"){
		$order="vote_average";
		$bigsmall="asc";
		
	}
   else if($sort=="vote_desc"){
		$order="rate";
		$bigsmall="desc";
		
	}
   else if($sort=="vote_asc"){
		$order="rate";
		$bigsmall="asc";
		
	}
   else if($sort=="year_desc"){
		$order="year";
		$bigsmall="desc";
		
	}
   else if($sort=="year_asc"){
		$order="year";
		$bigsmall="asc";
		
	}
 

	mysqli_query($con,$sqltemp);

	

	if($my_favorite==0){
	$data=mysqli_query($con,"select id ,c.title as name ,JSON_EXTRACT(c.cast,'$[0 to 10].name'),m.favorite,left(CAST(m.release_date AS CHAR),4)as year,m.vote_average,m.homepage,JSON_EXTRACT(m.genres,'$[0 to 10].name'),m.rate,m.overview from credits as c,movies as m  where c.movie_id =m.id  $finalmoviename $final and m.genres like'%$feature%' and left(CAST(m.release_date AS CHAR),4) between $time1 and $time2  order by $order $bigsmall");
		
	}
	else if($my_favorite==1){
		$data=mysqli_query($con,"select id ,c.title as name ,JSON_EXTRACT(c.cast,'$[0 to 10].name'),m.favorite,left(CAST(m.release_date AS CHAR),4) as year,m.vote_average,m.homepage,JSON_EXTRACT(m.genres,'$[0 to 10].name'),m.rate,m.overview from credits as c,movies as m  where c.movie_id =m.id and m.favorite=1 $finalmoviename $final and m.genres like'%$feature%' and left(CAST(m.release_date AS CHAR),4) between $time1 and $time2  order by $order $bigsmall");
		
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
		<p>電影名稱:
		<input name="city" type="text" id="city" value="<?php echo $city?>"/>
		</p>
		<p>電影明星:
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
		
	
        <p>排序:
		<select name="sort",id="sort">
		  <option value="popular_desc"<?php
		  echo $select_sort=='popular_desc'?'selected':''?>> 依歡迎度由大到小</option>
	      <option value="popular_asc"<?php
		  echo $select_sort=='popular_asc'?'selected':''?>>依歡迎度由小到大</option>
	      <option value="vote_avg_desc"<?php
		  echo $select_sort=='"vote_avg_desc'?'selected':''?>>依評分由大到小</option>
	      <option value="vote_avg_asc"<?php
		  echo $select_sort=='vote_avg_asc'?'selected':''?>>依評分由小到大</option>
		  <option value="vote_desc"<?php
		  echo $select_sort=='vote_desc'?'selected':''?>>依個人評分由大到小</option>
	      <option value="vote_asc"<?php
		  echo $select_sort=='vote_asc'?'selected':''?>>依個人評分由小到大</option>
		  <option value="year_desc"<?php
		  echo $select_sort=='year_desc'?'selected':''?>>依年份由大到小</option>
	      <option value="year_asc"<?php
		  echo $select_sort=='year_asc'?'selected':''?>>依年份由小到大</option>
	    </p>
		<p>
		<input type="submit" name ="button" id ="button" value="搜尋"/>
		<?php
		if($_GET['favorite']==0)
			echo "<a href=p8.php?favorite=1>我的最愛</a>";
		else
			echo "<a href=p8.php?favorite=0>所有</a>";
		?>
		</p>
<table width="1500" border="1">

    <tr>
      <td>name</td>
	  <td>cast</td>
	  <td>overview</td>
	  <td>release_year</td>
	  <td>genres</td>
	  <td>homepage</td>
	  <td>vote_avg</td>
	  <td>add_to_favorite</td>
	  <td>rating</td>

    </tr>

<?php

for($i=1;$i<=mysqli_num_rows($data);$i++){
$rs=mysqli_fetch_row($data);
	
?>
    <tr>

        <td><?php echo $rs[1];?></td><!--name-->
	    <td><?php echo $rs[2];?></td><!--cast-->
	    <td><?php echo $rs[9];?></td><!--overview-->	
		<td><?php echo $rs[4];?></td><!--release year-->
		<td><?php echo $rs[7];?></td><!--genres-->
		<td><?php echo "<a href=$rs[6]>$rs[6]</a>";?></td><!--homepage-->
		<td><?php echo $rs[5];?></td><!--vote_avg-->
		<td align="center"><p>
		<?php   
		$movie=$rs[0];
		if($rs[3]==1) {
			$img="https://obs.line-scdn.net/0hw7zT292rKBhHLQID8AxXT317K3d0QTsbIxt5BxhDdiw4Gz0dK01gLWt4JS1uSW9GLkhgeWIoMyliTmYae0xg/w644";
			$movie=$rs[0]*10;
		}
		else {
			$img="https://img.tukuppt.com/png_preview/00/52/36/fsaLObkAaD.jpg!/fw/780";
			$movie=$rs[0]*10+1;
		}

	    echo "<button type=submit name=like value=$movie><img src=$img height=50 length=50></button>";
		?>
		</p></td> 	<!--add to favorite-->
		<td><?php for($j=1;$j<=5;$j++){
				$snd=$rs[0]*10+$j;
				if($rs[8]>=$j) $img2="https://img.lovepik.com/element/40053/1111.png_860.png";
				else $img2="data:image/png;base64,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";
				echo "<button type=submit name=rating value=$snd><img src=$img2 height=18 length=18></button>";
}
			?></td><!--rating-->
    </tr>
	    
	<p>
<?php
}
	?>
</table>
	<p>&nbsp;</p>
</body>
</html>
