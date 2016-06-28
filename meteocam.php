<CENTER>METEO</CENTER> 
<P>
<?php
$fl= array();
$ft= array();
if ($handle = opendir('./img/')) {
    while (false !== ($file = readdir($handle))) 
    { 
        if ($file != "." && $file != "..") { 
            $fl[] = array($file, filemtime('./img/'.$file));
        } 
    }
    closedir($handle); 
}
# (nomefile, ultima modifica) 
foreach ($fl as $t) {
    $tos[] = $t[1];
}
#sort per data di modifica
array_multisort($tos, SORT_DESC, $fl);
echo '<CENTER><img src="./img/'.$fl[0][0].'"></CENTER>';
echo "<P>";
$posizione=0;
$elementi= count($fl);
$colonne=4;
$righe=$elementi/$colonne;
echo '<table border="1" style="width:100%">';
for ($k = 0; $k <= $righe; $k++) {
  echo "<TR>";
  for ($i = 0; $i < $colonne; $i++) {
    if ($posizione < $elementi){
    echo "<TD><CENTER>";
    echo '<a href="./img/'.$fl[$posizione][0].'" target="_blank">';
    echo '<img  width="200" height="150" src="./img/'.$fl[$posizione][0].'"';
    echo "</A><BR>\n";
    echo $fl[$posizione][0];
    echo "</CENTER></TD>";
     $posizione++;
   }
  }
  echo "</TR>";
 }
echo "</table>";

?> 
