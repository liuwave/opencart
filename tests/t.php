<?php
$xmlData = "<Packet><requesthead><request_type>Q01</request_type></requesthead></Packet>";
$url = 'http://weidx.piccnet.com.cn/WebTransNet4/$guangzhoupicc/weixinPlat_test/wxprice/wxCalculate.do';
function postXmlCurl($xml,$url,$second=30)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
	curl_setopt($ch, CURLOPT_TIMEOUT, $second);
	//$this_header =$this->defaultHeader();
	curl_setopt($ch, CURLOPT_HEADER, false);
	$data = curl_exec($ch);
	if(!$data){
		$error = curl_errno($ch);
		print_r($error);exit;
		//$this->logResult("error::postXmlCurl::cur:$error,http://curl.haxx.se/libcurl/c/libcurl-errors.htm");
	}
	curl_close($ch);
	return $data;
}

function XML2Array ( $xml , $recursive = false )
{
	if ( ! $recursive )
	{
		$array = simplexml_load_string ( $xml ) ;
	}
	else
	{
		$array = $xml ;
	}


	$newArray = array () ;
	$array = ( array ) $array ;
	foreach ( $array as $key => $value )
	{
		$value = ( array ) $value ;
		if ( isset ( $value [ 0 ] ) )
		{
			$newArray [ $key ] = trim ( $value [ 0 ] ) ;
		}
		else
		{
			$newArray [ $key ] = XML2Array ( $value , true ) ;
		}
	}
	return $newArray ;
}

$xml = postXmlCurl($xmlData,$url);//访问
$reArray = XML2Array($xml);//接收

var_dump($reArray);
?>