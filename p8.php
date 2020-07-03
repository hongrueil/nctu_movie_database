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
if(1){
	$city=$_POST['city'];
	$star=$_POST['star'];	    
	$gg=$_POST['like'];	    
	
	$sqltemp = "UPDATE movies
	SET favorite= not favorite
	WHERE id= $gg"; 
	mysqli_query($con,$sqltemp);
	$data=mysqli_query($con,"select id ,c.title as name ,m.homepage,m.favorite from credits as c,movies as m where c.movie_id =m.id and c.title like '%$city%' and c.cast like '%$star%'order by id");

}
?>
<!doctype html>
<html>
<head>

<meta charset="utf-8">
<title>資料庫網頁建置</title>
</head>
<body>
	<form id="form1" name "form1" method="post" action="">
		<p>電影名稱包含:
		<input name="city" type="text" id="city" value="<?php echo $city?>"/>
		</p>
		<p>電影明星包含:
		<input name="star" type="text" id="star" value="<?php echo $star?>"/>
		</p>
		
		<p>
		<input type="submit" name ="button" id ="button" value="搜尋"/>
		</p>
<table width="700" border="1">

    <tr>
      <td>movie_id</td>
      <td>name</td>
	  <td>homepage</td>
	  <td>favorite</td>
	  <td>like</td>

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
		if($rs[3]==1) $img="https://obs.line-scdn.net/0hw7zT292rKBhHLQID8AxXT317K3d0QTsbIxt5BxhDdiw4Gz0dK01gLWt4JS1uSW9GLkhgeWIoMyliTmYae0xg/w644";
		else {$img="https://lh3.googleusercontent.com/proxy/hhRnYc6_zgZ2K7TmyUcQsqzBBHJK_tLxEgRNkI67DnE1iyDh__A2X8Ch2N2jZ9k5wt9db7URxVMQE9xoLcpBGDdpLnFmd_kQ9Yu8vhXkmo6T";}

	    echo "<button type=submit name=like value=$movie><img src=$img height=30 length=30></button>";
		?>
		</p></td> 		
		<td><?php echo $rs[3];?></td>

    </tr>
	<p>
<?php
}
	?>
</table>
	<p>&nbsp;</p>
</body>
</html>