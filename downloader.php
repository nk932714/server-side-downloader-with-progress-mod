<?php 
/******** if downloading file does not exist so create one ***************/
$file00 = "downloadings.txt";
if(!is_file($file00)){
    file_put_contents($file00, '');
}

$file_name  =  $_POST["down_name"];
$input_data_for_downloadings = '<li>'.$file_name.'</li>';
$old = file_get_contents("downloadings.txt");

if (strpos($old, $file_name) == false) { 
$full_list = $old.$input_data_for_downloadings;
file_put_contents( "downloadings.txt", $full_list );

/*************** above to avoid duplicate request again and again *********************************/
//require_once('downloader.php');
//if (!isset($_POST['submit'])) { die("something went wrong"); }
$down_link  = $_POST["down_link"];
$down_ip    = $_POST["down_ip"];
$file_name  =  $_POST["down_name"];
$file_name_progress = $file_name.'.txt';
echo $file_name_progress;

file_put_contents( $file_name_progress, '' );
if(is_file($file_name_progress)){ unlink($file_name_progress); }
if(is_file($file_name)){ unlink($file_name); }

$targetFile = fopen( $file_name, 'w' );
$ch = curl_init( $down_link );
curl_setopt( $ch, CURLOPT_PROGRESSFUNCTION, 'progressCallback');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt( $ch, CURLOPT_NOPROGRESS, false );

$headers = array(); 
$headers[] = "X-Forwarded-For: ".$down_ip; 
curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );

curl_setopt( $ch, CURLOPT_FILE, $targetFile );
curl_exec( $ch );
fclose( $targetFile );
function progressCallback ($resource, $download_size, $downloaded_size, $upload_size, $uploaded_size)
{
    global $file_name_progress;
    static $previousProgress = 0;
    if ( $download_size == 0 )
        $progress = 0;
    else
        $progress = round( $downloaded_size * 100 / $download_size );
    
    if ( $progress > $previousProgress)
    {
        $previousProgress = $progress;
        $fp = fopen( $file_name_progress, 'a' );
        fputs( $fp, "$progress\n" );
        fclose( $fp );
    }
}

echo '<a href="'.$file_name_progress.'">Click to get progress</a>';

}

else echo "This file is already downloading or in the queue.";
    
?>
