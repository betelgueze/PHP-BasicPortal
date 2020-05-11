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
		<br><h2>HLAVNÍ MENU</h2><br>
		<form method="post" action="zrusit_uzivatele.php"> 
		<input type="submit" value="Zrusit dalsieho"> </form><BR>
	</TD> 
	<TD width="85%" colspan="2">
  <?php
	  if($_POST["login"]=="admin")die ("nemozes vymazat sam seba");
	  else{
	  $databaze = mysql_connect("localhost:/var/run/mysql/mysql.sock", "xrisam00", "5apahapo")  or die("Nelze se připojit k MySQL: ". mysql_error());
      mysql_select_db("xrisam00") or die("Nelze vybrat databázi: ". mysql_error());
    //pre vsetkych uzivatelov
    $vyber = mysql_query("select * from hesla where Login='".$_POST["login"]."' ");
    $row = mysql_fetch_assoc($vyber);
    mysql_free_result($vyber);
    //zakaznik
    if($row["JeAdmin"]==2){
      $vyber = mysql_query("select * from zakaznik where fk_ID='".$row["ID"]."' ");
      $zakaznik = mysql_fetch_assoc($vyber);
      mysql_free_result($vyber);
      //zakazky
      $vyber = mysql_query("select * from zakazka where fk_zakaznik='".$zakaznik["RC"]."' ");
      //pre vsetky zakazky
      while($zakazka = mysql_fetch_assoc($vyber)){
        //zmaz vsetky poziadavky ku zakazke
        mysql_query("delete from pozadavek where fk_zakazka='".$zakazka["ID"]."' ");
        //zmaz vsetok material ku zakazke
        mysql_query("delete from material where fk_zakazka='".$zakazka["ID"]."' ");
        //zmazat vsetky faktury
        mysql_query("delete from faktura where fk_zakazka='".$zakazka["ID"]."' ");
      }
      mysql_free_result($vyber);
      //zmaz zaznam o zakaznikovi
      mysql_query("delete from zakaznik where RC='".$zakaznik["RC"]."' ");
      //zmaz zaznam o hesle
      mysql_query("delete from hesla where Login='".$row["Login"]."' ");
      mysql_close($databaze);
    }
    //zamestnanec
    else{
      //zmaz zaznam o zamestnancovi
      mysql_query("delete from zamestnanec where fk_ID='".$row["ID"]."' ");
      //zmaz zaznam o hesle
      mysql_query("delete from hesla where Login='".$row["Login"]."' ");
      mysql_close($databaze);
    }
    }
  ?>
  <form method="post" action="zakaznik.php"> 
	<input type="submit" value="Dale do menu"> </form><BR>
	</TD>
</TR>
</table>
</body>
