<?php
/*returns array('limit','html')
$count: total #pages needed $page_size: how many posts show on one page, 
$num_btn: how many page button shows, $page:url parameter for $_GET
*/
function page($count,$page_size,$num_btn=10,$page='page'){
	if($count==0){//if no post exist in section, return empty array
		$data=array(
		'limit'=>'',
		'html'=>''
	);
	return $data;
	}
	if(!isset($_GET[$page]) || !is_numeric($_GET[$page]) || $_GET[$page]<1){
		$_GET[$page]=1;
	}
	$page_num_all=ceil($count/$page_size);//total page
	if($_GET[$page]>$page_num_all){
		$_GET[$page]=$page_num_all;
	}
	$start=($_GET[$page]-1)*$page_size;
	$limit="limit {$start},{$page_size}";
	// echo 'Curret:'.$_GET[$page].'<br/>';

	$current_url=$_SERVER['REQUEST_URI'];//get current url
	$arr_current=parse_url($current_url);//split url into array
	$current_path=$arr_current['path'];//save file path
	 //var_dump($arr_current);
	 $url='';
	 if(isset($arr_current['query'])){
	 	parse_str($arr_current['query'],$arr_query);
	 	unset($arr_query[$page]);
	 	//var_dump($arr_query);
	 	if(empty($arr_query)){
	 		$url="{$current_path}?{$page}=";
	 	}else{
	 		$other=http_build_query($arr_query);
	 		$url="{$current_path}?{$other}&{$page}=";
	 		//var_dump($url);
	 	}
	 }else{
	 	$url="{$current_path}?{$page}=";
	 }



	$html=array();
	if($num_btn>=$page_num_all){
		for ($i=1;$i<=$page_num_all;$i++){ //$i used to limit the cycle numbers and also be the page number.
			if($_GET[$page]==$i){
				$html[$i]="<span>{$i}</span>";
			}else{
				$html[$i]="<a href='{$url}{$i}'>{$i}</a>";
			}
		
		}
	}else{
		$num_left=floor(($num_btn-1)/2);
		$start=$_GET[$page]-$num_left;
		$end=$start+($num_btn-1);
		if($start<1){
			$start=1;
		}
		if($end>$page_num_all){
			$start=$page_num_all-($num_btn-1);
		}
		for($i=0;$i<$num_btn;$i++){
			if($_GET[$page]==$start){
				$html[$start]="<span>{$start}</span>";
			}else{
				$html[$start]="<a href='{$url}{$start}'>{$start}</a>";	
			}
			$start++;
		}
		//when btn number>=3, ellipsis effect...
		if(count($html)>=3){
			reset($html);
			$key_first=key($html);
			end($html);
			$key_end=key($html);
			// echo $key_first.' '.$key_end;
			if($key_first!=1){
				//unset($html)[$key_first]);
				array_shift($html);
				array_unshift($html,"<a href='{$url}=1'>1...</a>");
			}

			if($key_end!=$page_num_all){
				array_pop($html);
				array_push($html,"<a href='{$url}={$page_num_all}'>...{$page_num_all}</a>");
			}
		}
		
	}
	if($_GET[$page]!=1){
		$prev=$_GET[$page]-1;
		array_unshift($html, "<a href='{$url}{$prev}'> « Previous</a>");
	}
	if($_GET[$page]!=$page_num_all){
		$next=$_GET[$page]+1;
		array_push($html,"<a href='{$url}{$next}'>Next »</a>");
	}
	$html=implode(' ',$html);
	$data=array(
		'limit'=>$limit,
		'html'=>$html
	);
	return $data;
}

//$page=page(100,10,5);
//echo $page['html'];
?>