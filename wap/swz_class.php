<?php
class swzclass
{

function mod($bn,$sn)
{
return intval(fmod(floatval($bn),$sn));
}
function mod_1($b,$s)
{
return intval(floor(floatval($b)/$s));
}

function zq($type,$zq)
{
switch ($type){
case 'tl':
$zqd=12;
$name="体力处于";
break;
case 'qx':
$zqd=14;
$name="情绪处于";
break;
case 'zl':
$zqd=17;
$name="智力处于";
break;
}
switch ($zq){
case 0:
return $name."周期日";
break;
case $zq<$zqd:
return $name."高潮期";
break;
case $zq==$zqd:
return $name."临界日";
break;
case $zq>$zqd:
return $name."低潮期";
break;
}
}

function swz($date_1,$date_2){
if (preg_match("/^(?:(?!0000)[0-9]{4}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-8])|(?:0[13-9]|1[0-2])-(?:29|30)|(?:0[13578]|1[02])-31)|(?:[0-9]{2}(?:0[48]|[2468][048]|[13579][26])|(?:0[48]|[2468][048]|[13579][26])00)-02-29)$/i",$date_2)){
$d1=strtotime($date_1);
$d2=strtotime($date_2);
$day=round(($d1-$d2)/3600/24);
$tl=$this->mod($day,23);
$qx=$this->mod($day,28);
$zl=$this->mod($day,33);
$tlzq=$this->mod_1($day,23);
$qxzq=$this->mod_1($day,28);
$zlzq=$this->mod_1($day,33);
return "你生日是：".$date_2."<br>体力周期：".$tlzq."周期第".$tl."天\n".$this->zq("tl",$tl)."<br>情绪周期：".$qxzq."周期第".$qx."天\n".$this->zq("qx",$qx)."<br>智力周期：".$zlzq."周期第".$zl."天\n".$this->zq("zl",$zl)."<br>";
}else{
return "你输入的日期".$date_2."有误，请输入正确的日期";
}
}

function xz($month, $day){
    $signs = array(
            array('20'=>'水瓶座'), array('19'=>'双鱼座'),
            array('21'=>'白羊座'), array('20'=>'金牛座'),
            array('21'=>'双子座'), array('22'=>'巨蟹座'),
            array('23'=>'狮子座'), array('23'=>'处女座'),
            array('23'=>'天秤座'), array('24'=>'天蝎座'),
            array('23'=>'射手座'), array('22'=>'摩羯座')
    );
    $key = (int)$month - 1;
    list($startSign, $signName) = each($signs[$key]);
    if( $day < $startSign ){
        $key = $month - 2 < 0 ? $month = 11 : $month -= 2;
        list($startSign, $signName) = each($signs[$key]);
    }
    return $signName;
}
}
?>