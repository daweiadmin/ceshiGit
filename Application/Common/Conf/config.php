<?php
return array(
	//'配置项'=>'配置值'
	//数据库配置信息
'DB_TYPE' => 'mysql', // 数据库类型
'DB_HOST' => 'localhost', // 服务器地址
'DB_NAME' => 'redbag', // 数据库名
'DB_USER' => 'root', // 用户名
'DB_PWD' => '', // 密码Passw0rd
'DB_PORT' => 3306, // 端口
'DB_CHARSET'=> 'utf8', // 字符集
'DB_PREFIX' => 'red_', // 数据库表前缀
'TMPL_ACTION_SUCCESS'=>'Public:dispatch_jump', //跳转页面                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
'TMPL_ACTION_ERROR'=>'Public:dispatch_jump',
 'TOKEN'  =>'bWj6ThS4Gg56l87Z',

'DATA_CACHE_PREFIX' => 'Redis_',//缓存前缀
'DATA_CACHE_TYPE'=>'Redis',//默认动态缓存为Redis
'REDIS_RW_SEPARATE' => true, //Redis读写分离 true 开启
'REDIS_HOST'=>'127.0.0.1', //redis服务器ip，多台用逗号隔开；读写分离开启时，第一台负责写，其它[随机]负责读；
'REDIS_PORT'=>'6379',//端口号
'REDIS_TIMEOUT'=>'300',//超时时间
'REDIS_PERSISTENT'=>false,//是否长连接 false=短连接
'REDIS_AUTH'=>'',//AUTH认证密码

'WEIXINPAY_CONFIG'       => array(
        'APPID'              => 'wx58b98e1625d1af4b', // 微信支付APPID
        'MCHID'              => '1518635501', // 微信支付MCHID 商户收款账号
        'KEY'                => 'FDbHW9u7V8iFFrctpE74XLtn81Imd3lf', // 微信支付KEY
        'APPSECRET'          => '38ab555b0efcac67cd9679eff1b14a68',  //公众帐号secert
        'NOTIFY_URL'         => 'http://redbag.lingcheng888.com/index.php/shop/return/notify_url',// 接收支付状态的连接
        //=======【curl代理设置】===================================
        /**
         * TODO：这里设置代理机器，只有需要代理的时候才设置，不需要代理，请设置为0.0.0.0和0
         * 本例程通过curl使用HTTP POST方法，此处可修改代理服务器，
         * 默认CURL_PROXY_HOST=0.0.0.0和CURL_PROXY_PORT=0，此时不开启代理（如有需要才设置）
         * @var unknown_type
         */
        'CURL_PROXY_HOST'    =>"0.0.0.0",
        'CURL_PROXY_PORT'    =>0,

        ),
 //银联支付参数
'YINLIANPAY_CONFIG'       => array(
        'tid'              => '88880001', // 终端号
        'mid'              => '898340149000005', //  商户号
        'KEY'                => 'fcAmtnx7MwismjWNhNKdHC44mNXtnEQeJkRrhKJwyrW2ysRR', // MD5密钥
        'instMid'          => 'YUEDANDEFAULT',  //机构商户号
        'msgSrc'          => 'WWW.TEST.COM',  //消息来源
        'msgSrcId'          => '3194',  //来源编号
        'NOTIFY_URL'         => 'http://redbag.lingcheng888.com/index.php/home/wxpay/return_back',// 
        ),
   //开放平台参数
'WXKAI_CONFIG'       => array(
        'encodingAesKey'              => 'msLNIakL2hqXPSt6bnp1r3GM92wbKcKOQiTRFuh6l4y', // 消息加解密Key 
        'token'              => 'bvcpdrxDuASL5FwY1TjvxNRnh2jIxS1nEK', //  消息校验Token 
        'appId'                => 'wx5b1922d9c58d7b46', // 开放平台appid
        'appsecret'          => '50d1a53fe0b2726ab3b7e6d39537f6fc',  //开放平台appsecret
        ),

);
/*return array(
        //'配置项'=>'配置值'
        //数据库配置信息
'DB_TYPE' => 'mysql', // 数据库类型
'DB_HOST' => 'localhost', // 服务器地址
'DB_NAME' => 'xingyouji', // 数据库名
'DB_USER' => 'xingyouji', // 用户名
'DB_PWD' => 'P2H3P6D7', // 密码
'DB_PORT' => 3306, // 端口
'DB_CHARSET'=> 'utf8', // 字符集
'DB_PREFIX' => 'fen_', // 数据库表前缀
'TMPL_ACTION_SUCCESS'=>'Public:dispatch_jump', //跳转页面
'TMPL_ACTION_ERROR'=>'Public:dispatch_jump',

'WEIXINPAY_CONFIG'       => array(
        'APPID'              => 'wx3283731bd9c08c42', // 微信支付APPID
                                 
        'MCHID'              => '1504017561', // 微信支付MCHID 商户收款账号
        'KEY'                => 'bEiIgqga0BpFmgNjMXHqUMawgE7bkj5Z', // 微信支付KEY
        'APPSECRET'          => '85e77ec31aa77396ddefb2fa63f7d7f5',  //公众帐号secert
        'NOTIFY_URL'         => 'http://xingyouji.weidoushi.com/index.php/home/wxpay/notify',// 接收支付状态的连接
        ),
 'TOKEN'  => 'xingyoujidetoken',

);
1516202131
18132009372
修改本商户得类目 可不可以改变  T+1变T+7
商户重新申请怎么申请   新申请一个公众号 开通支付？


*/
