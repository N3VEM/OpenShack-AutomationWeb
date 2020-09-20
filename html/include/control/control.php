<?php

$commandReceived = $_REQUEST['cmnd'];
echo "$commandReceived<br>";

if ($commandReceived == 'vuoff')
{
    $output = shell_exec(vuMetersOff());
}
elseif ($commandReceived == 'vuon')
{
    $output = shell_exec(vuMetersOn());
}
elseif ($commandReceived == 'desklighton')
{
    $output = shell_exec(deskLightsOn());
}
elseif ($commandReceived == 'desklightoff')
{
    $output = shell_exec(deskLightsOff());
}
elseif ($commandReceived == 'tasklighton')
{
    $output = shell_exec(taskLightsOn());
}
elseif ($commandReceived == 'tasklightoff')
{
    $output = shell_exec(taskLightsOff());
}
elseif ($commandReceived == 'mainrigon')
{
    $output = shell_exec(mainRigOn());
}
elseif ($commandReceived == 'mainrigoff')
{
    $output = shell_exec(mainRigOff());
}
elseif ($commandReceived == 'audioon')
{
    $output = shell_exec(audioEquipOn());
}
elseif ($commandReceived == 'audiooff')
{
    $output = shell_exec(audioEquipOff());
}
elseif ($commandReceived == 'speakerson')
{
    $output = shell_exec(speakersOn());
}
elseif ($commandReceived == 'speakersoff')
{
    $output = shell_exec(speakersOff());
}
elseif ($commandReceived == 'hello')
{
    $output = shell_exec(hello());
}
elseif ($commandReceived == 'goodbye')
{
    $output = shell_exec(goodbye());
}
var_dump($output);

#--------------functions----------------------------------------------------------
function vuMetersOff()
{
    return escapeshellcmd("python ../../../Python/shackControl.py --cmnd vuoff"); 
}

function vuMetersOn()
{
    return escapeshellcmd("python ../../../Python/shackControl.py --cmnd vuon");
    
}

function deskLightsOn()
{
    return escapeshellcmd("python ../../../Python/shackControl.py --cmnd desklighton");
    
}

function deskLightsOff()
{
    return escapeshellcmd("python ../../../Python/shackControl.py --cmnd desklightoff");
    
}

function taskLightsOn()
{
    return escapeshellcmd("python ../../../Python/shackControl.py --cmnd tasklighton");
    
}

function taskLightsOff()
{
    return escapeshellcmd("python ../../../Python/shackControl.py --cmnd tasklightoff");
    
}

function mainRigOn()
{
    return escapeshellcmd("python ../../../Python/shackControl.py --cmnd mainrigon");
    
}

function mainRigOff()
{
    return escapeshellcmd("python ../../../Python/shackControl.py --cmnd mainrigoff");
    
}

function audioEquipOn()
{
    //speakers should be off when powering audio on, to prevent a "thump" from coming out, so always make sure they're off when powering on
    $audiocheck = escapeshellcmd("python ../../../Python/shackControl.py --cmnd speakersoff");
    return escapeshellcmd("python ../../../Python/shackControl.py --cmnd audioon");
    
}

function audioEquipOff()
{
    //if powering off audio, speakers won't work anyway, so power them off first to prevent any audible noise during shutdown
    $audiocheck = escapeshellcmd("python ../../../Python/shackControl.py --cmnd speakersoff");
    sleep(2);
    return escapeshellcmd("python ../../../Python/shackControl.py --cmnd audiooff");
    
}

function speakersOn()
{
    //note as wired, audio equip needs to be on for speakers to turn on, so turn that on, give a sec, then issue the speaker command
    $audiocheck = escapeshellcmd("python ../../../Python/shackControl.py --cmnd audioon");
    sleep(2);
    return escapeshellcmd("python ../../../Python/shackControl.py --cmnd speakerson");
    
}

function speakersOff()
{
    return escapeshellcmd("python ../../../Python/shackControl.py --cmnd speakersoff");
    
}

function hello()
{
    return escapeshellcmd("python ../../../Python/shackControl.py --cmnd hello");
    
}

function goodbye()
{
    return escapeshellcmd("python ../../../Python/shackControl.py --cmnd goodbye");
    
}

?>
