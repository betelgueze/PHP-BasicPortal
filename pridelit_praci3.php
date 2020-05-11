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
	<TD width="85%" colspan="2" align="center" valign="center">
		<?php // formular s loginama 
    $databaze = mysql_connect("localhost:/var/run/mysql/mysql.sock", "xrisam00", "5apahapo")  or die("Nelze se připojit k MySQL: ". mysql_error());
		  mysql_select_db("xrisam00") or die("Nelze vybrat databázi: ". mysql_error());
		$vysledok = mysql_query("SELECT * FROM hesla where Login='".$_POST["lol"]."'");
		$login = mysql_fetch_assoc($vysledok);
		mysql_free_result($vysledok);
		$vysledok = mysql_query("SELECT * FROM zamestnanec where fk_ID='".$login["ID"]."'");
		$zamestnanec = mysql_fetch_assoc($vysledok);
		mysql_free_result($vysledok);
		$vysledok = mysql_query("SELECT * FROM zakazka where Popis='".$_POST["zakazky"]."'");
		$zakazka = mysql_fetch_assoc($vysledok);
		mysql_free_result($vysledok);
		$vysledok = mysql_query("SELECT * FROM historie where fk_zakazka='".$zakazka["ID"]."' AND fk_zamestnanec='".$zamestnanec["RC"]."'");
		if(mysql_num_rows($vysledok)!=0)die("zamestnanec uz na danej zakazke pracuje");
		else{
		  mysql_query("INSERT INTO historie(fk_zamestnanec,fk_zakazka) values('".$zamestnanec["RC"]."','".$zakazka["ID"]."')");
		  mysql_close($databaze); 
		  echo "zamestnanec bol prideleny na zakazku";
    }
			?>
		
	</TD>
</TR>
</table>
</body>
</html>