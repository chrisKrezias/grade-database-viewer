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
		PROJECT - GRAPHS
	</h3>
	<a class="fixed" href="#top">
		@PeLAB
	</a>
	<?php
		$dblink=mysql_connect("std.weblab.teipir.gr","web_wed43","w150fd1a87")
				or die("Could not connect");
			mysql_select_db("web_wed43")
				or die("could not select"); 
		$x=file("text1.txt");?>
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
			<td>
				<?php 
					$i="-Γενική Παραγωγικότητα";
					if (empty($_POST["graphs"])){
						echo $i;
					}
					elseif ($_POST["graphs"]=="Επιλέξτε γράφημα"){
						echo $i;
					}
					else {
						echo $_POST["graphs"];
					}
				 ?>
			</td>
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
				else {
					echo "α.ε: ";
					echo $ex;
				}
				?> 
			</th>
			<th colspan="2">
				<select name='ex' onchange='this.form.submit()'>
					<option value="<?php if (isset($_POST['ex'])){ echo $_POST['ex'];} else{echo 'Επιλέξτε εξάμηνο';}?>">Επιλέξτε εξάμηνο</option>
					<?php 	
						$query="SELECT DISTINCT ex FROM array4";
						$request=mysql_query($query);
						while ($row=mysql_fetch_array ($request, MYSQL_ASSOC))
						{
							$i=$row["ex"];
							echo "<option value='$i'>".$row["ex"]."</option>";
						}
						echo "</select>"
					?>
				&nbsp&nbsp&nbsp
				<select name="graphs" onchange="this.form.submit()">
					<option value="<?php if (isset($_POST['graphs'])){ echo $_POST['graphs'];} else{echo 'Επιλέξτε γράφημα';}?>">Επιλέξτε γράφημα</option>
					<option>-Γενική Παραγωγικότητα</option>
					<option>-Δηλώσεις</option>
					<option>-Συμμετοχηκότητα (#)</option>
					<option>-Συμμετοχηκότητα (%)</option>
					<option>-Αποτυχ./Επιτυχ. (%)</option>
					<option>-Βαθμολογήθηκαν με [0 ~ 3,9] %</option>
					<option>-Βαθμολογήθηκαν με [4 ~ 4,9] %</option>
					<option>-Βαθμολογήθηκαν με [5 ~ 5,9] %</option>
					<option>-Βαθμολογήθηκαν με [6 ~ 6,9] %</option>
					<option>-Βαθμολογήθηκαν με [7 ~ 8,4] %</option>
					<option>-Βαθμολογήθηκαν με [8,5 ~ 10] %</option>
				</select>
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
				<input type="button" onclick="location.href='./index.php';" value="ΑΝΑΛΥΤΙΚΑ" />
			</th>
		</tr>
		<tr>
		<?php 
			if (empty($_POST['ex'])){
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
				if (empty($_POST["graphs"])){
					$j=$row["op"];$k=$j;
				}
				elseif ($_POST["graphs"]=="Επιλέξτε γράφημα"){
					$j=$row["op"];$k=$j;
				}
				else {	
				switch ($_POST["graphs"]){
					case "-Γενική Παραγωγικότητα":$j=$row["op"];$k=$j;break;
					case "-Δηλώσεις":$j="100";$k=$row["6"];break;
					case "-Συμμετοχηκότητα (#)":$j=($row["7"]/$row["6"])*100;break;
					case "-Συμμετοχηκότητα (%)":$j=($row["7"]/$row["6"])*100;break;
					case "-Αποτυχ./Επιτυχ. (%)":$j=$row["op"];$k=100-$j;break;
					case "-Βαθμολογήθηκαν με [0 ~ 3,9] %":if ($row["8"]==0){$j=0;} else {$j=($row["8"]/$row["6"])*100;} break;
					case "-Βαθμολογήθηκαν με [4 ~ 4,9] %":if ($row["9"]==0){$j=0;} else {$j=($row["9"]/$row["6"])*100;} break;
					case "-Βαθμολογήθηκαν με [5 ~ 5,9] %":if ($row["10"]==0){$j=0;} else {$j=($row["10"]/$row["6"])*100;} break;
					case "-Βαθμολογήθηκαν με [6 ~ 6,9] %":if ($row["11"]==0){$j=0;} else {$j=($row["11"]/$row["6"])*100;} break;
					case "-Βαθμολογήθηκαν με [7 ~ 8,4] %":if ($row["12"]==0){$j=0;} else {$j=($row["12"]/$row["6"])*100;} break;
					case "-Βαθμολογήθηκαν με [8,5 ~ 10] %":if ($row["13"]==0){$j=0;} else {$j=($row["13"]/$row["6"])*100;} break;
					default:$j=$row["op"];$k=$j;
				}}
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
				echo "<td>".$row["ma"]."</td>";
				if (empty($_POST['graphs'])){
					echo "<td><img src='graphs.gif' style='width:$j%; height:75%'/>".$j."%</td></tr>";
				}
				elseif ($_POST['graphs']=="-Αποτυχ./Επιτυχ. (%)"){
					echo "<td><img src='graphs1.gif' style='width:$k%; height:75%'/><img src='graphs.gif' style='width:$j%; height:75%'/></td></tr>";
				}
				elseif ($_POST['graphs']=="-Συμμετοχηκότητα (#)"){
					echo "<td><img src='graphs.gif' style='width:$j%; height:75%'/>".$row["7"]."</td></tr>";
				}
				elseif ($_POST['graphs']=="-Δηλώσεις"){
					echo "<td><img src='graphs.gif' style='width:$j%; height:75%'/>".$row["6"]."</td></tr>";
				}
				else {
					echo "<td><img src='graphs.gif' style='width:$j%; height:75%'/>".intval($j)."%</td></tr>";
				}				
			}
			mysql_close($dblink);
		?>
		</tr>
		</form>
	</table>
</body>
</html>