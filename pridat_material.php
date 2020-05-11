<?php
// Zamestnanec - upravit zakazku, na ktere pracuje

if(!isset($_SESSION["cas"]))session_start();

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
	<TD width="85%" colspan="2" align="center" valign="center"><h2>Pridat material k aktualni zakazce:</h2><br>
		<form method="post" action="pridat_material_sql.php">
			Mnozstvi: <input type="text" name="mnozstvi" size="20">
			Cena: <input type="text" name="cena" size="20"> 
			Typ: <input type="text" name="typ" size="20">
			Datum splatnosti: <input type="text" name="splatnost_do" size="20" value="<?php echo date("j.n.Y");?>"><br><br>
			<input type="submit" value="Pridat material"> 
		</form> 
	</TD>
</TR>
</table>
</body>
</html>