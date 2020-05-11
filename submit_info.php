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
		<form method="post" action="zakaznik.php"> 
		<input type="submit" value=<?php
      if(!($_POST["meno"] or $_POST["priezvysko"] or $_POST["adresa"]))echo "Zpet";
      else echo "Dale";
      ?>
    > </form><BR>
	</TD> 
	<TD width="85%" colspan="2">
  <?php
  $error=0;
  if(is_numeric($_POST["meno"]) or is_numeric($_POST["priezvysko"]) or is_numeric($_POST["adresa"])){
    include 'zmena_info_err.php';
    $error=1;
  }
  //ziskaj aktualne info
  else{
  $databaze = mysql_connect("localhost:/var/run/mysql/mysql.sock", "xrisam00", "5apahapo")  or die("Nelze se připojit k MySQL: ". mysql_error());
    mysql_select_db("xrisam00") or die("Nelze vybrat databázi: ". mysql_error());

  $vyber = mysql_query("select * from hesla where Login='".$_SESSION["login"]."' ");
  $row = mysql_fetch_assoc($vyber);
  mysql_free_result($vyber);
  $vyber = mysql_query("select * from zakaznik where fk_ID='".$row["ID"]."' ");
  $zak = mysql_fetch_assoc($vyber);
  $radku = mysql_num_rows($vyber);
  mysql_free_result($vyber);
  if($radku != 1)  die("Neplatny zakaznik");
	if($_POST["meno"])
	  $meno = $_POST["meno"];
  else
    $meno = $zak["Jmeno"];
	if($_POST["priezvysko"])
	  $priezvysko = $_POST["priezvysko"];
	else
	  $priezvysko = $zak["Prijmeni"];
  if($_POST["adresa"])
    $adresa = $_POST["adresa"];
	else
    $adresa = $zak["Adresa"];
    $rodne_cislo = $zak["RC"];
    $dvolezitost = $zak["Dulezitost"];
    $fk_id = $zak["fk_ID"]; 
    if(!is_numeric($rodne_cislo)) die("zadali ste nespravne rodne cislo");
	//uloz
	  mysql_query("DELETE from zakaznik WHERE RC='".$zak["RC"]."' ");
	  $dotaz = "INSERT INTO zakaznik (RC,Dulezitost,Jmeno,Prijmeni,Adresa,fk_ID) VALUES( '".$rodne_cislo."' , '".$dvolezitost."' , '".$meno."' , '".$priezvysko."' , '".$adresa."' , '".$fk_id."' )";
	  mysql_query($dotaz);
	  mysql_close($databaze);
	  echo"vase zmeny byly provedeny";
	  }
  ?>
	</TD>
</TR>
</table>
</body>
