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

    $(document).ready(function(){
      $("#lowlightsonbutton").click(function(){
        $.post("include/control/control.php",
        {
          cmnd: "desklighton"
        });
      });
    });     

    $(document).ready(function(){
      $("#lowlightsoffbutton").click(function(){
        $.post("include/control/control.php",
        {
          cmnd: "desklightoff"
        });
      });
    });

    $(document).ready(function(){
      $("#highlightsonbutton").click(function(){
        $.post("include/control/control.php",
        {
          cmnd: "tasklighton"
        });
      });
    });        

    $(document).ready(function(){
      $("#highlightsoffbutton").click(function(){
        $.post("include/control/control.php",
        {
          cmnd: "tasklightoff"
        });
      });
    });    

    $(document).ready(function(){
      $("#vuonbutton").click(function(){
        $.post("include/control/control.php",
        {
          cmnd: "vuon"
        });
      });
    });  

    $(document).ready(function(){
      $("#vuoffbutton").click(function(){
        $.post("include/control/control.php",
        {
          cmnd: "vuoff"
        });
      });
    });        


    </script>
 

  </head>
  

<body>


  <body class="w3-black">
    <div class="w3-cell-row w3-black">

      <div class="w3-container w3-black w3-border w3-border-green w3-cell">
      <H5 class="w3-text-green" align="center"><b>MAIN VOLTAGE</b></H5>
        <div class="w3-cell-row">
          <p class="w3-text-green" align ="center" id="mainVoltage"><b>Loading</b></p>
        </div>
      </div>
      <div class="w3-container w3-black w3-border w3-border-green w3-cell">
      <H5 class="w3-text-green" align="center"><b>MAIN CURRENT</b></H5>
        <div class="w3-cell-row">
        <p class="w3-text-green" align ="center" id="mainCurrent"><b>Loading</b></p>
        </div>
      </div>
      <div class="w3-container w3-black w3-border w3-border-green w3-cell">
      <H5 class="w3-text-green" align="center"><b>RIG CURRENT</b></H5>
        <div class="w3-cell-row">
        <p class="w3-text-green" align ="center" id="rigCurrent"><b>Loading</b></p>
        </div>
      </div>

    </div>


      <div class="w3-container w3-black">
        <h6 class="w3-text-green" align="center"><b>N3VEM</b></h6>
      </div>
    
      <div class="w3-cell-row w3-black">

        <div class="w3-container w3-black w3-cell w3-border w3-border-green w3-padding-16" style="width:25%">
          <button class="w3-button w3-block w3-border w3-border-green w3-black w3-text-green" id="lowlightsonbutton"><b>Desk Lights On</b></button>
          <button class="w3-button w3-block w3-border w3-border-green w3-black w3-text-green" id="lowlightsoffbutton"><b>Desk Lights Off</b></button>
          <button class="w3-button w3-block w3-border w3-border-green w3-black w3-text-green" id="highlightsonbutton"><b>Overhead Lights On</b></button>
          <button class="w3-button w3-block w3-border w3-border-green w3-black w3-text-green" id="highlightsoffbutton"><b>Overhead Lights Off</b></button>
          <button class="w3-button w3-block w3-border w3-border-green w3-black w3-text-green" id="vuonbutton"><b>VU Meters On</b></button>
          <button class="w3-button w3-block w3-border w3-border-green w3-black w3-text-green" id="vuoffbutton"><b>VU Meters Off</b></button>            
        </div>
        <div class="w3-container w3-black w3-cell w3-border w3-border-green">
        <p class="w3-text-green" align="center"> Welcome to the N3VEM Hamshack. this is a work in progress where I play around with stuff. </p>
        </div>
      
      </div>
      
    </div>  
    

  </body>
</html>

<?php

?>