<?php
namespace App\Http\Controllers;
use Symfony\Component\Debug\header;
class PayController extends Controller
{	
	/**
	 *支付宝网关地址（新）
	 */
	protected  $alipay_gateway_new = 'https://mapi.alipay.com/gateway.do?';
	public $alipay_config=array();
	public function alipay()
	{
		$this->alipay_config=$alipay_config=config('alipay');
		$parameter = array(
				"service"       => $alipay_config['service'],
				"partner"       => $alipay_config['partner'],
				"seller_id"  => $alipay_config['seller_id'],
				"payment_type"	=> $alipay_config['payment_type'],
				"notify_url"	=> $alipay_config['notify_url'],
				"return_url"	=> $alipay_config['return_url'],
		
				"anti_phishing_key"=>$alipay_config['anti_phishing_key'],
				"exter_invoke_ip"=>$alipay_config['exter_invoke_ip'],
				"out_trade_no"	=> 'test20160723141218',
				"subject"	=> 'test商品123',
				"total_fee"	=> '0.01',
				"body"	=> '即时到账测试',
				"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
				//其他业务参数根据在线开发文档，添加参数.文档地址:https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.kiX33I&treeId=62&articleId=103740&docType=1
				//如"参数名"=>"参数值"
		
		);
		$para_filter=array();
		while (list($key,$value)=each($parameter))
		{
			if ($key=='sign' || $key=='sign_type' || $value == '') 
			{
				continue;
			}
			else
			{
				$para_filter[$key]=$value;
			}
		}
		ksort($para_filter);
		reset($para_filter);
		$para_filter['sign']=$this->create_sign($para_filter);
		$para_filter['sign_type']=config('alipay.sign_type');
		echo $this->buildRequestForm($para_filter, 'get', '确认');
	}
	public function create_sign(array $sign_array)
	{
		$str='';
		while (list($key,$value)=each($sign_array))
		{
			$str.=$key.'='.$value.'&';		
		}		
		$str=rtrim($str,'&');
		return md5($str.config('alipay.key'));
	}
	function buildRequestForm($para_temp, $method, $button_name)
	 {
		$sHtml = "<form id='alipaysubmit' name='alipaysubmit' action='".$this->alipay_gateway_new."_input_charset=".trim(strtolower($this->alipay_config['input_charset']))."' method='".$method."'>";
		while (list ($key, $val) = each ($para_temp)) {
			$sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
		}
		//submit按钮控件请不要含有name属性
		$sHtml = $sHtml."<input type='submit'  value='".$button_name."' style='display:none;'></form>";
	
		$sHtml = $sHtml."<script>document.forms['alipaysubmit'].submit();</script>";
	
		return $sHtml;
	}
}