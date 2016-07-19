<?php
/**
 * 输出时设置头为utf-8
 */
function SetHeaderUtf8(){
    header('Content-Type: text/html; charset=utf-8');
}

/**
 * 获取上一页URL主机或域名，不包括文件及参数 如：192.18.2.8:83
 */
function GetUrlRefererHost(){
     $referer=$_SERVER['HTTP_REFERER'];
     $result=parse_url($referer);
     
     return $result['host'].':'.$result['port'];
}

/**
 * 将gbk转utf-8
 * @param $s 要转换的字符串
 * @return string
 */
function GBKToUtf8($s){
    return iconv('GBK', 'UTF-8//IGNORE', $s);
}

/**
 * 将utf-8转gbk
 * @param unknown $s
 * @return string
 */
function Utf8ToGBK($s){
    return iconv('UTF-8', 'GBK//IGNORE', $s);
}

/**
 * TODO 获取秒，时间种
 * @return 获取秒，时间种
 */
function TimeSeed()
{
    list($msec, $sec) = explode(' ', microtime());
    return str_replace('.','',$sec.$msec);
}

/**
 * 生成guid
 * @return string
 */
function CreateGuid() {
    $charid = strtoupper(md5(uniqid(mt_rand(), true)));
    $hyphen = chr(45);// "-"
    $uuid = chr(123)// "{"
    .substr($charid, 0, 8).$hyphen
    .substr($charid, 8, 4).$hyphen
    .substr($charid,12, 4).$hyphen
    .substr($charid,16, 4).$hyphen
    .substr($charid,20,12)
    .chr(125);// "}"
    return $uuid;
}

/**
 * json 中文序列化会转成 '\u7a0b\u5e8f\u5458'形式，固先把 中文url编码，再序列化后用urldecode转回中文
 * 目前只支持单维数组
 * @param $str
 * @return mixed
 */
function JsonEncode($arr){
    zhuanhuan($arr);
    return urldecode(json_encode($arr));
}



function zhuanhuan(&$arr){
    if(is_array($arr))
    {
        foreach ( $arr as $key => &$value ) {
            $value=zhuanhuan($value);   //递归
        }
        return $arr;
    }
    return  urlencode ( $arr );
}

function JsonDecode($jsonStr){
	return json_decode(urldecode($jsonStr));
}

function EncryptDES($str)
{
    $Key=C('DESKey');
    $Iv=C('DESIv');
    $size = mcrypt_get_block_size ( MCRYPT_DES, MCRYPT_MODE_CBC );   
    $pad = $size - (strlen ( $str ) % $size);  
    $str= $str . str_repeat ( chr ( $pad ), $pad );  
    return  mcrypt_encrypt(MCRYPT_DES, $Key, 'a', MCRYPT_ENCRYPT, $Iv ) ;
    return  mcrypt_cbc(MCRYPT_DES, $Key, 'a', MCRYPT_ENCRYPT, $Iv ) ;
    return strtoupper( bin2hex( mcrypt_cbc(MCRYPT_DES, $Key, $str, MCRYPT_ENCRYPT, $Iv ) ) );  
}

function DecryptDES($str)
{
    $Key=C('DESKey');
    $Iv=C('DESIv');
    $hexData=strtolower( $str );
    $strBin = "";  
    for($i = 0; $i < strlen ( $hexData ); $i += 2) {  
        $strBin .= chr ( hexdec ( substr ( $hexData, $i, 2 ) ) );  
    }
    $str = mcrypt_cbc( MCRYPT_DES, $Key, $strBin, MCRYPT_DECRYPT, $Iv );
    //return $strBin;
    
    $pad = ord ( $str {strlen ( $str ) - 1} );  
    if ($pad > strlen ( $str ))  
        return false;  
    if (strspn ( $str, chr ( $pad ), strlen ( $str ) - $pad ) != $pad)  
        return false;  
    $str = substr ( $str, 0, - 1 * $pad );  
    return $str;  
}
/**
 * TODO 清除非数字的字符串数组，如字符串 '1,2,3,4,rr,aa,5，'则返回字符串 '1,2,3,4,5'
 * @param $ids
 * @return string
 */
function ClearNoInt($ids){
    $arr=explode(',',$ids);

    foreach($arr as $key=>$val){
        if(!is_numeric($val)){
            unset($arr[$key]);
        }
    }

    return implode(',',$arr);
}

/**
 * 判断验证码是否输入正确
 * @param unknown $code
 * @param string $id
 * @return boolean
 */
function IsVerify($code, $id = ''){
    $verify = new \Think\Verify();
    return $verify->check($code, $id);
}

/**
 * 检测日期或时间是否正确
 * @param unknown $t
 * @return boolean
 */
function IsDatetime($t){
    return !(strtotime($t)===false);
}

/**
 * 判断操作是否成功  弹出提示后跳转URL
 * @param unknown $msg
 * @param unknown $tUrl  成功后跳转的URL
 * @param unknown $fUrl  失败后跳转的URL
 * @return string
 */
function IsMsg($msg,$tUrl,$fUrl=''){
	$Msg=$msg["Msg"];
	if($msg["State"]==1){
		return $jstext = redirect($tUrl);
        //return $jstext = "<script>alert('提交成功');location.href='".$tUrl."'; </script>";
	}else{
		return $jstext = "<script>alert('$Msg');location.href='".$fUrl."'; </script>";
	}
}

/**
 * 将数字转换为1,234.00的价格模式
 * @param unknown $number
 * @return string
 */
