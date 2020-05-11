<?php
require 'funkce.php';
// pripojeni k databazi sfirma na localhostu
$databaze = mysql_connect("localhost:/var/run/mysql/mysql.sock", "xrisam00", "5apahapo")  or die("Nelze se pøipojit k MySQL: ". mysql_error());
mysql_select_db("xrisam00") or die("Nelze vybrat databázi: ". mysql_error());
$vyber = mysql_query("select * from hesla where Login='".$_POST["login"]."' ");
$radku = mysql_num_rows($vyber);
if($radku == 0)
{ // pokud neni zadany login v databazi
	require 'neprihlasen.php';
}
else
{ // login je v databazi
	while($zaznam = MySQL_Fetch_Array($vyber))
	{	// vybiram jednotlive zaznamy z databaze
		if($zaznam["Heslo"] != $_POST["heslo"])
		{ // spatne zadane heslo
			require 'neprihlasen.php';
		}
		else
		{ // login i heslo sedi
			// nastavi novou session
			session_start();
			
			$_SESSION["cas"]=time(); // nastavi cas prihlaseni
			$_SESSION["login"] = $_POST["login"];
			$_SESSION["timeout"] = time(); // nastavi aktualni cas, kvuli aut. odhlaseni
			$id = zjisti_id($_POST["login"], $_POST["heslo"], $databaze);
			$_SESSION["ID"] = $id; // nastav ID Session
			
			if($zaznam["JeAdmin"] == 1)
			{ // admin		
				require 'admin.php';
			}
			else if($zaznam["JeAdmin"] == 2)
			{ // zakaznik
				require 'zakaznik.php';
			}
			else
			{ // zamestnanci a externi zamestnanci
				require 'zamestnanec.php';
			}
		}
	}
}
mysql_close($databaze);  
?> 