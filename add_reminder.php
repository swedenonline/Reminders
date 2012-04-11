<?php
	/*
		@Package Name : Reminders
		@File Name    : add_reminder.php
		@Version	  : V1.0	
		@Developed-by : Fateh Muhammad Bilal Baloch 
		@Description  : add_reminder controller is responsible to take user request from view template (add_reminder_tpl) and gets response from Reminder model and sends back to 			
						template
	*/
	include_once("model/reminder.php");
	$obj_reminder = new Reminder();

	$class 		= "error";
	$msg   		= "";
	$formvars 	= array("remind_me" => "", "title" => "", "submit" => "");
	
	if($_POST['submit'] != NULL && $_POST['submit'] == "add")
	{
		if($obj_reminder->isValidForm($_POST))
		{
			if($obj_reminder->addReminder($_POST))
			{
				$class = "success";
				$_POST = NULL;
			}	
		}
		$formvars = $_POST;
		$msg = $obj_reminder->msg;
	}
	include_once("view/add_reminder_tpl.php");
?>