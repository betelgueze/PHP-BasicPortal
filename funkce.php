<?php
// Soubor s funkcemi

function zjisti_id ($login, $heslo, $databaze)
{
  $vysledek=mysql_query("select ID from hesla where Login='".$login."' and Heslo='".$heslo."'", $databaze);
  if (mysql_num_rows($vysledek)==0) return false; 
  else 
  {
    $radek = mysql_fetch_array($vysledek);
    return $radek["ID"];
  }
}
?>
