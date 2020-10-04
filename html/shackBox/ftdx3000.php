<?php

  include "../../world.php";

  $strSensorDataFileContents = file_get_contents('../../currentSensorData.json');
  //var_dump($strSensorDataFileContents);
  $sensorDataArray = json_decode($strSensorDataFileContents, true);
  //var_dump($sensorData);


?>

<html>
  <head>
	  <title>ftdx3000</title>
    <meta charset='UTF-8'>
    <!--<meta http-equiv="refresh" content="3">-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel='stylesheet' href="include/w3.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>

    var rigctlpath = "include/control/rigctl.php";
    var sensorrefreshrate = 500;
    var frequencyrefreshrate = 1000;
    var signalstrengthrefreshrate = 500;
    var vforefreshrate = 5000;
    var moderefreshrate = 5000;

//-------these functions are for getting data from the rig----------------------
    function fetchmainvoltssensordata(){
      $.post("sendsensordata.php",
      {
        request: "mainvolts"
      },
      function(data, status){
        $("#mainVoltage").html("<b>"+data+" V</b>");
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

    function fetchrigfrequency(){
      $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "f"
      },
      function(data, status){
        $("#vfoAfreq").html("<b>"+data+"</b>");
      });
    }

    function fetchrigsigstrength(){
      $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "l STRENGTH"
      },
      function(data, status){
        $("#sigstrength").html("<b>"+data+"</b>");
      });
    }

    function fetchrigcurrentvfo(){
      $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "v"
      },
      function(data, status){
        $("#vfolabel").html("<b>"+data+"</b>");
      });
    }
    function fetchrigmode(){
      $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "m"
      },
      function(data, status){
        $("#modelabel").html("<b>&nbsp;"+data+"&nbsp;</b>");
      });
    }

//-------these functions are for sending data to the rig----------------------
// none written yet

//-------these functions are for refreshing info displayed about the rig ----------------------
    $(document).ready(function(){
    setInterval(fetchmainvoltssensordata,sensorrefreshrate);
    }); 

    $(document).ready(function(){
    setInterval(fetchrigcurrentsensordata,sensorrefreshrate);
    }); 

    $(document).ready(function(){
    setInterval(fetchrigfrequency,frequencyrefreshrate);
    });   

    $(document).ready(function(){
    setInterval(fetchrigsigstrength,signalstrengthrefreshrate);
    });    

    $(document).ready(function(){
    setInterval(fetchrigcurrentvfo,signalstrengthrefreshrate);
    }); 
    $(document).ready(function(){
    setInterval(fetchrigmode,moderefreshrate);
    });    

//-------these functions are for interacting with serial data/other shack control items----------------------
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
    
    </script>
 

  </head>
  

  <body class="w3-black w3-padding-small w3-text-green">
    <!--left hand column stuff-->
    <div class="w3-row-padding">
      <div class="w3-quarter w3-padding">
        <div class = 'w3-half w3-padding'>
          <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-left" id="rigonbutton"><b>On</b></button>
          <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-left" id="rigoffbutton"><b>Off</b></button>
        </div>
        <div class = 'w3-half w3-padding w3-border w3-border-green w3-hide-medium'>
          <p class="w3-text-green w3-small w3-left" id="mainVoltage"><b>Loading</b></p>
          <p class="w3-text-green w3-small w3-right" id="rigCurrent"><b>Loading</b></p>
        </div>

        <!--next items in left hand column go here-->

      </div>

    <!-- center section, for display stuff-->
      <div class="w3-half w3-border w3-border-green">
        <div class = 'w3-threequarter w3-padding'>
          <p class="w3-text-green w3-small w3-left" id="vfolabel"><b>Loading</b></p>
          <p class="w3-text-green w3-small w3-left" id="modelabel"><b>&nbsp;mode&nbsp;</b></p>
          <p class="w3-text-green w3-xlarge w3-wide w3-center" id="vfoAfreq"><b>Loading</b></p>
        </div>
        <div class = 'w3-quarter w3-padding'>
        <p class="w3-text-green w3-small w3-left" id="sigstrengthlabel"><b>Signal Strength (db)</b></p>
        <p class="w3-text-green w3-small w3-center" id="sigstrength"><b>Loading</b></p>
        </div>
      </div>

    <!-- the rest for buttons and knobs and stuff-->
      <div class="w3-quarter w3-padding w3-border w3-border-green">
        <p>buttons and stuff</p>
      </div>
    </div>

  </body>
</html>

<?php

?>