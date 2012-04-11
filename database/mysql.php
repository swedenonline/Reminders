<?php
/*
+--------------------------------------------------------------------------
|   CubeCart v3.0.10
|   ========================================
|   by Alistair Brookbanks
|	CubeCart is a Trade Mark of Devellion Limited
|   Copyright Devellion Limited 2005 - 2006. All rights reserved.
|   Devellion Limited,
|   22 Thomas Heskin Court,
|   Station Road,
|   Bishops Stortford,
|   HERTFORDSHIRE.
|   CM23 3EE
|   UNITED KINGDOM
|   http://www.devellion.com
|	UK Private Limited Company No. 5323904
|   ========================================
|   Web: http://www.cubecart.com
|   Date: Tuesday, 14th March 2006
|   Email: info (at) cubecart (dot) com
|	License Type: CubeCart is NOT Open Source Software and Limitations Apply 
|   Licence Info: http://www.cubecart.com/site/faq/license.php
+--------------------------------------------------------------------------
|	mysql.php
|   ========================================
|	MySql Class	
+--------------------------------------------------------------------------
*/

include_once("connection.php");

class MySql
{

	var $query = "";
	var $db = "";
	
	function __construct()
	{
		
		global $glob;
		
		$this->db = @mysql_connect(HOST, USERNAME, PASSWORD);	
		if (!$this->db) die ($this->debug(true));	
		
		
		
		$selectdb = @mysql_select_db(DATABASE);
		
		if (!$selectdb) die ($this->debug());
	
	} // end constructor
	
	
	function select($query, $maxRows=0, $pageNum=0)
	{
		$this->query = $query;
		
		// start limit if $maxRows is greater than 0
		if($maxRows>0)
		{
			$startRow = $pageNum * $maxRows;
			$query = sprintf("%s LIMIT %d, %d", $query, $startRow, $maxRows);
		}	
		
		$result = mysql_query($query, $this->db);
		
		if ($this->error()) die ($this->debug());
		
		$output=false;
		
		for ($n=0; $n < mysql_num_rows($result); $n++)
		{
			$row = mysql_fetch_assoc($result);
			$output[$n] = $row;
		}
	
		return $output;
		
	} // end select
	
	function misc($query) {
	
		$this->query = $query;
		$result = mysql_query($query, $this->db);
		
		if ($this->error()) die ($this->debug());
		
		if($result == TRUE){
		
			return TRUE;
			
		} else {
		
			return FALSE;
			
		}
		
	}
	
	function execute($query) {

		$this->query = $query;
		$result = mysql_query($query, $this->db);
		if($result===false){
			$errorNo = mysql_errno($this->db);
			if($errorNo == 1451 || $errorNo == 1217){
				$_SESSION['message'] = 'Unable to delete this record, this record has child records.';
			}
		}		
		return $result;
	}

	function numrows($query) {
		$this->query = $query;
		$result = mysql_query($query, $this->db);
		return mysql_num_rows($result);
	}
	
	function paginate($numRows, $maxRows, $pageNum=0, $pageVar="page", $class="blackTextBold")
	{
		global $lang;
		$navigation = "";
		
		// get total pages
		$totalPages = ceil($numRows/$maxRows);
		
		// develop query string minus page vars
		$queryString = "";
			if (!empty($_SERVER['QUERY_STRING'])) {
				$params = explode("&", $_SERVER['QUERY_STRING']);
				$newParams = array();
					foreach ($params as $param) {
						if (stristr($param, $pageVar) == false) {
							array_push($newParams, $param);
						}
					}
				if (count($newParams) != 0) {
					$queryString = "&" . htmlentities(implode("&", $newParams));
				}
			}
			
		// get current page	
		$currentPage = $_SERVER['PHP_SELF'];
		
		// build page navigation
		if($totalPages> 1){
		$navigation = $totalPages.$lang['misc']['pages']; 
		
		$upper_limit = $pageNum + 3;
		$lower_limit = $pageNum - 3;
	
		if ($pageNum > 0) { // Show if not first page
			
			if(($pageNum - 2)>0){
			$first = sprintf("%s?".$pageVar."=%d%s", $currentPage, 0, $queryString);
			$navigation .= "<a href='".$first."' class='".$class."'>&laquo;</a> ";}
			
			$prev = sprintf("%s?".$pageVar."=%d%s", $currentPage, max(0, $pageNum - 1), $queryString);
			$navigation .= "<a href='".$prev."' class='".$class."'>&lt;</a> ";
		} // Show if not first page
		
		// get in between pages
		for($i = 0; $i < $totalPages; $i++){
		
			$pageNo = $i+1;
			
			if($i==$pageNum){
				$navigation .= "&nbsp;<strong>[".$pageNo."]</strong>&nbsp;";
			} elseif($i!==$pageNum && $i<$upper_limit && $i>$lower_limit){
				$noLink = sprintf("%s?".$pageVar."=%d%s", $currentPage, $i, $queryString);
				$navigation .= "&nbsp;<a href='".$noLink."' class='".$class."'>".$pageNo."</a>&nbsp;";
			} elseif(($i - $lower_limit)==0){
				$navigation .=  "&hellip;";
			} 
		}
		  
		if (($pageNum+1) < $totalPages) { // Show if not last page
			$next = sprintf("%s?".$pageVar."=%d%s", $currentPage, min($totalPages, $pageNum + 1), $queryString);
			$navigation .= "<a href='".$next."' class='".$class."'>&gt;</a> ";
			if(($pageNum + 3)<$totalPages){
			$last = sprintf("%s?".$pageVar."=%d%s", $currentPage, $totalPages-1, $queryString);
			$navigation .= "<a href='".$last."' class='".$class."'>&raquo;</a>";}
		} // Show if not last page 
		
		} // end if total pages is greater than one
		
		return $navigation;
	
	}
	
