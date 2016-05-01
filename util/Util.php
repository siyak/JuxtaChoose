<?php
class Util {

    public static function isStringSet($string) {
        if (!(isset($string))) {
            return false;
        }

        if (trim($string) == "") {
            return false;
        }
        return true;
    }

    /**
     * @static
     * @param string $key
     * @param array $array
     * @return array
     */
    public static function arrayReturn($key, $array) {
        $returnValue = null;
        if (Util::isStringSet($key) && is_array($array)) {
            if (array_key_exists($key, $array))
                $returnValue = $array[$key];
        }
        return $returnValue;
    }

    public static function pollIdEncode($input){
        return str_replace('=','_',Base62::encode($input));
    }

    public static function pollIdDecode($input){
        return Base62::decode(str_replace('_','=',$input));
    }


}

class Base62{
    public static function encode($val, $base=4, $chars='zxvn') {
        // can't handle numbers larger than 2^31-1 = 2147483647
        $str = '';
        do {
            $i = $val % $base;
            $str = $chars[$i] . $str;
            $val = ($val - $i) / $base;
        } while($val > 0);
        return $str;
    }

    public static function decode($str, $base=4, $chars='zxvn') {
        $len = strlen($str);
        $val = 0;
        $arr = array_flip(str_split($chars));
        for($i = 0; $i < $len; ++$i) {
            $val += $arr[$str[$i]] * pow($base, $len-$i-1);
        }
        return $val;
    }
}
