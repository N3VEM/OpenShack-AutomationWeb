<?php
$strSensorDataFileContents = file_get_contents('../../currentSensorData.json');
//var_dump($strSensorDataFileContents);
$sensorDataArray = json_decode($strSensorDataFileContents, true);
//var_dump($sensorData);


$requestReceived = $_REQUEST['request'];
//echo "$commandReceived<br>";

if ($requestReceived == 'mainvolts')
{
    echo number_format($sensorDataArray['mainVoltage'], 2, '.', '');
}
elseif($requestReceived == 'maincurrent')
{
    echo number_format($sensorDataArray['mainCurrent'], 2, '.', '');
}
elseif($requestReceived == 'rigcurrent')
{
    echo number_format($sensorDataArray['rigCurrent'], 2, '.', '');
}
elseif($requestReceived == 'boxtemp')
{
    echo number_format($sensorDataArray['boxTemp'], 2, '.', '');
}
else
{
    echo 'Inv';
}


?>
