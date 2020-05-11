<?php
// Okno, kdy je spatne zadane uzivatelske jmeno nebo heslo
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
		<form method="post" action="registrace.php">
		Login: <input type="text" name="login" value="<?php echo $_POST["login"]?>"size="20">
		<p>Heslo: <input type="password" name="heslo" size="20"> </p>
		<br><input type="submit" value="Prihlaseni"> </form> 
	</TD> 
</TR>
<TR height="5%"> 
	<TD width="100%" colspan="3" bgcolor="grey"></TD> 
</TR>
<TR height="70%">
	<TD width="15%" valign="top" align="center">
		<br><h2>HLAVNÍ MENU</h2>
	</TD> 
	<TD width="85%" colspan="2" align="center" valign="center">
		<?php 
		echo "<h2>Nejste zaregistrovan, nebo je spatne zadane heslo!</h2>";
		?>
	</TD>
</TR>
</table>
</body>
</html>