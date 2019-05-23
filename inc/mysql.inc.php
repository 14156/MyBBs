<?php

//connect database
function connect($host=DB_HOST,$user=DB_USER,$password=DB_PASSWORD,$database=DB_DATABASE,$port=DB_PORT){
	$link=@mysqli_connect($host,$user,$password,$database,$port);
	//@ shiield error

	if(mysqli_connect_errno()){
		exit(mysqli-connect-error());
	};
	mysqli_set_charset($link, 'utf8');
	return $link;
}

//execute sql statement, return result set obj or boolean value
function execute($link, $query){
	$result=mysqli_query($link,$query);

	if(mysqli_errno($link)){
		exit(mysqli_error($link));
	}
	return $result;
}

//excute sql statement, only return boolean value
function execute_bool($link,$query){
	$bool=mysqli_real_query($link, $query);
	if(mysqli_errno($link)){
		exit(mysqli_error($link));
	}
	return $bool;
}

//excute multiple sql statement
/*
$arr_sqls: Array form of multiple SQL statement 
$error: store the error message of statement
*/

function execute_multi($link, $arr_sqls,&$error){
	$sqls=implode(';',$arr_sqls).';';
	if(mysqli_multi_query($link, $sqls)){
		$data=array();
		$i = 0;//count
		do{
			if($result=mysqli_store_result($link)){
				$data[$i]=mysqli_fetch_all($result);
				mysqli_free_result($result);
			}else{
				$data[$i]=null;
			}
			$i++;
			if(!mysqli_more_results($link))	break;
		}while (mysqli_next_result($link));
			if($i==count($arr_sqls)){
			return $data;
		}else{
			$error="SQL statement execute error:<br/>&nbsp; index{$i} with statement {$arr_sqls[$i]} execution error <br/>&nbsp ".mysqli_error($link);
			return false;
		}
	}else{
		$error='Execution error. Please check first statement. <br/> Possible failure reason:'.mysqli_error($link);
		return false;
	}
}


// obtain records number

function num($link, $sql_count){
	$result=execute($link, $sql_count);
	$count=mysqli_fetch_row($result);
	return $count[0];

}

//Translation before data is stored
function escape($link, $data){
	if(is_string($data)){
		return mysqli_real_escape_string($link, $data);
	}
	if(is_array($data)){
		foreach ($data as $key=>$val){
			$data[$key]=mysqli_real_escape_string($link,$val);
		}
	}
	return $data;
}


//shut down the connection with database

function close($link){
	mysqli_close($link);
}
?>