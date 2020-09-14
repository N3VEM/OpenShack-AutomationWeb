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

function hello()
{
    return escapeshellcmd("python ../../../Python/shackControl.py --cmnd hello");
    
}

function goodbye()
{
    return escapeshellcmd("python ../../../Python/shackControl.py --cmnd goodbye");
    
}

?>
