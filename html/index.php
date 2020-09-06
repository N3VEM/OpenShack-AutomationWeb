<?php

  $strSensorDataFileContents = file_get_contents('../currentSensorData.json');
  //var_dump($strSensorDataFileContents);
  $sensorDataArray = json_decode($strSensorDataFileContents, true);
  //var_dump($sensorData);


?>

<html>
  <head>
	  <title>Shack Power Dashboard</title>
    <meta charset='UTF-8'>
    <meta http-equiv="refresh" content="3">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel='stylesheet' href="include/w3.css">
  </head>


  <body>
    <div class="w3-cell-row">

      <div class="w3-container w3-green w3-cell">
      <H4 align="center">Main Voltage</H4>
        <div class="w3-cell-row">
          <p align ="center"><?php echo number_format($sensorDataArray['mainVoltage'], 2, '.', '') ?> volts</p>
        </div>
      </div>
      <div class="w3-container w3-amber w3-cell">
      <H4 align="center">Main Current</H4>
        <div class="w3-cell-row">
          <p align ="center"><?php echo number_format($sensorDataArray['mainCurrent'], 2, '.', '') ?> amps</p>
        </div>
      </div>
      <div class="w3-container w3-orange w3-cell">
      <H4 align="center">Rig Current</H4>
        <div class="w3-cell-row">
          <p align ="center"><?php echo number_format($sensorDataArray['rigCurrent'], 2, '.', '') ?> amps</p>
        </div>
      </div>

    </div>


    <div class="w3-container w3-blue">
        <h6 align="center">N3VEM</h6>
      </div>
    
      <div class="w3-row">
        <div class="w3-green w3-container w3-quarter w3-padding-16">
            <a href="include/control/control.php?cmnd=vuon" target = 'blank' class="w3-button w3-block w3-bottombar w3-border-green w3-black">VU Meters On</a>
            <a href="include/control/control.php?cmnd=vuoff" target = 'blank' class="w3-button w3-block w3-bottombar w3-border-green w3-black">VU Meters Off</a>
        </div>
        <div class="w3-container w3-threequarter">
          
        </div>
      </div>  
    

  </body>
</html>

<?php

?>