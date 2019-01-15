<?php
ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ERROR);

require_once "../lib/WxPay.Api.php";
require_once '../lib/WxPay.Notify.php';
require_once 'log.php';
require_once 'mysql.php';
echo 'yes';exit;
//初始化日志
$logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

class PayNotifyCallBack extends WxPayNotify
{
	//查询订单
	public function Queryorder($transaction_id)
	{
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
		Log::DEBUG("query:" . json_encode($result));
		if(array_key_exists("return_code", $result)
			&& array_key_exists("result_code", $result)
			&& $result["return_code"] == "SUCCESS"
			&& $result["result_code"] == "SUCCESS")
		{   
           

		}
		return false;
	}
	
	//重写回调处理函数
	public function NotifyProcess($data, &$msg)
	{
		Log::DEBUG("call back:" . json_encode($data));
		$notfiyOutput = array();
	
		if(!array_key_exists("transaction_id", $data)){
			$msg = "输入参数不正确";
			return false;
		}
		//查询订单，判断订单真实性
		if(!$this->Queryorder($data["transaction_id"])){
			$msg = "订单查询失败";
			return false;
		}
		/*$ind = $data['out_trade_no'];
        $mysql = new MySQL('localhost','ceshijingyingcn','eCADuyArxE','ceshijingyingcn');
		$sql = "update de_indent set status=0 where indents=$ind";
		$mysql->query($sql);*/
         //通过$data['out_trade_no'],在这里处理订单状态

         
         $uri = 'http://'.$_SERVER['HTTP_HOST'].'/index.php/home/login/pay';
         $redirect_uri = urlEncode($uri);
         $result = self::https_request($redirect_uri,$data['out_trade_no']);
         if($result==1){
           return true;
         }else{
           $ind = $data['out_trade_no'];
           $mysql = new MySQL('localhost','ceshijingyingcn','eCADuyArxE','ceshijingyingcn');
		   $sql = "update de_indent set status=0 where indents=$ind";
		   $mysql->query($sql);
           return false;
         }
		
	}

	//执行修改订单

      public function https_request($url, $data = null)
            {
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
                if (!empty($data)){
                    curl_setopt($curl, CURLOPT_POST, 1);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                $output = curl_exec($curl);
                curl_close($curl);
                return $output;
            }
}

Log::DEBUG("begin notify");
$notify = new PayNotifyCallBack();
$notify->Handle(false);
