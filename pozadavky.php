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
	<TD width="85%" colspan="2" align="center" valign="center"><h2>Pozadavky k aktualni zakazce:</h2><br>
		<table border="1" align ="center">
			<tr height="5%">
				<th>Pozadavky</th>
			</tr>
		<?php
			$rc = $_SESSION["rc"];
			$databaze = mysql_connect("localhost:/var/run/mysql/mysql.sock", "xrisam00", "5apahapo")  or die("Nelze se připojit k MySQL: ". mysql_error());
			  mysql_select_db("xrisam00") or die("Nelze vybrat databázi: ". mysql_error());
			$vysledek = mysql_query("SELECT * FROM historie WHERE fk_zamestnanec = '".$rc."'");
			while ($zaznam = MySQL_Fetch_Array($vysledek)) // vsechny zakazky v historii, na kterych zamestnanec delal
			{
				$vysledek2 = mysql_query("SELECT * FROM zakazka WHERE Stav = 0");
				while ($zaznam2 = MySQL_Fetch_Array($vysledek2)) // prochazim vsechny neaktivni zakazky
				{
					if($zaznam["fk_zakazka"] == $zaznam2["ID"])
					{ // pokud je zamestnancova nejaka zakazka nehotova, vypis pozadavky
						$vysledek3 = mysql_query("SELECT * FROM pozadavek WHERE fk_zakazka = '".$zaznam2["ID"]."'");
						while ($zaznam3 = MySQL_Fetch_Array($vysledek3)) // vsechny pozadavky k aktualni zakazce
						{
						?> 
							<tr height="5%">
							<td width="5%"><?php echo $zaznam3["Popis"]; ?> </td>
						<?php
						}
					}
				}
			}
			mysql_close($databaze);
		?>
	</TD>
</TR>
</table>
</body>
</html>