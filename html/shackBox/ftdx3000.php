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
    var moderefreshrate = 1000;

//-------these functions are for getting data from the rig and displaying----------------------
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
        if(parseInt(data)>0){$("#vfoAfreq").html("<b>"+data+"</b>");}
      });
    }

    function fetchrigsigstrength(){
      $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "l STRENGTH"
      },
      function(data, status){
        if(!(isNaN(parseInt(data)))){$("#sigstrength").html("<b>Signal (db): "+data+"</b>");}
      });
    }

    function fetchrigcurrentvfo(){
      $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "v"
      },
      function(data, status){
        if(data.includes("VFO")){
          $("#vfolabel").html("<b>"+data+"</b>");
        }
      });
    }

    function fetchrigmode(){
      $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "m"
      },
      function(data, status){
        if(data.includes("LSB") || data.includes("USB") || data.includes("CW") || data.includes("RTTY")){
          $("#modelabel").html("<b>&nbsp;"+data+"&nbsp;</b>");
        }
      });
    }

    function fetchpttstatus(){
      $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "t"
      },
      function(data, status){
        if(data=="1"){$("#rxtx").html("<b>TX</b>");}
        else{$("#rxtx").html("<b>RX</b>");}        
      });
    }

    function fetchantenna(){
      $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "y"
      },
      function(data, status){
        $("#antenna").html("<b> Antenna: "+data+"</b>");        
      });
    }

    function fetchrfpower(){
      $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "l RFPOWER"
      },
      function(data, status){
        if(!(isNaN(parseFloat(data)))){
          $("#rfpower").html("<b> RF Power Set: "+Math.round((parseFloat(data)*255)).toString()+"</b>");
        }        
      });
    }

