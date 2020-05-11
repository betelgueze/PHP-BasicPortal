<?php
// Zamestnanec - pridat material - prace s databazi

session_start();

$databaze = mysql_connect("localhost:/var/run/mysql/mysql.sock", "xrisam00", "5apahapo")  or die("Nelze se připojit k MySQL: ". mysql_error());
  mysql_select_db("xrisam00") or die("Nelze vybrat databázi: ". mysql_error());

if(!empty($_POST["hodnota"]) and !empty($_POST["splatnost"])) 
{ // pokud jsou vsechny udaje vyplnene
	if(!is_numeric($_POST["hodnota"]) or is_numeric($_POST["splatnost"]))
	{ // nejaky udaj je spatne napsan
		mysql_close($databaze);?>
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-2">
		<title>Informacni system stavebni firmy</title>
		</head>

		<body>
		<table height="100%" width="100%" border="2">
		<TR height="25%">
			<TD colspan="2" width="68%">
				<img src="../Logo2.jpg" width="68%">
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
			<TD width="85%" colspan="2" align="center" valign="center">
				<?php echo "<H2>Spatne zadane udaje!</H2>" ?>
				<form method="post" action="pridat_fakturu.php"> 
				<input type="submit" value="Zpet"> </form><BR>
			</TD>
		</TR>
		</table>
		</body>
		</html>
	<?php
	}	
	else
	{ // vsechno je zadano spravne
		if(isset($_SESSION["id_zak2"]))
		{ // pokud prave pracuje na nejake zakazce
			$vysledek = "INSERT INTO faktura (Hodnota_faktury, Datum_splatnosti, fk_zakazka) VALUES ('".$_POST["hodnota"]."', '".$_POST["splatnost"]."', '".$_SESSION["id_zak2"]."')";
			mysql_query($vysledek);
		}
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: faktura_zobraz.php");
		header("Connection: close");
	}	
}
else
{ // nektera polozka nevyplnena
	mysql_close($databaze);?>
	<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-2">
	<title>Informacni system stavebni firmy</title>
	</head>

	<body>
	<table height="100%" width="100%" border="2">
	<TR height="25%">
		<TD colspan="2" width="68%">
			<img src="../logo2.jpg" width="68%">
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
		</TD> 
		<TD width="85%" colspan="2" align="center" valign="center">
			<?php echo "<H2>Nevyplnili jste vsechny udaje!</H2>" ?>
			<form method="post" action="pridat_fakturu.php"> 
			<input type="submit" value="Zpet"> </form><BR>
		</TD>
	</TR>
	</table>
	</body>
	</html>
	<?php
}
?>

