<?php

namespace Model;

class NoteModel extends BaseModel
{
	
	
	private static function validator($login, $email, $text)
	{
		if ($login == '' || $email == '' || $text == '')
			return FALSE;
		
		if  (!preg_match( '/^[A-Za-z0-9 ]{3,20}$/i',$login))
			return FALSE;
		
		if (!filter_var($email, FILTER_VALIDATE_EMAIL))
			return FALSE;
		
		if (empty(trim($text)))
			return FALSE;
		
		return TRUE;
	}
	
	public static function get_notes($sorting='', $page=1, $direction='DESC')
	{
		$table_name=self::tablename();
		
		if ($sorting == '')
			$ORDER="id DESC";
		else
			$ORDER="$sorting $direction,id $direction";
		
		$limit_start=($page-1)*3;
		$LIMIT="$limit_start , 3";
		
		$SELECT_NOTES_QUERY="SELECT
		*
		FROM
		$table_name
		ORDER BY $ORDER 
		LIMIT $LIMIT
		;";
		
		$res=mysqli_query(\App\Application::$DBLink,$SELECT_NOTES_QUERY);
		
		if ($res->num_rows)
		{
			$result = [];
			while($row = mysqli_fetch_assoc($res))
				$result['rows'][]=$row;
			$res_num = mysqli_query(\App\Application::$DBLink,"SELECT count(1) as cnt FROM $table_name;");
			$num_rows = mysqli_fetch_assoc($res_num);
			$result['num_rows'] = $num_rows['cnt'];
			return $result;
		}
		else
		return false;
		
	}
	
	public static function add_note($username,$email,$text)
	{
		if (!self::validator($username, $email, $text))
			return FALSE;
		
		$table_name=self::tablename();
		$ADD_QUERY="INSERT
		INTO
		$table_name
		SET
		  username='$username'
		, text='".mysqli_real_escape_string(\App\Application::$DBLink,$text)."'
		, email='$email'
		, status=0
		, is_modified=0
		;";
		if ($res=mysqli_query(\App\Application::$DBLink,$ADD_QUERY))
			return TRUE;
		else
			return FALSE;
		
	}
	
	public static function edit_note($id,$text)
	{
		$table_name=self::tablename();
		$EDIT_QUERY="UPDATE
		$table_name
		SET
		  text='".mysqli_real_escape_string(\App\Application::$DBLink,$text)."'
		, is_modified=1
		WHERE
		id=$id
		;";
		if ($res=mysqli_query(\App\Application::$DBLink,$EDIT_QUERY))
			return TRUE;
		else
			return FALSE;
	}
	
	public static function revert_status($id,$status=1)
	{
		$table_name=self::tablename();
		$STATUS_REVERT_QUERY="UPDATE
		$table_name
		SET
		status= $status
		WHERE
		id=$id
		;";
		if ($res=mysqli_query(\App\Application::$DBLink,$STATUS_REVERT_QUERY))
			return TRUE;
		else
			return FALSE;
	}
	
	
}
?>