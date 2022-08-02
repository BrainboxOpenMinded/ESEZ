<?
$days = 1;
$dir = dirname ( __FILE__ ). '/codes';
 
$nofiles = 0;
 
    if ($handle = opendir($dir)) {
    while (( $file = readdir($handle)) !== false ) {
        if ( $file == '.' || $file == '..' || is_dir($dir.'/'.$file) ) {
            continue;
        }
 
        if ((time() - filemtime($dir.'/'.$file)) > ($days *14)) {
            $nofiles++;
            unlink($dir.'/'.$file);
        }
    }
    closedir($handle);
    echo "Usuniętych kodów: $nofiles \n";
}
?>