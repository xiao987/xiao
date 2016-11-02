<?php
$string= "hello,res,fen";
//-----------------字符串转化为数组||数组转字符串
$explode = explode(",",$string);
$luck = implode(",",$explode);
// print_r($qwe);
// var_dump($luck);
//-----------------存session
session_start();
// $_SESSION['session']=$luck;
// $ses = $_SESSION['session'];
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------数组函数----------------------------------------------------------------------
//--------------------(1)数组合并，第一个数组为下标，第二个数组为值(array_combine)。
$arr = array('hello','work','woder');
$bine = array_combine($explode, $arr);
//---------------------(2)比较2个数组的键值，返回差集(array_diff);
$diff = array_diff($explode,$arr);
 //var_dump($diff);
//--------------------(3)比较2个数组的键值，返回交集(array_intersect);
$intersect = array_intersect($explode,$arr);
//print_r($intersect);
//--------------------(4)将用户自定义函数作用到每个数组的值上，并返回新的数组（array_map）；
function map($v)
{
	return $v+$v;
}
$sum = array('1','9','3');
//print_r(array_map("map",$sum));
//-------------------(5)将指定数量的指定值插入到数组中(array_pad)；
$pad = array_pad($arr, 5, "two");
//print_r($pad);
//-------------------(6)删除数组中最后一个键值(array_pop)
array_pop($arr);
//print_r($arr);
//-------------------(7)//向用户自定义函数发送数组的值，返回一个字符串（array_reduce）
$sum = array('1','9','3');
function reduce($a,$b)
{
	//return $a+$b;
	return $a ."-". $b;
}
//print_r(array_reduce($sum, "reduce",'10'));
//--------------------(8)后面数组替换第一个数组的值(array_replace)
//print_r(array_replace($explode,$arr));
//--------------------(9)在操作中给变量赋值
$my_array = array("Dog","Cat","Horse");
list($a,$b,$c) = $my_array;
//echo $a.$b.$c;
//--------------------(10)




