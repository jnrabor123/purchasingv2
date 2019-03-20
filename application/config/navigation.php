<?php 

function check_session()
{
    if(!isset($_SESSION['purchasing_id']))
        header('Location: http://10.164.30.173/purchasingv2/'); 
}

?>