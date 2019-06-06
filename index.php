<?php
/******** if downloading file does not exist so create one ***************/
$file00 = "downloadings.txt";
if(!is_file($file00)){
    file_put_contents($file00, '');
}
/**************** ************/
 /************ delete coding start *******/
    if (isset($_GET['delete'])) { 
     $file = 'rec/'.$_GET["delete"];
             if (!unlink($file)){       echo ("(Error deleting file<b><i>".$_GET["delete"]."</i></b>. <br> This file is already deleted)<br>");    }
                        else    {         echo ("Deleted $file".$_GET["delete"]."<br>");         }
                 } 
                 else {  } 
/* delete coding end */

$path    = '.';
$files = scandir($path);
$files = array_diff(scandir($path), array('.', '..'));
//print_r($files);
echo "<ol>"; //order list
foreach ($files as $filename) {
    $result = $filename;
    echo "<li><a href=$result>$result</a> File size = ".formatSizeUnits(filesize($result))."&emsp;&emsp;<a href=index.php?delete=$result>Click to delete</a></li>";
}


    function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
}
?>
