<?php
	/*
		@Package Name : Reminders
		@File Name    : reminder.php
		@Version	  : V1.0	
		@Developed-by : Fateh Muhammad Bilal Baloch 
		@Description  : reminder controller communicates with Reminder model and reminder_tpl template.
	*/
	include_once("model/reminder.php");
	$obj_reminder = new Reminder();

	$class 		= "error";
	$msg   		= "";
	
	// set the current page value 
	$_start 	= isset($_REQUEST['start']) ? $_REQUEST['start'] : '0';

	if(isset($_GET['del']) && $_GET['del'] != "")
		if($obj_reminder->deleteEntry($_GET['del']))
		{
			$class = "success";
		}

	$record = $obj_reminder->getReminders($_start , $_GET);
	$msg = $obj_reminder->msg;	
		
	include_once("view/reminder_tpl.php");
?>


