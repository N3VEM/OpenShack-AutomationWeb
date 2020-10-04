<?php
include "../../../../world.php"; //rig server connection strings liver here

$rig = $_REQUEST['rig'];
$commandReceived = $_REQUEST['cmnd'];

//echo "$rig<br>";
//echo "$commandReceived<br>";

switch($rig){
    case "main":
        $rigctlcmndline = $mainrigcontrolconnection.$commandReceived;
        //echo "$rigctlcmndline<br>";
    break;
    default:
        echo "invalid rig"; //rigs must be defined in world.php 

}

$output = shell_exec(escapeshellcmd($rigctlcmndline));

echo "$output<br>";

?>