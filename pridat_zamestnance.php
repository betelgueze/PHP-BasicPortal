<?php
// Admin - pridat zamestnance

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
		<br><h2>HLAVN� MENU</h2><br>
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
	<TD width="85%" colspan="2" align="center" valign="center"><h2>Pridat noveho zamestnance:</h2><br>
		<form method="post" action="pridat_zamestnance_sql.php">
			<input type="radio" name="typ_uz" value="zamestnanec" > Zamestnanec
			<input type="radio" name="typ_uz" value="e_zamestnanec" > Externi Zamestnanec<br><br>
			Rodne cislo: <input type="text" name="rc" size="20">
			Jmeno: <input type="text" name="jmeno" size="20"> 
			Prijmeni: <input type="text" name="prijmeni" size="20"><br><br>
			Adresa: <input type="text" name="adresa" size="20"> 
			Mzda: <input type="text" name="mzda" size="20">
			Hodnoceni: <input type="text" name="hodnoceni" size="20"><br><br> 
			Login: <input type="text" name="login" size="20">
			Heslo: <input type="password" name="heslo" size="20"><br><br> 
			<input type="submit" value="Pridat zamestnance"> 
		</form> 
	</TD>
</TR>
</table>
</body>
</html>