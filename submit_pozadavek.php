<?php
// Admin - pridat uzivatele

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
		<form method="post" action="pridat_pozadavek.php"> 
		<input type="submit" value="Zadat dalsi"> </form><BR>
	</TD> 
	<TD width="85%" colspan="2">
  <?php
	  //echo $_POST["zakazka"];
	  $databaze = mysql_connect("localhost:/var/run/mysql/mysql.sock", "xrisam00", "5apahapo")  or die("Nelze se p�ipojit k MySQL: ". mysql_error());
    mysql_select_db("xrisam00") or die("Nelze vybrat datab�zi: ". mysql_error());

    $vyber = mysql_query("select * from hesla where Login='".$_SESSION["login"]."' ");
    $row = mysql_fetch_assoc($vyber);
    mysql_free_result($vyber);
    $vyber = mysql_query("select * from zakaznik where fk_ID='".$row["ID"]."' ");
    $zak = mysql_fetch_assoc($vyber);
    mysql_free_result($vyber);
    //zakazy
    $vyber = mysql_query("select * from zakazka where fk_zakaznik='".$zak["RC"]."' ");
    //pre vsetky zakazky
    while($zakaz = mysql_fetch_assoc($vyber)){
      //najde mazanu zakazku
      if($zakaz["Popis"] == $_POST["zakazka"])break;
    }
    mysql_free_result($vyber);
    mysql_query("INSERT INTO pozadavek(Popis,fk_osoba,fk_zakazka) VALUES('".$_POST["pozadavek"]."', '".$zak["RC"]."', '".$zakaz["ID"]."' )");
    mysql_close($databaze);
  ?>
  <form method="post" action="zakaznik.php"> 
	<input type="submit" value="Dale do menu"> </form><BR>
	</TD>
</TR>
</table>
</body>