	function insert ($tablename, $record)
	{
		if(!is_array($record)) die ($this->debug("array", "Insert", $tablename));
		
		$count = 0;
		foreach ($record as $key => $val)
		{
			if ($count==0) {$fields = "`".$key."`"; $values = $val;}
			else {$fields .= ", "."`".$key."`"; $values .= ", ".$val;}
			$count++;
		}	
		
		$query = "INSERT INTO ".$tablename." (".$fields.") VALUES (".$values.")";
		
		$this->query = $query;
		mysql_query($query, $this->db);
		
		if ($this->error()) die ($this->debug());
		
		if ($this->affected() > 0) return true; else return false;
		
	} // end insert
	
	
	function update ($tablename, $record, $where)
	{
		if(!is_array($record)) die ($this->debug("array", "Update", $tablename));
	
		$count = 0;
		
		foreach ($record as $key => $val)
		{
			if ($count==0) $set = "`".$key."`"."=".$val;
			else $set .= ", " . "`".$key."`". "= ".$val;
			$count++;
		}	
	
		$query = "UPDATE ".$tablename." SET ".$set." WHERE ".$where;
		//echo $query;
		$this->query = $query;
		mysql_query($query, $this->db);
		if ($this->error()) die ($this->debug());
		
		//if ($this->affected() > 0) return true; else return false;
		return true;
		
	} // end update
	
	
	function delete($tablename, $where, $limit="")
	{
		$query = "DELETE from ".$tablename." WHERE ".$where;
		if ($limit!="") $query .= " LIMIT " . $limit;
		$this->query = $query;
		mysql_query($query, $this->db);
		
		if ($this->error()) die ($this->debug());
	
		if ($this->affected() > 0){ 
			return TRUE; 
		} else { 
			return FALSE;
		}
	
	} // end delete
	
	//////////////////////////////////
	// Clean SQL Variables (Security Function)
	////////
	function mySQLSafe($value, $quote="'") { 
		$value = addslashes(trim($value)); 
		$value = $quote . $value . $quote; 

		return $value; 
	}
	
	
	function debug($type="", $action="", $tablename="")
	{
		switch ($type)
		{
			case "connect":
				$message = "MySQL Error Occured";
				$result = mysql_errno() . ": " . mysql_error();
				$query = "";
				$output = "Could not connect to the database. Be sure to check that your database connection settings are correct and that the MySQL server in running.";
			break;
		
		
			case "array":
				$message = $action." Error Occured";
				$result = "Could not update ".$tablename." as variable supplied must be an array.";
				$query = "";
				$output = "Sorry an error has occured accessing the database. Be sure to check that your database connection settings are correct and that the MySQL server in running.";
				
			break;
		
			
			default:
				if (mysql_errno($this->db))
				{
					$message = "MySQL Error Occured";
					$result = mysql_errno($this->db) . ": " . mysql_error($this->db);
					$output = "Sorry an error has occured accessing the database. Be sure to check that your database connection settings are correct and that the MySQL server in running.";
				}
				else 
				{
					$message = "MySQL Query Executed Succesfully.";
					$result = mysql_affected_rows($this->db) . " Rows Affected";
					$output = "view logs for details";
				}
				
				$linebreaks = array("\n", "\r");
				if($this->query != "") $query = "QUERY = " . str_replace($linebreaks, " ", $this->query); else $query = "";
			break;
		}
		
		$output = "<b style='font-family: Arial, Helvetica, sans-serif; color: #0B70CE;'>".$message."</b><br />\n<span style='font-family: Arial, Helvetica, sans-serif; color: #000000;'>".$result."</span><br />\n<p style='Courier New, Courier, mono; border: 1px dashed #666666; padding: 10px; color: #000000;'>".$query."</p>\n";
		
		return $output;
	}
	
	
	function error()
	{
		if (mysql_errno($this->db)) return true; else return false;
	}
	
	
	function insertid()
	{
		return mysql_insert_id($this->db);
	}
	
	function affected()
	{
		return mysql_affected_rows($this->db);
	}
	
	function close() // close conection
	{
		mysql_close($this->db);
	} 
	

} // end of db class
?>