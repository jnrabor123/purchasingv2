<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//required
require_once 'FDTP_Controller.php';
require_once $FDTP_Controller->route;
//end required

require_once APPPATH.'model/Pricecontrol_m.php';

class Pricecontrol 
{
	public $action;
	public $pricecontrol;
	
	public function __construct() 
	{
		$this->action = $_GET['action'];

		$this->pricecontrol = new Pricecontrol_m();		
	}
	
}


$pricecontrol = new Pricecontrol();

if($pricecontrol->action == '')
{
	echo json_encode($result);
}


