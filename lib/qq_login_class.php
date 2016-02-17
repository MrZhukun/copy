<?php
class SET_MQQ {
    function __construct($uin, $pwd) {
        $this->uin = $uin;
        $this->pwd = $pwd;
        $this->host = '119.147.10.10';
        $this->port = '14000';
    }
    /*(1).登录QQ*/
    function Login($code = 10) {
        $pack = 'VER=1.4&CON=1&CMD=Login&SEQ='.rand(1,9000).'&UIN='.$this->uin.'&PS='.$this->pwd.'&M5=1&LG=0&ST='.$code.'&LC=812822641C978097&GD=5MWX2PF3FOVGTP6B&CKE=%0D%0A';
        $return = $this->request_by_curl($pack);
        if (strpos($return, "CMD=VERIFYCODE")) {
            $vc = explode("&VC=", $return);
            $return = json_encode(array(
                'status' => 'vc',
                'res' => $vc[1]
            ));
        } elseif (strpos($return, "Password error")) {
            $return = json_encode(array(
                'status' => 'password'
            ));
        } elseif (strpos($return, "&RS=0")) {
            $return = json_encode(array(
                "status" => "ok"
            ));
        } else {
            $return = json_encode(array(
                "status" => "error",
                'qq' => $this->uin,
                'result' => $return
            ));
        }
        return $return;
    }
    /*验证码处理*/
    function Verifycode($code) {
        $pack = 'VER=1.4&CON=1&CMD=VERIFYCODE&SEQ='.rand(1,9000).'&UIN='.$this->uin.'&SID=&XP=C4CA4238A0B92382&SC=2&VC='.$code;
        $return = $this->request_by_curl($pack);
        if (strpos($return, "&VC=")) {
            $vc = explode("&VC=", $return);
            $return = json_encode(array(
                'status' => 'vc',
                'res' => $vc[1]
            ));
        } else {
            $return = json_encode(array(
                'status' => 'ok'
            ));
        }
        return $return;
    }
    /*更改在线状态*/
    function ChangeStat($code) {
        $pack = 'VER=1.4&CMD=Change_Stat&SEQ='.rand(1,9000).'&UIN='.$this->uin.'&ST='.$code;
        $return = $this->request_by_curl($pack);
        if (strpos($return, "&RES=20")) {
            $return = $this->Login();
            return $return;
            //$return=json_encode(array('status'=>'offline'));
            
        } else {
            $return = json_encode(array(
                'status' => 'ok'
            ));
        }
        return $return;
    }
    /*信息查询*/
    function level($qq, $sid) {
        $url = "http://q32.3g.qq.com/g/s?sid=".$sid."&aid=nqqSelf";
        $dos = file_get_contents($url);
        $info1 = $this->preg_message($dos, "等级:[subject]<img", "subject", -1);
        $level = floatval($info1[0]);
        $info2 = $this->preg_message($dos, "还有[subject]天", "subject", -1);
        $day = floatval($info2[0]);
        $info3 = $this->preg_message($dos, "呢称:[subject]<br/>", "subject", -1);
        $qname = $info3[0];
        $data['level'] = $level;
        $day = ((pow(($level+1),2)+4*$level) - $day+4);
        $data['day'] = $day;
        $data['qname'] = $qname;
        return $data;
    }
    //截取字符
    function preg_message($message, $rule, $getstr, $limit = 1) {
        $result = array(
            '0' => ''
        );
        $rule = $this->conver_trule($rule); //转义正则表达式特殊字符串
        $rule = str_replace('\['.$getstr.'\]', '\s*(.+?)\s*', $rule); //解析为正正则表达式
        if ($limit == 1) {
            preg_match("/$rule/is", $message, $rarr);
            if (!empty($rarr[1])) {
                $result[0] = $rarr[1];
            }
        } else {
            preg_match_all("/$rule/is", $message, $rarr);
            if (!empty($rarr[1])) {
                $result = $rarr[1];
            }
        }
        return $result;
    }
    /**
    *转义正则表达式字符串
     */
    function conver_trule($rule) {
        $rule = preg_quote($rule, "/"); //转义正则表达式
        $rule = str_replace('\*', '.*?', $rule);
        $rule = str_replace('\|', '|', $rule);
        return $rule;
    }
    /*转编码*/
    function escape($str) {
        preg_match_all("/[-].|[\x01-]+/", $str, $r);
        $ar = $r[0];
        foreach ($ar as $k => $v) {
            if (ord($v[0]) < 128) $ar[$k] = rawurlencode($v);
            else $ar[$k] = "%u".bin2hex(iconv("GB2312", "UCS-2", $v));
        }
        return join("", $ar);
    }
    /*(2).发送聊天消息*/
    function SendMsg($toperson, $msg) {
        $msg2 = str_replace("+", " ", $msg);
        $pack = 'VER=1.4&CON=0&CMD=CLTMSG&SEQ='.rand(1,9000).'&UIN='.$this->uin.'&SID=&XP=B58304217ADD0489&UN='.$toperson.'&MG='.$msg2;
        $return = $this->request_by_curl($pack);
    }
    /*(3).获得即时聊天消息*/
    function GetMsg($_reply) {
        $pack = 'VER=1.4&CON=0&CMD=GetMsgEx&SEQ='.rand(1,9000).'&UIN='.$this->uin.'&SID=&XP=29E41F6186ED43F8';
        $return = $this->request_by_curl($pack);
        $message = explode('&UN=', $return);
        $unandmsg = isset($message['1'])?$message['1']:Null;
        $need = explode('&MG=', $unandmsg);
        $need_MTstr = explode('&MT=', $message[0]);
        $need_mt = isset($need_MTstr['1'])?$need_MTstr['1']:Null;
        $need_un = $need['0'];
        $need_mg = isset($need['1'])?$need['1']:Null;
        $un = explode(',', $need_un);
        $mg = explode(',', $need_mg);
        $mt = explode(',', $need_mt);
        $n='';
        for ($i = 0; $i < count($un); $i++) {
            if (!empty($un[$i]) and $mt[$i] != '99') {
                if ($un[$i] != '10000') {
                    $n.= urlencode($this->GetInfo($un[$i], 'NK', '1', rand(1,9000))); //QQ呢称
                    $n.= '('.$un[$i];
                    $n.= ')%0D%0A'; //收到消息来自的QQ号码
                    $n.= urlencode($mg[$i]).'%0D%0A'; //收到的消息的文本内容
                    $this->SendMsg($un[$i],$_reply);
                    $udata[] = $un[$i];
                }
            } else {
                continue;
            }
        }
        $data['msg'] = $n;
        $data['uin'] = isset($udata)?$udata:Null;
        return $data;
    }
    /*(4).查看好友信息*/
    function GetInfo($toperson, $set, $lv) {
        $pack = 'VER=1.4&CMD=GetInfo&SEQ='.rand(1,9000).'&UIN='.$this->uin.'&LV='.$lv.'&UN='.$toperson; //配置信息详细程度LV
        $return = $this->request_by_curl($pack);
        $message = explode('&'.$set.'=', $return);
        $need_arr = explode('&', $message[1]);
        $need = $need_arr[0];
        //print_r($message);
        //print_r($message["$set"]);
        return $need;
    }
    /*(5).查看好友列表*/
    function GetList() {
        $pack = 'VER=1.4&CMD=List&SEQ='.rand(1,9000).'&UIN='.$this->uin; //配置信息详细程度LV
        $return = $this->request_by_curl($pack);
        $need = explode('&UN=', $return);
        return $need[1];
    }
    function request_by_curl($fields) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://{$this->host}:{$this->port}");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, "iQQol Client");
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
    function hextopng($hex) {
        $bin = "";
        $str = str_split($hex, 2);
        for ($i = 0; $i < count($str); $i++) {
            $bin.= chr(hexdec($str[$i]));
        }
        return $bin;
    }
}
?>