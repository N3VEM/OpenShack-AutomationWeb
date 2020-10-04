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
          <button class="w3-button w3-block w3-border w3-border-green w3-black w3-text-green" id="hellobutton"><b>Power Up</b></button>
          <button class="w3-button w3-block w3-border w3-border-green w3-black w3-text-green" id="goodbyebutton"><b>Power Down</b></button>
          <button class="w3-button w3-block w3-border w3-border-green w3-black w3-text-green" id="lowlightsonbutton"><b>Desk Lights On</b></button>
          <button class="w3-button w3-block w3-border w3-border-green w3-black w3-text-green" id="lowlightsoffbutton"><b>Desk Lights Off</b></button>
          <button class="w3-button w3-block w3-border w3-border-green w3-black w3-text-green" id="highlightsonbutton"><b>Overhead Lights On</b></button>
          <button class="w3-button w3-block w3-border w3-border-green w3-black w3-text-green" id="highlightsoffbutton"><b>Overhead Lights Off</b></button>
          <button class="w3-button w3-block w3-border w3-border-green w3-black w3-text-green" id="rigonbutton"><b>Main Rig On</b></button>
          <button class="w3-button w3-block w3-border w3-border-green w3-black w3-text-green" id="rigoffbutton"><b>Main Rig Off</b></button>
          <button class="w3-button w3-block w3-border w3-border-green w3-black w3-text-green" id="audioonbutton"><b>Audio Equipment On</b></button>
          <button class="w3-button w3-block w3-border w3-border-green w3-black w3-text-green" id="audiooffbutton"><b>Audio Equipment Off</b></button>    
          <button class="w3-button w3-block w3-border w3-border-green w3-black w3-text-green" id="speakersonbutton"><b>Speakers On</b></button>
          <button class="w3-button w3-block w3-border w3-border-green w3-black w3-text-green" id="speakersoffbutton"><b>Speakers Off</b></button>            
          <button class="w3-button w3-block w3-border w3-border-green w3-black w3-text-green" id="vuonbutton"><b>VU Meters On</b></button>
          <button class="w3-button w3-block w3-border w3-border-green w3-black w3-text-green" id="vuoffbutton"><b>VU Meters Off</b></button>            
        </div>
        <div class="w3-container w3-black w3-cell w3-border w3-border-green">
          <H3 class="w3-text-green" align="center"> Live Stream of all Audio from the Shack Mixer. </H3>
          <p class="w3-text-green" align="center"> this is a stream of whatever I happen to be putting out the main channels of the mixer</p>
          <p align="center"><audio controls><source src="<?php echo "$mainmixeraudioserver";?>" type="audio/mpeg"></audio></p>
          
        </div>
      
      </div>
      
    </div>  
    

  </body>
</html>

<?php

?>