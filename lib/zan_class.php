<?php
/*by:逍遥*/
class DianZan{
    private $qq;
    private $sid;
    private $feeds;
    private $result;
    private $pdo;
    private $table='dz';
    public function __construct($qq,$sid,PDO $pdo=null,$table=null){
        $this->qq=$qq;
        $this->sid=$sid;
        $this->feeds=array();
        if(!empty($pdo)) $this->pdo=$pdo;
        if(!empty($table)) $this->table=$table;
    }
    public function getFeedslist(){
        $curl=curl_init('http://m.qzone.com/get_feeds?res_type=0&refresh_type=2&format=json&sid='.$this->sid);
        curl_setopt($curl,CURLOPT_HEADER,0);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($curl,CURLOPT_USERAGENT,'Mozilla/5.0 (Linux; Android 4.4.4; MI 2 Build/KTU84P) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/33.0.0.0 Mobile Safari/537.36 V1_AND_SQI_4.6.13_0_YYB_D QQ/4.6.13.6034');
        $rt=curl_exec($curl);
        curl_close($curl);
        $dejson=json_decode($rt,true);
        if (isset($dejson['data']['vFeeds']) && empty($dejson['message'])){
        $msg=$dejson['data']['vFeeds'];
        foreach($msg as $b){
              if(!isset($b['like']['isliked']) or $b['like']['isliked']=='0'){
                  $uin=$b['userinfo']['user']['uin'];
                  $feed_0=$b['comm']['curlikekey'];
                  $feed_1=$b['comm']['orglikekey'];
                  $this->feeds[]=array($feed_0,$feed_1,$uin);
               }
        }
        }else{
        $this->feeds='siderr';
        }
return $this->feeds;
}
    public function dz(array $feeds=null){
        if(empty($feeds)){
            $feeds=(array)$this->feeds;
        }
        if(empty($feeds) or !is_array($feeds)) return;
        $opt=array(
            CURLOPT_URL=>'http://m.qzone.com/praise/like',
            CURLOPT_TIMEOUT=>5,
            CURLOPT_AUTOREFERER=>false,
            CURLOPT_RETURNTRANSFER=>true,
            CURLOPT_COOKIE=>"pt2gguin=o0{$this->qq}; sid={$this->sid}",
            CURLOPT_POST=>true,
            CURLOPT_USERAGENT=>'Mozilla/5.0 (Linux; Android 4.4.4; MI 2 Build/KTU84P) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/33.0.0.0 Mobile Safari/537.36 V1_AND_SQI_4.6.13_0_YYB_D QQ/4.6.13.6034'
        );
        $curl=curl_init();
        curl_setopt_array($curl,$opt);
        $rs=array();
        foreach($feeds as $feed){
            curl_setopt($curl,CURLOPT_POSTFIELDS,"opr_type=like&action=0&res_uin={$feed[2]}&res_type=311&uin_key={$feed[0]}&cur_key={$feed[1]}&format=json&sid={$this->sid}");
            $this->result[$feed[2]]=curl_exec($curl);
        }
        curl_close($curl);
        return $this->result;
    }
    public function __destruct(){
        unset($this->qq,$this->sid,$this->feeds,$this->result,$this->pdo,$this->table);
    }
}

class ZAN{
    function __construct($uin, $pwd) {
        $this->uin = $uin;
        $this->pwd = $pwd;
    }
    
function qqsid($loginType='3')
    {
    $ua='';
    $ip='119.4.252.55';
    $login_url="http://pt.3g.qq.com/s?aid=nLoginnew&amp;q_from=3GQQ";
    $url="http://pt.3g.qq.com/psw3gqqLogin?r=254354237&amp;vdata=8F9E143A1DC6135BEB3E7E9A23E91592";
    $post=<<<POST
qq={$this->uin}&pwd={$this->pwd}&bid_code=3GQQ&toQQchat=true&login_url={$login_url}&q_from=&modifySKey=0&loginType=1&aid=nLoginHandle
POST;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);//设置为POST方式
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_HTTPHEADER,array(
        'Accept-Language: zh-CN',
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8,UC/145,plugin/1,alipay/un',
        'Connection: keep-alive',
        'Client_Ip:'.$ip,
        'Real_ip:'.$ip,
        'X_FORWARD_FOR:'.$ip,
        'X-forwarded-for:'.$ip,
        'PROXY_USER:'.$ip,
));
        curl_setopt($ch, CURLOPT_REFERER, 'http://pt.3g.qq.com/s?aid=nLogin3gqq&auto=1&s_it=1&g_f=286&sid=AR-CmDAz0wsuTaRu_VszeQo6'); //伪造来路页面
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION ,true);
       curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $ua);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
}
    function curl_post($post)
    {
    $ua='';
    $url="http://pt.3g.qq.com/handleLogin?sid=AX4FjaqYuGuXKR2IH8C14Fgv&amp;vdata=";
    $ip='119.4.252.55';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);//设置为POST方式
        curl_setopt($ch,CURLOPT_HTTPHEADER,array(
        'Accept-Language: zh-CN',
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8,UC/145,plugin/1,alipay/un',
        'Connection: keep-alive',
        'Client_Ip:'.$ip,
        'Real_ip:'.$ip,
        'X_FORWARD_FOR:'.$ip,
        'X-forwarded-for:'.$ip,
        'PROXY_USER:'.$ip,
));
        curl_setopt($ch, CURLOPT_REFERER, 'http://pt.3g.qq.com/handleLogin?vdata=A57CFE211E5B8B2682571F32C081CB51'); //伪造来路页面
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION ,true);
       curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $ua);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
        }
        
function code($res){
					$result = htmlspecialchars($res);
					preg_match('/(&lt;img.*?&quot;验证码&quot;)/i',$result,$test);
					$img = htmlspecialchars_decode($test['1']).'/>';
					preg_match_all("/name=&quot;(\w+)&quot; value=&quot;(.*?)&quot;/i",$result,$arr);
					$arry=array_combine($arr['1'],$arr['2']);
					$dataarr='';
					foreach($arry as $key => $value){
					if($key!='submitlogin' && $key!='imgType' && $key!='verify'){
					$dataarr.='<input type="hidden" name="'.$key.'" value="'.$value.'">	
';
}
					}
					$data = '系统检测到您的操作异常，为保证您的号码安全，请输入验证码进行验证，防止他人盗取密码。<br>'.$img.'<form action="'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'].'" method="POST"><input type="hidden" name="input" value="2">
<input type="hidden" name="password" value="'.$this->pwd.'">' . $dataarr.'请输入上图字符(不区分大小写)：<br><input name="verify" type="text" maxlength="18" value=""><br> <input type="submit" name="submitlogin" value="马上登录"> </form>';
					return $data;
    }
    
     function url($url)
    {
     $ua='Mozilla/5.0 (Linux; U;Android 4.4.4; zh-CN; MI 2 Build/KTU84P) AppleWebKit/534.30 (KHTML,like Gecko) Version/4.0 UCBrowser/10.0.0.488 U3/0.8.0 Mobile Safari/534.30';
     $ip='119.4.252.55';
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_HTTPHEADER,array(
        'Accept-Language: zh-CN',
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8,UC/145,plugin/1,alipay/un',
        'Connection: keep-alive',
        'Client_Ip:'.$ip,
        'Real_ip:'.$ip,
        'X_FORWARD_FOR:'.$ip,
        'X-forwarded-for:'.$ip,
        'PROXY_USER:'.$ip,
));
        curl_setopt($ch, CURLOPT_REFERER, 'http://m.qzone.com/infocenter?g_f=2425'); //伪造来路页面
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $ua);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

}
?>