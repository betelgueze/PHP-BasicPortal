<?php
// Admin - prehled zamestnancu - uz vypis

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
		<table border="1" align ="center">
			<?php
			if($_POST["typ_uz"] == "e_zamestnanec") 
			{ // ext_zamestnanci 
			?>
			<h2>Prehled externich zamestnancu:</h2><br>
			<form method="post" action="prehled_ext_zamestnancu.php">
			<input type="radio" name="typ_uz" value="zamestnanec" Checked> Zamestnanci
			<input type="radio" name="typ_uz" value="e_zamestnanec"> Externi Zamestnanci<br><br>
			<input type="submit" value="Zobrazit">
			</form><br><br>
			<tr height="5%">
				<th>Rodne cislo</th>
				<th>Jmeno</th>
				<th>Prijmeni</th>
				<th>Adresa</th>
				<th>Mzda</th>
				<th>Hodnoceni</th>
				<th>Prace na zakazce o ID</th>
			</tr>
			<?php
				$databaze = mysql_connect("localhost:/var/run/mysql/mysql.sock", "xrisam00", "5apahapo") or die("Nelze se připojit k MySQL: ". mysql_error());
				mysql_select_db("xrisam00") or die("Nelze vybrat databázi: ". mysql_error());
				$vysledek = mysql_query("SELECT * FROM externi_zamestnanec");	
				$vysledek = mysql_query("SELECT * FROM externi_zamestnanec");	
				while ($zaznam=MySQL_Fetch_Array($vysledek))
				{
					?> <tr height="5%">
						<td width="5%"><?php echo $zaznam["RC"]; ?> </td>
						<td width="5%"><?php echo $zaznam["Jmeno"]; ?> </td>
						<td width="5%"><?php echo $zaznam["Prijmeni"]; ?> </td>
						<td width="15%"><?php echo $zaznam["Adresa"]; ?> </td>
						<td width="5%"><?php echo $zaznam["Mzda"]; ?> </td>
						<td width="2%"><?php echo $zaznam["Hodnoceni"]; ?> </td>
						<?php
						$prac = 0;
						//pre vsetky polozky v historii
						$vysledek2 = mysql_query("SELECT * FROM historie WHERE fk_zakaznik = '".$zaznam["RC"]."' ");	
						if($vysledek2){
						while ($zaznam2 = MySQL_Fetch_Array($vysledek2))
						{
							//pre danu zakazky
							$vysledek3 = mysql_query("SELECT * FROM zakazka WHERE fk_zakazka = '".$zaznam2["ID"]."' ");	
							$zaznam3 = MySQL_Fetch_Array($vysledek3);
							if($zaznam3["Stav"]==1)$prac=1;
						}
						}
						if($prac!=1)
						{ ?>
						<td width="5%"><?php echo "Nema praci"; ?> </td> <?php
						}
						else
						{ ?>
						<td width="5%"><?php echo "Pracuje" ?> </td> <?php
						}
				}	
				mysql_close($databaze);
			}
			else
			{ // zamestnanci 
			?>
			<h2>Prehled zamestnancu:</h2><br>
			<form method="post" action="prehled_ext_zamestnancu.php">
			<input type="radio" name="typ_uz" value="zamestnanec" Checked> Zamestnanci
			<input type="radio" name="typ_uz" value="e_zamestnanec"> Externi Zamestnanci<br><br>
			<input type="submit" value="Zobrazit">
			</form><br><br>
			<tr height="5%">
				<th>Rodne cislo</th>
				<th>Jmeno</th>
				<th>Prijmeni</th>
				<th>Adresa</th>
				<th>Mzda</th>
				<th>Hodnoceni</th>
				<th>Prace na zakazce o ID</th>
			</tr>
			<?php
				$databaze = mysql_connect("localhost:/var/run/mysql/mysql.sock", "xrisam00", "5apahapo")  or die("Nelze se připojit k MySQL: ". mysql_error());
				  mysql_select_db("xrisam00") or die("Nelze vybrat databázi: ". mysql_error());
				$vysledek = mysql_query("SELECT * FROM zamestnanec");	
				while ($zaznam=MySQL_Fetch_Array($vysledek))
				{
					?> <tr height="5%">
						<td width="5%"><?php echo $zaznam["RC"]; ?> </td>
						<td width="5%"><?php echo $zaznam["Jmeno"]; ?> </td>
						<td width="5%"><?php echo $zaznam["Prijmeni"]; ?> </td>
						<td width="15%"><?php echo $zaznam["Adresa"]; ?> </td>
						<td width="5%"><?php echo $zaznam["Mzda"]; ?> </td>
						<td width="2%"><?php echo $zaznam["Hodnoceni"]; ?> </td>
						<?php
						$prac = 0;
						//pre vsetky polozky v historii
						$vysledek2 = mysql_query("SELECT * FROM historie WHERE fk_zakaznik = '".$zaznam["RC"]."' ");	
						if($vysledek2){
						while ($zaznam2 = MySQL_Fetch_Array($vysledek2))
						{
							//pre danu zakazky
							$vysledek3 = mysql_query("SELECT * FROM zakazka WHERE fk_zakazka = '".$zaznam2["ID"]."' ");	
							$zaznam3 = MySQL_Fetch_Array($vysledek3);
							if($zaznam3["Stav"]==1)$prac=1;
						}
						}
						if($prac!=1)
						{ ?>
						<td width="5%"><?php echo "Nema praci"; ?> </td> <?php
						}
						else
						{ ?>
						<td width="5%"><?php echo "Pracuje" ?> </td> <?php
						}
				}	
				mysql_close($databaze);
			}
			?>
		</TABLE>
	</TD>
</TR>
</table>
</body>
</html>