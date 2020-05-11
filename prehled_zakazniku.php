<?php
// Admin - prehled zakazniku

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
	<TD width="85%" colspan="2" align="center" valign="center"><h2>Prehled zakazniku:</h2><br>
		<table border="1" align ="center">
			<tr height="5%">
				<th>Rodne cislo</th>
				<th>Jmeno</th>
				<th>Prijmeni</th>
				<th>Adresa</th>
				<th>Dulezitost</th>
				<th>Zakazky</th>
			</tr>
			<?php
				$databaze = mysql_connect("localhost:/var/run/mysql/mysql.sock", "xrisam00", "5apahapo")  or die("Nelze se připojit k MySQL: ". mysql_error());
				  mysql_select_db("xrisam00") or die("Nelze vybrat databázi: ". mysql_error());
				$vysledek = mysql_query("SELECT * FROM zakaznik");	
				while ($zaznam=MySQL_Fetch_Array($vysledek))
				{
					?> <tr height="5%">
						<td width="5%"><?php echo $zaznam["RC"]; ?> </td>
						<td width="5%"><?php echo $zaznam["Jmeno"]; ?> </td>
						<td width="5%"><?php echo $zaznam["Prijmeni"]; ?> </td>
						<td width="15%"><?php echo $zaznam["Adresa"]; ?> </td>
						<td width="2%"><?php echo $zaznam["Dulezitost"]; ?> </td>
            <?php
               $vyter = mysql_query("SELECT * FROM zakazka where fk_zakaznik='".$zaznam["RC"]."' ");
               $radku = mysql_num_rows($vyter);
            if ($radku ==0){
              
            ?>
						<td width="2%"><?php echo "Zadne";
            }
            else{?>
            <td width="2%">
            <select>
            <?php
            
            while($zaser=MySQL_Fetch_Array($vyter)){?>
 <option value="<?php echo $zaser["Popis"];?>"><?php echo $zaser["Popis"];?></option> 
<?php
            } 
            ?>
            </select>
            <?php }?>
            </td>
						
					<?php 
				}	
				mysql_close($databaze);
			?>
		</TABLE>
	</TD>
</TR>
</table>
</body>
</html>