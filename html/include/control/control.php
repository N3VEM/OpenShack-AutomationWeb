<?php

$commandReceived = $_REQUEST['cmnd'];


if ($commandReceived == 'vuoff')
{
    $output = shell_exec(vuMetersOff());
}
elseif ($commandReceived == 'vuon')
{
    $output = shell_exec(vuMetersOn());
}

#--------------functions----------------------------------------------------------
function vuMetersOff()
{
    return escapeshellcmd("python ../../../Python/shackControl.py --cmnd vuoff"); 
}

function vuMetersOn()
{
    return escapeshellcmd("python ../../../Python/shackControl.py --cmnd vuon");
    
}

?>

<script type='text/javascript'>
     self.close();
</script>