<!
Meteo cam
version 1.2
29 giugno 2016
Giuseppe Augiero

Changelog:

- Add limit to viewed elements
- Add to list only selected images
- Add watermark
- Resolve sort (ASC)
!>
<CENTER>METEO</CENTER> 
<P>
<?php
$fl= array();
$ft= array();
#Dir with / at last character
$imgdir="./img/";
# Viewed image
$elementi=24;
$suffisso="webcam";
if ($handle = opendir($imgdir)) {
    while (false !== ($file = readdir($handle))) 
    { 
        if ($file != "." && $file != "..") {
            // Add to list only selected images
            if (stristr($file, $suffisso) == TRUE) { 
            $fl[] = array($file, filemtime($imgdir.$file));
        } 
        }
    }
    closedir($handle); 
}
# (nomefile, ultima modifica) 
foreach ($fl as $t) {
    $tos[] = $t[1];
}
#sort per data di modifica
array_multisort($tos, SORT_ASC, $fl);
// Load the stamp and the photo to apply the watermark to
$stamp = imagecreatefrompng('fanta.png');
$im = imagecreatefromjpeg($imgdir.$fl[0][0]);

// Set the margins for the stamp and get the height/width of the stamp image
$marge_right = 10;
$marge_bottom = 10;
$sx = imagesx($stamp);
$sy = imagesy($stamp);

// Copy the stamp image onto our photo using the margin offsets and the photo 
// width to calculate positioning of the stamp. 
imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));

// Output and free memory
echo "<CENTER>";
//header('Content-type: image/png');
// Enable output buffering
ob_start();
imagepng($im);
// Capture the output
$imagedata = ob_get_contents();
// Clear the output buffer
ob_end_clean();

print '<p><img src="data:image/png;base64,'.base64_encode($imagedata).'" /></p>';    

imagedestroy($im);
echo "</CENTER>";

//echo '<CENTER><img src="'.$imgdir.$fl[0][0].'"></CENTER>';
echo "<P>";
$posizione=0;
if ($elementi > count($fl)){
  $elementi= count($fl);
}
$colonne=4;
$righe=$elementi/$colonne;
echo '<table border="1" style="width:100%">';
for ($k = 0; $k <= $righe; $k++) {
  echo "<TR>";
  for ($i = 0; $i < $colonne; $i++) {
    if ($posizione < $elementi){
    echo "<TD><CENTER>";
    echo '<a href="./webcam/'.$fl[$posizione][0].'" target="_blank">';
    echo '<img  width="200" height="150" src="'.$imgdir.$fl[$posizione][0].'"';
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