//-------these functions are for sending data to the rig----------------------
    $(document).ready(function(){
      $("#vfoarxbutton").click(function(){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "V RX"
      });
      });
    });

    $(document).ready(function(){
      $("#frequp10hz").click(function(){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "f"
      },
      function(data, status){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "F " + (parseInt(data) + 10).toString()
      });
      });
      });
    });

    $(document).ready(function(){
      $("#frequp100hz").click(function(){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "f"
      },
      function(data, status){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "F " + (parseInt(data) + 100).toString()
      });
      });
      });
    });

    $(document).ready(function(){
      $("#frequp1000hz").click(function(){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "f"
      },
      function(data, status){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "F " + (parseInt(data) + 1000).toString()
      });
      });
      });
    });

    $(document).ready(function(){
      $("#frequp10000hz").click(function(){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "f"
      },
      function(data, status){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "F " + (parseInt(data) + 10000).toString()
      });
      });
      });
    });

    $(document).ready(function(){
      $("#freqdown10hz").click(function(){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "f"
      },
      function(data, status){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "F " + (parseInt(data) - 10).toString()
      });
      });
      });
    });

    $(document).ready(function(){
      $("#freqdown100hz").click(function(){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "f"
      },
      function(data, status){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "F " + (parseInt(data) - 100).toString()
      });
      });
      });
    });

    $(document).ready(function(){
      $("#freqdown1000hz").click(function(){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "f"
      },
      function(data, status){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "F " + (parseInt(data) - 1000).toString()
      });
      });
      });
    });

    $(document).ready(function(){
      $("#freqdown10000hz").click(function(){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "f"
      },
      function(data, status){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "F " + (parseInt(data) - 10000).toString()
      });
      });
      });
    });

    $(document).ready(function(){
      $("#transmit").click(function(){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "T 1"
      });
      });
    });

    $(document).ready(function(){
      $("#receive").click(function(){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "T 0"
      });
      });
    });

    $(document).ready(function(){
      $("#ant1").click(function(){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "Y AN01"
      });
      });
    });

    $(document).ready(function(){
      $("#ant2").click(function(){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "Y AN02"
      });
      });
    });

    $(document).ready(function(){
      $("#ant3").click(function(){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "Y AN03"
      });
      });
    });

    $(document).ready(function(){
      $("#modelsb").click(function(){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "M LSB 0"
      });
      });
    });

    $(document).ready(function(){
      $("#modeusb").click(function(){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "M USB 0"
      });
      });
    });

    $(document).ready(function(){
      $("#modeam").click(function(){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "M AM 0"
      });
      });
    });

    $(document).ready(function(){
      $("#modecw").click(function(){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "M CW 0"
      });
      });
    });

    $(document).ready(function(){
      $("#modertty").click(function(){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "M RTTY 0"
      });
      });
    });

    $(document).ready(function(){
      $("#modediglsb").click(function(){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "M PKTLSB 0"
      });
      });
    });

    $(document).ready(function(){
      $("#modedigusb").click(function(){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "M PKTUSB 0"
      });
      });
    });

    $(document).ready(function(){
      $("#160p").click(function(){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "F 1900000"
      });
      });
    });

    $(document).ready(function(){
      $("#80d").click(function(){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "F 3580000"
      });
      });
    });

    $(document).ready(function(){
      $("#80p").click(function(){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "F 3800000"
      });
      });
    });

    $(document).ready(function(){
      $("#40d").click(function(){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "F 7070000"
      });
      });
    });

    $(document).ready(function(){
      $("#40p").click(function(){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "F 7212000"
      });
      });
    });

    $(document).ready(function(){
      $("#20d").click(function(){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "F 14070000"
      });
      });
    });

    $(document).ready(function(){
      $("#20p").click(function(){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "F 14250000"
      });
      });
    });

    $(document).ready(function(){
      $("#17d").click(function(){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "F 18097000"
      });
      });
    });

    $(document).ready(function(){
      $("#17p").click(function(){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "F 18130000"
      });
      });
    });

    $(document).ready(function(){
      $("#15d").click(function(){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "F 21070000"
      });
      });
    });

    $(document).ready(function(){
      $("#15p").click(function(){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "F 21300000"
      });
      });
    });

    $(document).ready(function(){
      $("#12d").click(function(){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "F 24920000"
      });
      });
    });

    $(document).ready(function(){
      $("#12p").click(function(){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "F 24960000"
      });
      });
    });

    $(document).ready(function(){
      $("#10d").click(function(){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "F 28120000"
      });
      });
    });

    $(document).ready(function(){
      $("#10p").click(function(){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "F 28410000"
      });
      });
    });

    $(document).ready(function(){
      $("#6m").click(function(){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "F 50125000"
      });
      });
    });

    $(document).ready(function(){
      $("#30m").click(function(){
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "F 10125000"
      });
      });
    });

    $(document).ready(function(){
      $("#pwrqrp").click(function(){
        value = (5/255)
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "L RFPOWER " + value.toString()
      });
      });
    });

    $(document).ready(function(){
      $("#pwrlow").click(function(){
        value = (25/255)
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "L RFPOWER " + value.toString()
      });
      });
    });

    $(document).ready(function(){
      $("#pwrmid").click(function(){
        value = (50/255)
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "L RFPOWER " + value.toString()
      });
      });
    });

    $(document).ready(function(){
      $("#pwrhigh").click(function(){
        value = (100/255)
        $.post(rigctlpath,
      {
        rig: "main",
        cmnd: "L RFPOWER " + value.toString()
      });
      });
    });
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

    $(document).ready(function(){
    setInterval(fetchpttstatus,sensorrefreshrate);
    }); 

    $(document).ready(function(){
    setInterval(fetchantenna,frequencyrefreshrate);
    }); 

    $(document).ready(function(){
    setInterval(fetchrfpower,sensorrefreshrate);
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
     <div class="w3-quarter">
        <div class = 'w3-half w3-padding w3-hide-medium'>
          <a href="/shackBox" class="w3-button w3-medium w3-border w3-border-green w3-small w3-center">Shack</a>
          <p>Rig Power</p>
          <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" id="rigonbutton"><b>On</b></button>
          <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" id="rigoffbutton"><b>Off</b></button>
        </div>
        <div class = 'w3-half w3-padding w3-border w3-border-green w3-hide-medium'>
          <div class = 'w3-row'>
            <p class="w3-text-green w3-small w3-left" id="mainVoltage"><b>Loading</b></p>
            <p class="w3-text-green w3-small w3-right" id="rigCurrent"><b>Loading</b></p>
          </div>
          <div class = 'w3-row'>
            <p class="w3-text-green w3-small w3-left" id="antenna"><b>Loading</b></p>
          </div>
          <div class = 'w3-row'>
            <p class="w3-text-green w3-small w3-left" id="rfpower"><b>Loading</b></p>
          </div>
        </div>

        <!--next items in left hand column go here-->

      </div>

    <!-- center section, for display stuff-->
      <div class="w3-half">
        <div class="w3-row-padding w3-border w3-border-green">
          <div class = 'w3-quarter w3-padding'>
            <div class = 'w3-row'>
              <p class="w3-text-green w3-small w3-left" id="vfolabel"><b>Loading vfo</b></p>
            </div>
            <div class = 'w3-row'>
              <p class="w3-text-green w3-small w3-left" id="modelabel"><b>&nbsp;Loading mode&nbsp;</b></p>
            </div>
          </div>
          <div class = 'w3-half w3-padding'>
            <p class="w3-text-green w3-xxlarge w3-wide w3-center" id="vfoAfreq"><b>Loading freq</b></p>
          </div>
          <div class = 'w3-quarter w3-padding'>
          <p class="w3-text-green w3-small w3-left" id="sigstrength"><b>Loading sig</b></p>
          </div>
        </div>

        <div class="w3-row-padding w3-center">
        <p>Frequency Control</p>
        <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" id="frequp10hz"><b>+ 10hz</b></button>
        <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" id="frequp100hz"><b>+ 100hz</b></button>
        <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" id="frequp1000hz"><b>+ 1,000hz</b></button>
        <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" id="frequp10000hz"><b>+ 10,000hz</b></button>
        <br><br>
        <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" id="freqdown10hz"><b>- 10hz</b></button>
        <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" id="freqdown100hz"><b>- 100hz</b></button>
        <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" id="freqdown1000hz"><b>- 1,000hz</b></button>
        <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" id="freqdown10000hz"><b>- 10,000hz</b></button>
        </div>   
        
        <div class="w3-row-padding w3-center">
        <p>Mode Selection</p>
        <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" id="modelsb"><b>LSB</b></button>
        <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" id="modeusb"><b>USB</b></button>
        <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" id="modeam"><b>AM</b></button>
        <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" id="modecw"><b>CW</b></button>
        <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" id="modertty"><b>RTTY</b></button>
        <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" id="modediglsb"><b>Digital LSB</b></button>
        <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" id="modedigusb"><b>Digital USB</b></button>
        <br>
        </div>

        <div class="w3-row-padding w3-center">
            <br><br><br>
           <button class="w3-half w3-button w3-medium w3-border w3-border-green w3-small w3-center" id="transmit"><br><H4>Transmit</H4><br></button>
           <button class="w3-half w3-button w3-medium w3-border w3-border-green w3-small w3-center" id="receive"><br><H4>Receive</H4><br></button>
        </div>

      </div>

    <!-- the rest for buttons and knobs and stuff-->
      <div class="w3-quarter">
        <div class = 'w3-half w3-padding'>
          <p>VFO A</p>
          <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" id="vfoarxbutton"><b>RX</b></button>
          <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" id="vfoatxbutton"><b>TX</b></button>
        </div>
        <div class = 'w3-half w3-padding'>
          <p>VFO B</p>
          <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" id="vfobrxbutton"><b>RX</b></button>
          <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" id="vfobtxbutton"><b>TX</b></button>
        </div>

        <div class = 'w3-row w3-center'>
          <br>
          <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" id="ant1"><b>ANT 1</b></button>
          <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" id="ant2"><b>ANT 2</b></button>
          <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" id="ant3"><b>ANT 3</b></button>
        </div>
        <div class = 'w3-row w3-center'>
          <H4>Band Select</H4>
        </div>
        <div class = 'w3-row w3-center'>
          <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" style="width:20%" id="tbd"><b>tbd</b></button>
          <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" style="width:20%" id="160p"><b>160p</b></button>
          <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" style="width:20%" id="80d"><b>80d</b></button>
          <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" style="width:20%" id="80p"><b>80p</b></button>
        </div>
        <div class = 'w3-row w3-center'>
          <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" style="width:20%" id="40d"><b>40d</b></button>
          <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" style="width:20%" id="40p"><b>40p</b></button>
          <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" style="width:20%" id="20d"><b>20d</b></button>
          <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" style="width:20%" id="20p"><b>20p</b></button>
        </div>
        <div class = 'w3-row w3-center'>
          <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" style="width:20%" id="17d"><b>17d</b></button>
          <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" style="width:20%" id="17p"><b>17p</b></button>
          <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" style="width:20%" id="15d"><b>15d</b></button>
          <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" style="width:20%" id="15p"><b>15p</b></button>
        </div>
        <div class = 'w3-row w3-center'>
          <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" style="width:20%" id="12d"><b>12d</b></button>
          <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" style="width:20%" id="12p"><b>12p</b></button>
          <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" style="width:20%" id="10d"><b>10d</b></button>
          <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" style="width:20%" id="10p"><b>10p</b></button>
        </div>
        <div class = 'w3-row w3-center'>
          <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" style="width:20%" id="6m"><b>6m</b></button>
          <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" style="width:20%" id="30m"><b>30m</b></button>
          <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" style="width:20%" id="tbd1"><b>tbd</b></button>
          <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" style="width:20%" id="tbd2"><b>tbd</b></button>
        </div>
        <div class = 'w3-row w3-center'>
          <H4>Power Settings</H4>
        </div>
        <div class = 'w3-row w3-center'>
          <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" style="width:20%" id="pwrqrp"><b>QRP</b></button>
          <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" style="width:20%" id="pwrlow"><b>Low</b></button>
          <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" style="width:20%" id="pwrmid"><b>Mid</b></button>
          <button class="w3-button w3-medium w3-border w3-border-green w3-small w3-center" style="width:20%" id="pwrhigh"><b>High</b></button>
        </div>

      </div>
    </div>

  </body>
</html>

<?php

?>