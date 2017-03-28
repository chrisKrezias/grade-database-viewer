<!DOCTYPE html>
<html>
<head>
	<meta charset=utf-8/>
	<title>ΑΔΕ(Ε) 40570-42414</title>
	<style>
		a.fixed {
			position: fixed;
			top: 300px;
			left: 100px;
			width: 65px;
			background: white;
		}
		.c1 {background-color:#FFFF99;}
		.c2 {background-color:grey;}
	</style>
</head>
<body>
<?php 
	error_reporting(0);
	if (empty($_POST['ex'])){
		$ex="2003-04_x";
		}
	elseif ($_POST['ex']=="Επιλέξτε εξάμηνο"){
		$ex="2003-04_x";
		}
	else {
		$ex=$_POST["ex"]; 
		}
?>
	<h3 align="center" id="top">
		PROJECT - DETAILS
	</h3>
	<a class="fixed" href="#top">
		@PeLAB
	</a>
	<?php
		$dblink=mysql_connect("std.weblab.teipir.gr","web_wed43","w150fd1a87")
				or die("Could not connect");
			mysql_select_db("web_wed43")
				or die("could not select");
		$ask=9;
		include ("../footer.php"); 
		$x=file("text.txt");?>
	<table border="1" cellspacing="0" cellpadding="2" align="center">
	<?php foreach($x as $v=>$k){?>
		<tr style='background:yellow'>
		<?php 
		$k=explode(';',rtrim($k,";"));
		foreach($k as $val){?>
			<th>
				<?php echo $val; ?>
			</th>
		<?php }?>
		</tr>
		<?php }?>
		<tr class='c2'>
		<form method="post">
			<th colspan="3">
				<?php
				$i="2003-04_x";
				if (empty($ex)){
					echo "α.ε: ";
					echo $i;
				}
				elseif (isset($_POST['refresh'])){
					echo "α.ε: ";
					echo $i;
				}
				else {
					echo "α.ε: ";
					echo $ex;
				}
				?> 
			</th>
			<th colspan="3">
				Επιλογές:
				<select name='ex' onchange='this.form.submit()'>
					<option value="<?php if (isset($_POST['ex'])){ echo $_POST['ex'];} else{echo 'Επιλέξτε εξάμηνο';}?>">Επιλέξτε εξάμηνο</option>
					<?php
						$query="SELECT DISTINCT ex FROM array4";
						$request=mysql_query($query);
						while ($row=mysql_fetch_array ($request, MYSQL_ASSOC))
						{
							echo "<option>".$row["ex"];"</option>";
						}
						echo "</select>"
					?>
				&nbsp&nbsp&nbsp
				Focus on Sem:
					<?php 
						$query="SELECT DISTINCT se FROM array4";
						$request=mysql_query($query);
						while ($row=mysql_fetch_array ($request, MYSQL_ASSOC))
						{
							$i=$row["se"];
							echo " <a href='#$i'>".$row["se"]."</a>";
						}
					?>
			</th>
			<th colspan="11">
				<input type="submit" value="REFRESH" name="refresh" id="refresh"/>
				<input type="submit" value="RESET" name="reset" id="reset"/>
				<input type="button" onclick="location.href='./graphs.php';" value="GRAPHS" />
				<input type="submit" value="UPDATE" name="update" id="update"/>
			</th>
		</tr>
		<tr>
		<?php 
			if (isset($_POST['refresh'])){
				$query="SELECT * FROM array4 AS U WHERE ex='2003-04_x'";
			}
			elseif (empty($_POST['ex'])){
				$query="SELECT * FROM array4 AS U WHERE ex='2003-04_x'";
			}
			elseif ($_POST['ex']=="Επιλέξτε εξάμηνο"){
				$query="SELECT * FROM array4 AS U WHERE ex='2003-04_x'";
			}
			else {
				$query="SELECT * FROM array4 AS U WHERE ex='$ex'";
			}
			$request=mysql_query($query);
			$aa=0;
			$y=0;
			while ($row=mysql_fetch_array ($request, MYSQL_ASSOC))
			{	$i=$row["se"];
				$j=$row["co"];
				$k=$row["ex"];
				$a=$row["aa"];
				$aa=$aa+1;
				if ($y==6){
					if ($i=="1"||$i=="2"){
						$y=0;
					}
				}
				elseif ($y==7){
					if ($i=="1"||$i=="2"){
						$y=0;
					}
				}
				elseif ($y==8){
					if ($i=="1"||$i=="2"){
						$y=0;
					}
				}
				if (stripos($row["ma"],"(Ε)") == true){
				echo "<tr class='c1'>";
				}
				elseif (stripos($row["ma"],"(Eργαστήριο)") == true){
				echo "<tr class='c1'>";
				}
				else{
				echo "<tr>";
				}
				if ($y==$i){
					echo "<td align='center'>$aa</td>";
				}
				else {
					echo "<td align='center' style='background:yellow'><a href='#$i' style='text-decoration:none'>$aa</a></td>";
				}
				echo "<td>".$row["co"]."</td>";
				if ($y==$i){
					echo "<td align='center' id='$i'>".$row["se"]."</td>";
				}
				else {
					echo "<td align='center' id='$i' style='background:yellow'>".$row["se"]."</td>";
					$y=$y+1;
				}
				if (isset($_POST['reset'])){
					$check="UPDATE array4 SET ch='FALSE'";
					$result=mysql_query($check);
					echo "<td><input type='checkbox' id='$j' name='$j$k'/></td>";
				}
				elseif (isset($_POST[$j.$k])){
					$check="UPDATE array4 SET ch='TRUE' WHERE aa='$a'";
					$result=mysql_query($check);
					echo "<td><input type='checkbox' id='$j' name='$j$k' checked='checked'/></td>";
				}
				elseif ($row["ch"]=="TRUE"){
					echo "<td><input type='checkbox' id='$j' name='$j$k' checked='checked'/></td>";
				}
				else {
					echo "<td><input type='checkbox' id='$j' name='$j$k'/></td>";
				}
				if (isset($_POST['reset'])){
					$check="UPDATE array4 SET ra='FALSE'";
					$result=mysql_query($check);
					echo "<td><input type='radio' name='$i$k' id='$i$k' value='$j'/></td>";
				}
				elseif ($_POST[$i.$k]==$j){
					if (isset($_POST['update'])){
					$check="UPDATE array4 SET ra='FALSE'";
					$result=mysql_query($check);
					}
					$check="UPDATE array4 SET ra='TRUE' WHERE aa='$a'";
					$result=mysql_query($check);
					echo "<td><input type='radio' name='$i$k' id='$i$k' value='$j' checked='checked'/></td>";
				}
				elseif ($row["ra"]=="TRUE"){
					echo "<td><input type='radio' name='$i$k' id='$i$k' value='$j' checked='checked'/></td>";
				}
				else {
					echo "<td><input type='radio' name='$i$k' id='$i$k' value='$j'/></td>";
				}
				echo "<td>".$row["ma"]."</td>";
				echo "<td>".$row["6"]."</td>";
				echo "<td>".$row["7"]."</td>";
				echo "<td>".$row["8"]."</td>";
				echo "<td>".$row["9"]."</td>";
				echo "<td>".$row["10"]."</td>";
				echo "<td>".$row["11"]."</td>";
				echo "<td>".$row["12"]."</td>";
				echo "<td>".$row["13"]."</td>";
				echo "<td>".$row["14"]."</td>";
				echo "<td>".$row["15"]."</td>";
				echo "<td>".$row["op"]."</td></tr>";
			}
			mysql_close($dblink);
		?>
		</tr>
		</form>
	</table>
<?php include ("../footer.php"); ?>
</body>
</html>