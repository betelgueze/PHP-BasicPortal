<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-2">
<title>Informacni system stavebni firmy</title>
</head>

<body>
<table height="100%" width="100%" border="0">
<TR height="100%">
	<TD width="100%" colspan="0">
	<?php 
    echo "Zadajte Spravne osobne udaje bez cisel na nezmyslenych miestach<BR>";
    $databaze = mysql_connect("localhost:/var/run/mysql/mysql.sock", "xrisam00", "5apahapo")  or die("Nelze se připojit k MySQL: ". mysql_error());
    mysql_select_db("xrisam00") or die("Nelze vybrat databázi: ". mysql_error());

  $vyber = mysql_query("select * from hesla where Login='".$_SESSION["login"]."' ");
  $row = mysql_fetch_assoc($vyber);
  mysql_free_result($vyber);
  $vyber = mysql_query("select * from zakaznik where fk_ID='".$row["ID"]."' ");
  $zak = mysql_fetch_assoc($vyber);
  mysql_close($databaze);
  ?>
  <form method="post" action="submit_info.php">
    Meno:<input type="text" size="12" maxlength="10" name="meno" value="<?php echo $zak["Jmeno"]?>"><br />
    Priezvysko:<input type="text" size="12" maxlength="10" name="priezvysko"value="<?php echo $zak["Prijmeni"]?>"><br />
    Adresa:<input type="text" size="20" maxlength="10" name="adresa" value="<?php echo $zak["Adresa"]?>"<br /> 
	<input type="submit" value="Ok"> </form><BR>                                              
  </TD>
</TR>
</table>
</body>