function ConvertPrice($number){
	setlocale(LC_MONETARY,"zh");
	return number_format($number,2);
}

/**
 * 将字符串转换为Bytes
 * @param mixed $string 
 * @return mixed
 */
function getBytes($string) { 
$bytes = array(); 
for($i = 0; $i < strlen($string); $i++){ 
$bytes[] = ord($string[$i]); 
} 
return $bytes; 
}

/**
 * 获取密码的MD5值，从8位开始截取长度16的字符串
 * @param unknown $password
 * @return string
 */
function MD5_16($password){
	return substr(md5($password), 8,16);
}

/**
 *
 * @param unknown $data  数据可为数组
 * @param unknown $id   value id值
 * @param unknown $name  value name值
 * @param unknown $pControlName  select的控制名
 * @param unknown $pEditValue   此时的值
 * @param unknown $pFirstValue  首项 id值
 * @param unknown $pFirstText   首项 name值
 */
function GetSelectString($data,$id,$name,$pControlName,$pEditValue,$pFirstValue,$pFirstText,$classname)
{
	$sbStr.="<select id=\"" . $pControlName . "\" name=\"" . $pControlName . "\" class=\"".$classname."\" >";
	if (strlen($pFirstText) > 0)
	{
		$sbStr.="<option value=\"".$pFirstValue."\"";

		if ($pFirstValue == $pEditValue)
		{
			$sbStr.=" selected=\"selected\"";
		}

		$sbStr.=">";

		$sbStr.=$pFirstText;
		$sbStr.="</option>";
	}


	foreach ( $data as $info)
	{
		$sbStr.="<option value=\"";
		$sbStr.=$info["".$id];
		$sbStr.="\"";
		if ($info["".$id]."" == $pEditValue."")
		{
			$sbStr.=" selected=\"selected\"";
		}
		$sbStr.=">";
		$sbStr.=$info["".$name];
		$sbStr.="</option>";
	}
	$sbStr.="</select>";
	return $sbStr;
}


/**
 * 删除地址参数
 *
 * @param array $param
 */
function dropParam($param) {
	$purl = getParam();
	if (!empty($param)) {
		foreach ($param as $val) {
			$purl['param'][$val]= 0;
		}
	}
	return urlShop($purl['act'], $purl['op'], $purl['param']);
}

/**
 * 替换地址参数
 *
 * @param array $param
 */
function replaceParam($param) {
	$purl = getParam();
	if (!empty($param)) {
		foreach ($param as $key => $val) {
			$purl['param'][$key] = $val;
		}
	}
    
	return urlShop($purl['act'], $purl['op'], $purl['param']);
}

/**
 * 替换并删除地址参数
 *
 * @param array $param
 */
function replaceAndDropParam($paramToReplace, $paramToDrop) {
	$purl = getParam();
	if (!empty($paramToReplace)) {
		foreach ($paramToReplace as $key => $val) {
			$purl['param'][$key] = $val;
		}
	}
	if (!empty($paramToDrop)) {
		foreach ($paramToDrop as $val) {
			$purl['param'][$val]= 0;
		}
	}

	return urlShop($purl['act'], $purl['op'], $purl['param']);
}

/**
 * 删除部分地址参数
 *
 * @param array $param
 */
function removeParam($param) {
	$purl = getParam();
	if (!empty($param)) {
		foreach ($param as $key => $val) {
			if (!isset($purl['param'][$key])) {
				continue;
			}
			{
				$purl['param'][$key] = 0;
			}
            unset($purl['param'][$key]);
		}
	}
	return urlShop($purl['act'], $purl['op'], $purl['param']);
}

function getParam() {
	$param = $_GET;
	$controller=CONTROLLER_NAME;
	$action=ACTION_NAME;
	$purl = array();
	$purl['act'] = $controller;
	unset($param['act']);
	$purl['op'] = $action;
	unset($param['op']); unset($param['curpage']);
	$purl['param'] = $param;
	return $purl;
}

/**
 * 拼接动态URL，参数需要小写
 *
 * 调用示例
 *
 * 若指向网站首页，可以传空:
 * url() => 表示act和op均为index，返回当前站点网址
 *
 * url('search,'index','array('cate_id'=>2)); 实际指向 index.php?act=search&op=index&cate_id=2
 * 传递数组参数时，若act（或op）值为index,则可以省略
 * 上面示例等同于
 * url('search','',array('act'=>'search','cate_id'=>2));
 *
 * @param string $act control文件名
 * @param string $op op方法名
 * @param array $args URL其它参数
 * @return string
 */
function urlShop($act = '', $op = '', $args = array()){
	//入口文件名
	$file = 'index.php';
	$act = trim($act);
	$op = trim($op);
	$args = !is_array($args) ? array() : $args;
	//var_dump($args);
	//定义变量存放返回url
	$url_string = '';
	$site_url=C('wbsitename')==''?'':'/'.rtrim($site_url,'/');
	if (empty($act) && empty($op) && empty($args)) {
		return $site_url;
	}
	$act = !empty($act) ? $act : 'index';
	$op = !empty($op) ? $op : 'index';
	//默认路由模式
	$url_perfix = "{$act}/{$op}";
	if (!empty($args)){
		$url_perfix .= '/?';
	}
	$paramurl=http_build_query($args);
	//$paramurl=str_replace('=', '/',$paramurl);
	//$paramurl=str_replace('&', '/',$paramurl);
	$url_string = $file.'/'.$url_perfix.$paramurl ;
	return $site_url.'/'.$url_string;
}
?>