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

    $(document).ready(function(){
      $("#rigonbutton").click(function(){
        $.post("include/control/control.php",
        {
          cmnd: "mainrigon"
        });
      });
    });  

    $(document).ready(function(){
      $("#rigoffbutton").click(function(){
        $.post("include/control/control.php",
        {
          cmnd: "mainrigoff"
        });
      });
    });       

    $(document).ready(function(){
      $("#audioonbutton").click(function(){
        $.post("include/control/control.php",
        {
          cmnd: "audioon"
        });
      });
    });  

    $(document).ready(function(){
      $("#audiooffbutton").click(function(){
        $.post("include/control/control.php",
        {
          cmnd: "audiooff"
        });
      });
    });      

    $(document).ready(function(){
      $("#speakersonbutton").click(function(){
        $.post("include/control/control.php",
        {
          cmnd: "speakerson"
        });
      });
    });  

    $(document).ready(function(){
      $("#speakersoffbutton").click(function(){
        $.post("include/control/control.php",
        {
          cmnd: "speakersoff"
        });
      });
    });       

    $(document).ready(function(){
      $("#goodbyebutton").click(function(){
        $.post("include/control/control.php",
        {
          cmnd: "goodbye"
        });
      });
    });        

    $(document).ready(function(){
      $("#hellobutton").click(function(){
        $.post("include/control/control.php",
        {
          cmnd: "hello"
        });
      });
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


      <div class="w3-container w3-black w3-center w3-padding">
        <a href="ftdx3000.php" class="w3-button w3-medium w3-border w3-border-green w3-text-green w3-small w3-center">ftdx3000 Rig Control</a>
      </div>
    
      <div class="w3-cell-row w3-black w3-border w3-border-green">

        <div class="w3-container w3-black w3-cell w3-padding-16">
          <button class="w3-button w3-block w3-border w3-border-green w3-black w3-text-green w3-small" id="hellobutton"><b>Power Up</b></button>
          <button class="w3-button w3-block w3-border w3-border-green w3-black w3-text-green w3-small" id="lowlightsonbutton"><b>Desk Lights On</b></button>
          <button class="w3-button w3-block w3-border w3-border-green w3-black w3-text-green w3-small" id="highlightsonbutton"><b>Overhead Lights On</b></button>
          <button class="w3-button w3-block w3-border w3-border-green w3-black w3-text-green w3-small" id="rigonbutton"><b>Main Rig On</b></button>
          <button class="w3-button w3-block w3-border w3-border-green w3-black w3-text-green w3-small" id="audioonbutton"><b>Audio Equipment On</b></button>
          <button class="w3-button w3-block w3-border w3-border-green w3-black w3-text-green w3-small" id="speakersonbutton"><b>Speakers On</b></button>
          <button class="w3-button w3-block w3-border w3-border-green w3-black w3-text-green w3-small" id="vuonbutton"><b>VU Meters On</b></button>
        </div>

        <div class="w3-container w3-black w3-cell w3-padding-16">
          <button class="w3-button w3-block w3-border w3-border-green w3-black w3-text-green w3-small" id="goodbyebutton"><b>Power Down</b></button>
          <button class="w3-button w3-block w3-border w3-border-green w3-black w3-text-green w3-small" id="lowlightsoffbutton"><b>Desk Lights Off</b></button>
          <button class="w3-button w3-block w3-border w3-border-green w3-black w3-text-green w3-small" id="highlightsoffbutton"><b>Overhead Lights Off</b></button>
          <button class="w3-button w3-block w3-border w3-border-green w3-black w3-text-green w3-small" id="rigoffbutton"><b>Main Rig Off</b></button>
          <button class="w3-button w3-block w3-border w3-border-green w3-black w3-text-green w3-small" id="audiooffbutton"><b>Audio Equipment Off</b></button>    
          <button class="w3-button w3-block w3-border w3-border-green w3-black w3-text-green w3-small" id="speakersoffbutton"><b>Speakers Off</b></button>            
          <button class="w3-button w3-block w3-border w3-border-green w3-black w3-text-green w3-small" id="vuoffbutton"><b>VU Meters Off</b></button>            
        </div>

        <!-- This block was in to play with the audio stream, but I'm not sure I actually want it here...blocking out for now.
        <div class="w3-container w3-black w3-cell w3-border w3-border-green">
          <H3 class="w3-text-green" align="center"> Live Stream of all Audio from the Shack Mixer. </H3>
          <p class="w3-text-green" align="center"> this is a stream of whatever I happen to be putting out the main channels of the mixer</p>
          <p align="center"><audio controls><source src="<?php //echo "$mainmixeraudioserver";?>" type="audio/mpeg"></audio></p>
        -->  
        </div>
      
      </div>
      
    </div>  
    

  </body>
</html>

<?php

?>