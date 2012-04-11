<?php
	/*
		@Package Name : Reminders
		@Class Name   : Reminder
		@File Name    : reminder.php
		@Version	  : V1.0	
		@Developed-by : Fateh Muhammad Bilal Baloch 
		@Description  : Reminder class provides facility to add, edit, delete and get reminders from database.
	*/
		include_once("database/mysql.php");
		include_once("helper/php/paging.php");
		
		class Reminder extends MySql
		{
			// class variables
			
			var $msg 	  		= null;
			var $tbl_name 		= "reminder";
			var $displayPaging	= NULL;	

			public function __construct()
			{
				parent::__construct();
			}

		    /**
			 * test if form information is valid
			 *
			 * @param array $formvars the form variables
			 */
			public function isValidForm($formvars) 
			{
				if(strlen(trim($formvars['remind_me'])) == 0)
				{
					$this->msg = "Please enter remind me!";
					return false;
				}
				else if(strlen(trim($formvars['title'])) == 0)
				{
					$this->msg = "Please enter title!";
					return false;
				}
				return true;
			}

			/**
			 * add a new reminder
			 *
			 * @param array $formvars the form variables
			 */
			function addReminder($formvars) 
			{
				$record['reminder_remindme']=$this->mySQLSafe( $formvars['remind_me']);
				$record['reminder_title']=$this->mySQLSafe( $formvars['title']);
		
				if($this->insert($this->tbl_name,$record) > 0 ) 
				{
					$this->msg="Reminder has been added successfully";
					return true;
				}
				else
				{
					$this->msg="Reminder was not added";
					return false;
				}
			}
			
			/*
			* load reminder from data base.
			*/
			function editEntry($id=0)
			{
				$_query = "select * from ".$this->tbl_name." where reminder_id=$id";
				$recordset=$this->execute($_query);
				while($fetch=mysql_fetch_array($recordset))
				{
					// Fill all field 
					$data["reminder_id"]=$fetch["reminder_id"];
					$data["title"]=$fetch["reminder_title"];
					$data["remind_me"]=$fetch["reminder_remindme"];
				}
				return $data;   
			}
			
			/*
			* Delete reminder from data base.
			 * @param id for delete specific record database.
			*/
			function deleteEntry($id=0)
			{
				$_query = "delete from ".$this->tbl_name." where reminder_id = ".$id;
				$recordset=$this->execute($_query);
				if($recordset) 
				{
					$this->msg="Reminder has been deleted successfully";
					return true;
				}
				else
				{
					$this->msg="Reminder was not deleteed";
					return false;
				}		
			}
			
			/**
			 * Updating reminder entry
			 *
			 * @param array $formvars the form variables
			 */
			function updateReminder($formvars) 
			{
				$record['reminder_title']=$this->mySQLSafe($formvars['title']);
				$record['reminder_remindme']=$this->mySQLSafe( $formvars['remind_me']);
				$where	=	"reminder_id=".$formvars['reminder_id'];
				$this->update($this->tbl_name,$record,$where);
				$this->msg	=	"Reminder has been updated successfully";
				return true;
			}

			/**
			 * get reminders from database
			  * @param start variables use for paging.
			 */
			function getReminders($_start=0, $formvars) 
			{
				if($formvars["filter"] == "e")
				{
					$where = " WHERE reminder_remindme < '".date("Y-m-d h:m:s")."'";
				}
				else if($formvars["filter"] == "ne")
				{
					$where = " WHERE reminder_remindme >= '".date("Y-m-d h:m:s")."'";
				}
				else
				{
					$where = "";
				}
				
				/// Paging for data tables       
				$paging = new Paginate();
				$paging->num= $this->numrows("select reminder_id from ".$this->tbl_name. $where);
				$paging->start=$_start;
				//$paging->limit = PAGESIZE;
				$paging->limit = 10;
				$paging->Paginate($paging->limit,$paging->num,"?",20);
				$this->displayPaging = $paging->displayTable();
				
				///Sort order
				$orderby="";
				
				$_query = "select reminder_title as title, reminder_remindme as remindme, reminder_id from " . $this->tbl_name . $where . $orderby ."  Limit $paging->start,$paging->limit";
				
				$recordset=mysql_query($_query);
				while($fetch=mysql_fetch_array($recordset))
				{
					$data[]=$fetch;
				}
				if(!isset($data))
				{
					$this->msg = "No existing reminder found";
					$data      = NULL;
				}
				return $data;   
			}
						
		}// end class

?>