<?php

/*
 * The MIT License (MIT)

 * Copyright (c) 2015 Rafni <alberto.rcdb@gmail.com>

 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:

 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.

 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

/**
 * Validation is a library to validate the most common data types in PHP
 *
 * @author rafni <alberto.rcdb@gmail.com>
 * @category Validator, data validations
 */
class Is {
    
    /**
     * Checks whether the international banking were an account is correct
     * @param string $iban
     * @return boolean
     */
    public static function iban($iban) {
        $iban = strtolower(str_replace(' ','',$iban));
        $Countries = array('al'=>28,'ad'=>24,'at'=>20,'az'=>28,'bh'=>22,'be'=>16,'ba'=>20,'br'=>29,'bg'=>22,'cr'=>21,'hr'=>21,'cy'=>28,'cz'=>24,'dk'=>18,'do'=>28,'ee'=>20,'fo'=>18,'fi'=>18,'fr'=>27,'ge'=>22,'de'=>22,'gi'=>23,'gr'=>27,'gl'=>18,'gt'=>28,'hu'=>28,'is'=>26,'ie'=>22,'il'=>23,'it'=>27,'jo'=>30,'kz'=>20,'kw'=>30,'lv'=>21,'lb'=>28,'li'=>21,'lt'=>20,'lu'=>20,'mk'=>19,'mt'=>31,'mr'=>27,'mu'=>30,'mc'=>27,'md'=>24,'me'=>22,'nl'=>18,'no'=>15,'pk'=>24,'ps'=>29,'pl'=>28,'pt'=>25,'qa'=>29,'ro'=>24,'sm'=>27,'sa'=>24,'rs'=>22,'sk'=>24,'si'=>19,'es'=>24,'se'=>24,'ch'=>21,'tn'=>24,'tr'=>26,'ae'=>23,'gb'=>22,'vg'=>24);
        $Chars = array('a'=>10,'b'=>11,'c'=>12,'d'=>13,'e'=>14,'f'=>15,'g'=>16,'h'=>17,'i'=>18,'j'=>19,'k'=>20,'l'=>21,'m'=>22,'n'=>23,'o'=>24,'p'=>25,'q'=>26,'r'=>27,'s'=>28,'t'=>29,'u'=>30,'v'=>31,'w'=>32,'x'=>33,'y'=>34,'z'=>35);

        if (strlen($iban) == $Countries[substr($iban,0,2)]) {
            $MovedChar = substr($iban, 4).substr($iban,0,4);
            $MovedCharArray = str_split($MovedChar);
            $NewString = "";
            foreach ($MovedCharArray as $key => $value) {
                if (!is_numeric($MovedCharArray[$key])) {
                    $MovedCharArray[$key] = $Chars[$MovedCharArray[$key]];
                }
                $NewString .= $MovedCharArray[$key];
            }
            if (bcmod($NewString, '97') == 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    /**
     * Validates that a string is an email
     * @param string $mail
     * @return boolean
     */
    public static function email($mail) {
        return filter_var($mail, FILTER_VALIDATE_EMAIL);
    }
    
    /**
     * That is a valid IP, v4 default
     * @param string $ip
     * @return boolean
     */
    public static function ip($ip, $flags = FILTER_FLAG_IPV4) {
        return filter_var($ip, FILTER_VALIDATE_IP, $flags);
    }
    
    /**
     * Valid URL
     * @param string $url
     * @return boolean
     */
    public static function url($url, $param) {
        $flag = isset($param['flag'])? $param['flag'] : 0;
        return filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED | $flag);
    }
    
    /**
     * Validates that a number is in a minimum and maximum range
     * @param int $value
     * @param array $param min, max
     */
    public static function range($value, $param) {
        $min = isset($param['min']) ? $param['min'] : 0;
        $max = isset($param['max']) ? $param['max'] : 10;
        $int_options = array('options' => array('min_range'=>$min, 'max_range'=>$max));
        return filter_var($value, FILTER_VALIDATE_INT, $int_options);
    }
    
    /**
     * Validates that a number is an integer
     * @param int $check
     * @return boolean
     */
    public static function int($check) {
        return filter_var($check, FILTER_VALIDATE_INT);
    }
    
    /**
     * Validates if a decimal number
     * @param string $value
     * @param array $param
     * @return boolean
     */
    public static function decimal($value, $param) {
        $decimal = isset($param['decimal'])? $param['decimal'] : ',';
        return filter_var($value, FILTER_VALIDATE_FLOAT, array('options' => array('decimal' => $decimal)));
    }
    
    /**
     * Validates it a numerical value
     * @param mixed $check
     * @return boolean
     */
    public static function numeric($check) {
        return is_numeric($check);
    }
    
}