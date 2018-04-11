<?php
/**
 * Created by Drupai.
 * User: 烽行天下
 * Date: 2018\4\8 0008
 * Time: 17:35
 */

namespace AppBundle\Service;


class PinYin
{
    public $spellArray = array();

    static public function getArray() {
        return unserialize(file_get_contents('pytable_without_tune.txt'));
    }

    /**
     * @desc 将字符串转换成拼音字符串
     * @param $string
     * @param $upper
     * @return string
     *
     * 例如：getChineseChar('我是作者'); 全部字符串+小写
     * return "wo shi zuo zhe"
     *
     * 例如：getChineseChar('我是作者',true); 首字母+小写
     * return "w s z z"
     *
     * 例如：getChineseChar('我是作者',true,true); 首字母+大写
     * return "W S Z Z"
     *
     * 例如：getChineseChar('我是作者',false,true); 首字母+大写
     * return "WO SHI ZUO ZHE"
     */
     public function getChineseChar($string,$isOne=false,$upper=false) {
         $spellArray = self::getArray();
         $str_arr = $this->utf8_str_split($string); //将字符串拆分成数组
         $result = array();
        foreach($str_arr as $index => $char)
        {
            if(preg_match('/^[\x{4e00}-\x{9fa5}]+$/u',$char))
            {
                $chinese = $spellArray[$char];
            } else{
                $chinese = $char;
            }
            $chinese = $isOne ? substr($chinese,0,1) : $chinese;
            $result[] = $upper ? strtoupper($chinese) : $chinese;
        }
        return implode('-', $result);
    }
    /**
     * @desc 将字符串转换成数组
     * @param $str
     */
    public function utf8_str_split($str) {

        if(!preg_match('/[a-zA-Z0-9\.]/u',$str)){
            return $this->getChineseStr($str,1);
        }else {
            $zh_ar = preg_split("/([a-zA-Z0-9\.]+)/", $str, 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
            for ($index = 0; $index < sizeof($zh_ar); $index++) {
                if (preg_match('/^[\x{4e00}-\x{9fa5}]+$/u', $zh_ar[$index])) {
                    $chStr = $this->getChineseStr($zh_ar[$index], 1);
                    array_splice($zh_ar, $index, 1, $chStr);
                    //$index += mb_strlen($zh_ar[$index], 'UTF-8');
                }
            }
            return $zh_ar;
        }

    }
    public function getChineseStr($str,$split_len=1){
        if(!preg_match('/^[0-9]+$/', $split_len) || $split_len < 1) {
            return FALSE;
        }

        $len = mb_strlen($str, 'UTF-8');

        if ($len <= $split_len) {
            return array($str);
        }
        preg_match_all('/.{'.$split_len.'}|[^\x00]{1,'.$split_len.'}$/us', $str, $ar);

        return $ar[0];
    }
}