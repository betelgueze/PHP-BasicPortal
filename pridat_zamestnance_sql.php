<?php
// admin - pridat zamestnance, prace s databazi

session_start();

$databaze = mysql_connect("localhost:/var/run/mysql/mysql.sock", "xrisam00", "5apahapo")  or die("Nelze se pøipojit k MySQL: ". mysql_error());
  mysql_select_db("xrisam00") or die("Nelze vybrat databázi: ". mysql_error());

// pridani zaznamu do tabulky hesla
$vysledek = "INSERT INTO hesla (Login, Heslo, JeAdmin) VALUES ('".$_POST["login"]."', '".$_POST["heslo"]."', '3')";
mysql_query($vysledek);

if(!empty($_POST["login"]) and !empty($_POST["heslo"]) and !empty($_POST["rc"]) and !empty($_POST["hodnoceni"]) and !empty($_POST["mzda"]) and !empty($_POST["jmeno"]) and !empty($_POST["prijmeni"]) and !empty($_POST["adresa"])) 
{ // pokud jsou zadane vsechny polozky
	if(!is_numeric($_POST["rc"]) or is_numeric($_POST["jmeno"]) or is_numeric($_POST["prijmeni"]) or is_numeric($_POST["adresa"]) or !is_numeric($_POST["hodnoceni"])  or !is_numeric($_POST["mzda"]) or $_POST["hodnoceni"] > '10' )
	{ // pokud je nejaky udaj zadan spatne
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
				<input type="submit" value="Pridat zakaznika"> </form><BR>
				<form method="post" action="pridat_zamestnance.php"> 
				<input type="submit" value="Pridat zamestnance"> </form><BR>
				<form method="post" action="zrusit_uzivatele.php">
				<input type="submit" value="Zrusit uzivatele"> </form><BR>
				<form method="post" action="prehled_zakazek.php">
				<input type="submit" value="Prehled zakazek"> </form><BR>
				<form method="post" action="prehled_zamestnancu.php">
				<input type="submit" value="Prehled zamestnancu"> </form><BR>
				<form method="post" action="prehled_zakazniku.php">
				<input type="submit" value="Prehled zakazniku"> </form><BR>
			</TD> 
			<TD width="85%" colspan="2" align="center" valign="center">
				<?php echo "<H2>Spatne zadane udaje!</H2>" ?>
				<form method="post" action="pridat_zamestnance.php"> 
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
			$vysledek = "SELECT * FROM hesla WHERE Login='".$_POST["login"]."'";
			$vys = mysql_query($vysledek);
			$zaznam = mysql_fetch_assoc($vys);
			session_register("typ_uz"); // promenna 'cas' v dane session

			if($_POST["typ_uz"] == "zamestnanec")
			{ // zamestnanec
				$vysledek2 = "INSERT INTO zamestnanec (RC, Jmeno, Prijmeni, Adresa, Mzda, Hodnoceni, fk_ID) VALUES ('".$_POST["rc"]."', '".$_POST["jmeno"]."', '".$_POST["prijmeni"]."', '".$_POST["adresa"]."', '".$_POST["mzda"]."', '".$_POST["hodnoceni"]."', '".$zaznam["ID"]."')";
				mysql_query($vysledek2);
				$_SESSION["typ_uz"] = $_POST["typ_uz"];
			}
			else
			{ // ext. zamestnanec
				$vysledek2 = "INSERT INTO externi_zamestnanec (RC, Jmeno, Prijmeni, Adresa, Mzda, Hodnoceni, fk_ID) VALUES ('".$_POST["rc"]."', '".$_POST["jmeno"]."', '".$_POST["prijmeni"]."', '".$_POST["adresa"]."', '".$_POST["mzda"]."', '".$_POST["hodnoceni"]."', '".$zaznam["ID"]."')";
				mysql_query($vysledek2);
				$_SESSION["typ_uz"] = $_POST["typ_uz"];
			}

			header("HTTP/1.1 301 Moved Permanently");
			header("Location: prehled_zamestnancu.php");
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
		<TD width="85%" colspan="2" align="center" valign="center">
			<?php echo "<H2>Nevyplnili jste vsechny udaje!</H2>" ?>
			<form method="post" action="pridat_zamestnance.php"> 
			<input type="submit" value="Zpet"> </form><BR>
		</TD>
	</TR>
	</table>
	</body>
	</html>
	<?php
}
?>