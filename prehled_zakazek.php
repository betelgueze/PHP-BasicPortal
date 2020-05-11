<?php
// Admin - prehled zakazek

session_start();

if ($_SESSION["timeout"] + 5 * 60 < time())
{ // neaktivita 5minut
	require 'odhlaseni.php';
}
$_SESSION["timeout"] = time(); // nastavi aktualni cas, kvuli aut. odhlaseni
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-2">
<title>Informacni system stavebni firmy</title>
</head>

<body>
<table height="100%" width="100%" border="2">
<TR height="25%">
	<TD colspan="2" width="68%">
		<img src="./Logo2.jpg" width="68%">
	</TD> 
	<TD width="32%" align="center" valign="center">
		<?php 
		echo "<H3>Prihlasen: ".$_SESSION["login"]."<BR></H3>";
		echo "Cas prihlaseni: ".date("j.n.Y G:i:s",$_SESSION["cas"])."<BR><BR>";
		?>
		<form method="post" action="odhlaseni.php">
		<input type="submit" value="Odhlaseni"> </form> 
	</TD> 
</TR>
<TR height="5%"> 
	<TD width="100%" colspan="3" bgcolor="grey"></TD> 
</TR>
<TR height="70%">
	<TD width="15%" valign="top" align="center">
		<br><h2>HLAVNÍ MENU</h2><br>
		<form method="post" action="ex.php"> 
		<input type="submit" value="Export/Import"> </form>
		<form method="post" action="pridat_zakaznika.php"> 
		<input type="submit" value="Pridat zakaznika"> </form>
		<form method="post" action="pridat_zamestnance.php"> 
		<input type="submit" value="Pridat zamestnance"> </form>
		<form method="post" action="zrusit_uzivatele.php">
		<input type="submit" value="Zrusit uzivatele"> </form>
		<form method="post" action="prehled_zakazek.php">
		<input type="submit" value="Prehled zakazek"> </form>
		<form method="post" action="prehled_zamestnancu.php">
		<input type="submit" value="Prehled zamestnancu"> </form>
		<form method="post" action="prehled_zakazniku.php">
		<input type="submit" value="Prehled zakazniku"> </form>
		<form method="post" action="pridelit_praci.php">
		<input type="submit" value="Pridelit praci"> </form>
	</TD> 
	<TD width="85%" colspan="2" align="center" valign="center"><h2>Prehled zakazek:</h2><br>
		<table border="1" align ="center">
			<tr height="5%">
				<th>ID</th>
				<th>Zakaznik</th>
				<th>Stav</th>
				<th>Popis</th>
				<th>Material</th>
				<th>Faktury</th>
			</tr>
			<?php
				$databaze = mysql_connect("localhost:/var/run/mysql/mysql.sock", "xrisam00", "5apahapo")  or die("Nelze se připojit k MySQL: ". mysql_error());
				  mysql_select_db("xrisam00") or die("Nelze vybrat databázi: ". mysql_error());
				$vysledek = mysql_query("SELECT * FROM zakazka");
				while ($zaznam=MySQL_Fetch_Array($vysledek))
				{
					$vysledek2 = mysql_query("SELECT * FROM zakaznik WHERE RC = '".$zaznam["fk_zakaznik"]."' ");
					$zaznam2 = MySQL_Fetch_Array($vysledek2);
					?> <tr height="5%">
						<td width="3%"><?php echo $zaznam["ID"]; ?> </td> 
						<td width="5%"><?php echo $zaznam2["Jmeno"].$zaznam2["Prijmeni"]; ?> </td> <?php  //////////////////////////////////////?>
						<?php 
						if($zaznam["Stav"] == 0) 
						{ ?>
							<td width="5%"><?php echo "Nevyrizena"; ?> </td> 
							<?php 
						}
						else
						{ ?>
							<td width="5%"><?php echo "Vyrizena"; ?> </td> 
							<?php 
						} ?>
						<td width="5%"><?php echo $zaznam["Popis"]; ?> </td>
						<?php
						  $vyter = mysql_query("SELECT * FROM material WHERE fk_zakazka= '".$zaznam["ID"]."' ");
						  $radku = mysql_num_rows($vyter);
						  if($radku != 0){
            ?>
						<td width="5%"><select>
            <?php 
            while ($zakal=MySQL_Fetch_Array($vyter)){       ?>
 <option value="<?php echo $zakal["Typ"]." ".$zakal["Mnozstvi"]."x";?>"><?php echo $zakal["Typ"]." ".$zakal["Mnozstvi"]."x";?></option> 
<?php
         }   ?>
            </select>    <?php }else{?><td width="5%"><?php echo "ZADNY MATERIAL";}?></td>
						<?php
						  $vyter = mysql_query("SELECT * FROM faktura WHERE fk_zakazka= '".$zaznam["ID"]."' ");
						  $radku = mysql_num_rows($vyter);
						  if($radku != 0){
            ?>
						<td width="5%"><select>
            <?php 
            while ($zakal=MySQL_Fetch_Array($vyter)){       ?>
 <option value="<?php echo $zakal["Hodnota"]." ".$zakal["Datum_splatnosti"];?>"><?php echo $zakal["Hodnota"]." ".$zakal["Datum_splatnosti"];?></option> 
<?php
         }   ?>
            </select>    <?php }else{?><td width="5%"><?php echo "ZADNE FAKTURY";}?></td>
					
					<?php 
				}	
				mysql_close($databaze);
			?>
		</TABLE>
	</TD>
</TR>
</table>
</body>
</html>