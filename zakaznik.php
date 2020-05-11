<?php
// Okno, pro hlavni stranku zakaznika
if(!isset($_SESSION["cas"]))session_start();
if ($_SESSION['timeout'] + 5 * 60 < time())
{ // neaktivita 5minut
	require 'odhlaseni.php';
}
$_SESSION['timeout'] = time(); // nastavi aktualni cas, kvuli aut. odhlaseni
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
		<form method="post" action="pridat_zakazku.php">
		<input type="submit" value="Zadat zakazku"> </form><BR>
		<form method="post" action="zrusit_zakazku.php">
		<input type="submit" value="Zrusit zakazku"> </form><BR>
		<form method="post" action="zmena_info.php">
		<input type="submit" value="Zmenit osobní údaje"> </form><BR>
		<form method="post" action="pridat_pozadavek.php">
		<input type="submit" value="Pridat pozadavek"> </form><BR>
		<form method="post" action="moje_faktury.php">
		<input type="submit" value="Moje Faktúry"> </form><BR>
	</TD> 
	<TD width="85%" colspan="2">
	<?php
	   //vypis vsetkych zakazok pre daneho zakaznika
      $databaze = mysql_connect("localhost:/var/run/mysql/mysql.sock", "xrisam00", "5apahapo")  or die("Nelze se připojit k MySQL: ". mysql_error());
        mysql_select_db("xrisam00") or die("Nelze vybrat databázi: ". mysql_error());

      //ziskaj id helsa
      $vyber = mysql_query("select * from hesla where Login='".$_SESSION["login"]."' ");
      $row = mysql_fetch_assoc($vyber);
      mysql_free_result($vyber);
      //ziskaj rodne cislo klienta
      $vyber = mysql_query("select * from zakaznik where fk_ID='".$row["ID"]."' ");
      $zak = mysql_fetch_assoc($vyber);
      $radku = mysql_num_rows($vyber);
      mysql_free_result($vyber);
      //ziskaj vsetky zakazky podla RC
      $vyber = mysql_query("select * from zakazka where fk_zakaznik='".$zak["RC"]."' ");
      $index = 1; 
      $zakaz = mysql_fetch_array($vyber);
      echo "Uzivatel:";echo " ".$zak["Jmeno"];echo " ".$zak["Prijmeni"];echo "<BR>Bydliskom ";echo $zak["Adresa"];
      //echo "<BR>Vase zakazky<BR> <tr height=\"5%\"><td width=\"5%\">Cislo</td><td width=\"5%\">Stav</td><td width=\"5%\">Popis</td>";
      $zakazka1 = $zakaz["ID"];
      $_SESSION["zakazka"] = $zakazka1;
      while($zakaz){
        $zakazka = $zakaz["ID"];
        echo "<BR>";
        echo $index;
        echo ". ZAKAZKA";
        echo "<BR>";
        echo "STAV ZAKAZKY:";
        if($zakaz["Stav"]== 0)
          echo " Nevyrizena ";
        else
          echo " Vyrizena ";
        echo "<BR>";
        echo "Popis zakazky:";
        echo $zakaz["Popis"];
        echo "<BR>";
      //<form method="post" action="pridat_pozadavek.php">
		  //<input type="submit" value="pridat pozadavek"> </form>
  
        $index = $index+1;
        $vyser = mysql_query("select * from pozadavek where fk_zakazka='".$zakaz["ID"]."' ");
        $radku = mysql_num_rows($vyser);
        echo "poziadavky ku zakazke :<BR>";
        if($radku == 0)echo "nemate ziadne poziadavky <BR>";
        $ind = 1;
        while($aha = mysql_fetch_array($vyser)){
          echo $ind; echo ":";
          echo $aha["Popis"];
          echo "<BR>";
          $ind = $ind + 1;
        }
        mysql_free_result($vyser);
        $zakaz = mysql_fetch_assoc($vyber);
      }
      mysql_free_result($vyber);
  ?>
  </TD>
</TR>
</table>
</body>
</html>