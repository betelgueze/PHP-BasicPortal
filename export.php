<?php
// Okno, pro hlavni stranku zamestnance
if(!isset($_SESSION["cas"]))session_start();
if ($_SESSION["timeout"] + 5 * 60 < time())
{ // neaktivita 5minut
	require 'odhlaseni.php';
}
$_SESSION["timeout"] = time(); // nastavi aktualni cas, kvuli aut. odhlaseni
  $databaze = mysql_connect("localhost:/var/run/mysql/mysql.sock", "xrisam00", "5apahapo") or die("Nelze se pøipojit k MySQL: ". mysql_error());
  mysql_select_db("xrisam00") or die("Nelze vybrat databázi: ". mysql_error());
  $vyber = mysql_query("select * from hesla");
  header('Content-disposition: attachment; filename="'.$_POST["file"].'"');
  header('Content-type: "text/xml"; charset="utf8"');
  echo("<?xml version=\"1.0\" encoding=\"UTF-8\""." ?".">\n");
  echo("<hesla>");
  while($row = mysql_fetch_assoc($vyber)){
    echo ("<uzivatel ");
    echo ("ID=\"".$row["ID"]);
    echo ("\">\n");
    echo ("<login>");
    echo $row["Login"];
    echo ("</login>");
    echo ("<heslo>");
    echo $row["Heslo"];
    echo ("</heslo>");
    echo ("<JeAdmin>");
    echo $row["JeAdmin"];
    echo ("</JeAdmin>");
    echo ("</uzivatel>");
  }
echo("</hesla>"); 
mysql_close($databaze);
?>
