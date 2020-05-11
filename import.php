<?php
// Okno, pro hlavni stranku zamestnance
if(!isset($_SESSION["cas"]))session_start();
if ($_SESSION["timeout"] + 5 * 60 < time())
{ // neaktivita 5minut
	require 'odhlaseni.php';
}
$_SESSION["timeout"] = time(); // nastavi aktualni cas, kvuli aut. odhlaseni
  $databaze = mysql_connect("localhost:/var/run/mysql/mysql.sock", "xrisam00", "5apahapo")  or die("Nelze se pøipojit k MySQL: ". mysql_error());
    mysql_select_db("xrisam00") or die("Nelze vybrat databázi: ". mysql_error());  
  // Create uploads directory if necessary
  if(!file_exists('uploads')) mkdir('uploads');

  // Move the file
  if(move_uploaded_file($_FILES['file']['tmp_name'], 
'uploads/' . $_FILES['file']['name'])) {
    //echo("<p>File uploaded successfully!</p>\r\n");
} else {
    echo("<p>There was an error moving the file.</p>\r\n");
}
chdir('uploads');
  $subor = fopen($_FILES['file']['name'],"r") or die("neexistujuci subor");
  //parse xml string into SimpleXML objects
  $result = fread($subor, filesize($_FILES['file']['name']));
  $xml = simplexml_load_string($result);

  if ($xml === false) {
    die('Error parsing XML');   
  }
  
foreach($xml->children() as $node) {
  $arr = $node->attributes();   // returns an array
  $index=0;
  foreach($node->children() as $nod) {
    if($index ==0)$login = $nod;
    else if($index == 1)$heslo = $nod;
    else $atr = $nod;
    $index++;
  }
  $vyber = mysql_query("select * from hesla where ID=".$arr["ID"]);
  $radku = mysql_num_rows($vyber);
  //vkladame
  if($radku == 0){
    echo "insert".$login." ".$heslo;
    mysql_query("insert into hesla(Login,Heslo,JeAdmin) values('".$login."' , '".$heslo."' , '".$atr."' )");
  }
  //updatujeme
  else{
    mysql_query("delete from hesla where ID='".$arr["ID"]."' ");
    mysql_query("insert into hesla(Login,Heslo,JeAdmin) values('".$login."' , '".$heslo."' , '".$atr."' )");
  }
   
}
 mysql_free_result($vyber);
mysql_close($databaze);
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
	</TD> 
	<TD width="85%" colspan="2">
	<?php
	   echo "Import sa provedl<BR>";?>
	   <form method="post" action="admin.php">
		<input type="submit" value="Dale"> </form><BR>      
  </TD>
</TR>
</table>
</body>
</html>