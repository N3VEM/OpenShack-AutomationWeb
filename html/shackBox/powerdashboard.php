<?php

  include "../../world.php";

  $strSensorDataFileContents = file_get_contents('../../currentSensorData.json');
  //var_dump($strSensorDataFileContents);
  $sensorDataArray = json_decode($strSensorDataFileContents, true);
  //var_dump($sensorData);


?>

<html>
  <head>
	  <title>Shack Power Dashboard</title>
    <meta charset='UTF-8'>
    <!--<meta http-equiv="refresh" content="3">-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel='stylesheet' href="include/w3.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>

    var sensorrefreshrate = 500;

    function fetchmainvoltssensordata(){
      $.post("sendsensordata.php",
      {
        request: "mainvolts"
      },
      function(data, status){
        $("#mainVoltage").html("<b>"+data+" V</b>");
      });
    }

    function fetchmaincurrentsensordata(){
      $.post("sendsensordata.php",
      {
        request: "maincurrent"
      },
      function(data, status){
        $("#mainCurrent").html("<b>"+data+" A</b>");
      });
    }

    function fetchrigcurrentsensordata(){
      $.post("sendsensordata.php",
      {
        request: "rigcurrent"
      },
      function(data, status){
        $("#rigCurrent").html("<b>"+data+" A</b>");
      });
    }

    $(document).ready(function(){
    setInterval(fetchmainvoltssensordata,sensorrefreshrate);
    }); 

    $(document).ready(function(){
    setInterval(fetchmaincurrentsensordata,sensorrefreshrate);
    }); 

    $(document).ready(function(){
    setInterval(fetchrigcurrentsensordata,sensorrefreshrate);
    });    
    
    </script>
 

  </head>
  

<body>


  <body class="w3-black w3-padding-16">
    <div class="w3-cell-row w3-black">

      <div class="w3-container w3-black w3-border w3-border-green w3-cell">
        <H6 class="w3-text-green" align="center"><b>MAIN VOLTAGE</b></H6>
        <p class="w3-text-green w3-small" align ="center" id="mainVoltage"><b>Loading</b></p>
      </div>
      <div class="w3-container w3-black w3-border w3-border-green w3-cell">
        <H6 class="w3-text-green" align="center"><b>MAIN CURRENT</b></H6>
        <p class="w3-text-green w3-small" align ="center" id="mainCurrent"><b>Loading</b></p>
      </div>
      <div class="w3-container w3-black w3-border w3-border-green w3-cell">
        <H6 class="w3-text-green" align="center"><b>RIG CURRENT</b></H6>
        <p class="w3-text-green w3-small" align ="center" id="rigCurrent"><b>Loading</b></p>
      </div>

    </div>
  </body>
</html>

<?php

?>