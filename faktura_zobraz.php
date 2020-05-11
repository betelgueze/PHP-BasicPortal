<?php
// Zamestnanec - upravit zakazku, na ktere pracuje

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
		<form method="post" action="historie_zakazek.php">
		<input type="submit" value="Historie mych zakazek"> </form><br>
		<form method="post" action="pozadavky.php">
		<input type="submit" value="Pozadavky k aktualni zakazce"> </form><br>
		<form method="post" action="pridat_material.php">
		<input type="submit" value="Pridat material k aktualni zakazce"> </form><br>
		<form method="post" action="pridat_fakturu.php">
		<input type="submit" value="Pridat fakturu k aktualni zakazce"> </form><br>
		<form method="post" action="material_zobraz.php">
		<input type="submit" value="Zobraz material k aktualni zakazce"> </form><br>
		<form method="post" action="faktura_zobraz.php">
		<input type="submit" value="Zobraz faktury k aktualni zakazce"> </form><br>
	</TD> 
	<TD width="85%" colspan="2" align="center" valign="center"><h2>Zobrazit faktury k aktualni zakazce:</h2><br>
		<table border="1" align ="center">
			<tr height="5%">
				<th>Hodnota</th>
				<th>Datum splatnosti</th>
		<?php
		    if(isset($_SESSION["id_zak2"])){
				$databaze = mysql_connect("localhost:/var/run/mysql/mysql.sock", "xrisam00", "5apahapo") or die("Nelze se připojit k MySQL: ". mysql_error());
				mysql_select_db("xrisam00") or die("Nelze vybrat databázi: ". mysql_error());
				$vysledek = mysql_query("SELECT * FROM faktura WHERE fk_zakazka = '".$_SESSION["id_zak2"]."'");	
				while ($zaznam = MySQL_Fetch_Array($vysledek))
				{
					?> <tr height="5%">
						<td width="5%"><?php echo $zaznam["Hodnota_faktury"]; ?> </td>
						<td width="5%"><?php echo $zaznam["Datum_splatnosti"]; ?> </td>					
					<?php 
				}	
				mysql_close($databaze);
				}
				else echo "nemate zadnou aktivni zakazku";
			?>
				
	</TD>
</TR>
</table>
</body>
</html>