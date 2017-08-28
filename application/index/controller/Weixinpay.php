<?php
namespace app\index\controller;

use think\Controller;
use wxpay\database\WxPayUnifiedOrder;
use wxpay\NativePay;
use wxpay\WxPayConfig;
use wxpay\WxPayApi;
use wxpay\PayNotifyCallBack;
use wxpay\database\WxPayNotify;
use wxpay\database\WxPayDataBase;
use wxpay\database\WxPayResults;
class Weixinpay extends Controller
{
    public function notify()
    {
        //公网测试 流数据
        /*$weixinData = file_get_contents("php://input");
        file_put_contents('/tmp/2.txt', $weixinData, FILE_APPEND);*/

        try {
            $resultObj = new WxPayResults();
            $weixinData = $resultObj->Init($resultObj);//校验并解析为数组
        }catch (\Exception $e) {
            $resultObj->setData('return_code', 'FAIL');
            $resultObj->setData('return_msg', $e->getMessage());
            return $resultObj->toXml();
        }
        if($weixinData['return_code'] === 'FAIL' || $weixinData['return_code'] != 'SUCCESS') {
            $resultObj->setData('return_code', 'FAIL');
            $resultObj->setData('return_msg', 'ERROR');
            return $resultObj->toXml();
        }
        //根据out_trade_no来查询订单数据
        $outTradeNo = $weixinData['out_trade_no'];
        $order = model('Order')->get(['out_trade_no' => $outTradeNo]);
        if(!$order || $order->pay_status == 1) {
            $resultObj->setData('return_code', 'SUCCESS');
            $resultObj->setData('return_msg', 'OK');
            return $resultObj->toXml();
        }
        //更新商品表，订单表
        try {
            model('Order')->updateOrderByOutTradeNo($outTradeNo, $weixinData);
            model('Deal')->updateBuyCountById($order->deal_id, $order->deal_count);
        }catch (\Exception $e) {
            //没更新 继续让微信服务器回调
            return false;
        }
        $resultObj->setData('return_code', 'SUCCESS');
        $resultObj->setData('return_msg', 'OK');
        return $resultObj->toXml();
    }
    public function wxpayQCode($id)
    {
        //测试
        $notify = new NativePay();
        $input = new WxPayUnifiedOrder();
        $input->setBody("支付0.01");
        $input->setAttach("支付0.01");
        $input->setOutTradeNo(WxPayConfig::MCHID.date("YmdHis"));
        $input->setTotalFee("1");
        $input->setTimeStart(date("YmdHis"));
        $input->setTimeExpire(date("YmdHis", time() + 600));
        $input->setGoodsTag("QRCode");
        $input->setNotifyUrl("/index.php/index/weixinpay/notify");//回调url 支付成功后回调
        $input->setTradeType("NATIVE");
        $input->setProductId($id);//商品id
        $result = $notify->getPayUrl($input);
        if(empty($result["code_url"])) {
            $url = '';
        }else {
            $url = $result["code_url"];
        }
        return '<img alt="扫码支付" src="/weixin/example/qrcode.php?data='. urlencode($url).'" style="width:300px;height:300px;"/>';
    }
}
