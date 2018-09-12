<?php
/**
 * Created by PhpStorm.
 * User: toddroper
 * Date: 9/11/18
 * Time: 6:00 AM
 */

class ThemeHelper
{
    /**
     * @description Special helper to trim strings and prevent special characters breaking string.
     * @param string | $string | The string that needs to be trimmed.
     * @param integer | $limit | The trim limit for the string.
     * @return string | Returns the trimmed string for display.
     */
    public static function cleanTrim($string, $limit)
    {
        $words = explode(" ", $string);
        $stringBuilder = array();

        $chars = 0;
        foreach ($words as $word)
        {
            $chunkSize = strlen($word);

            if($chars < $limit && ($chars + $chunkSize + 1) <= $limit)
            {
                $stringBuilder[] = $word;
                // Add chunk size plus 1 to chars. (The one is for the space.)
                $chars += ($chunkSize + 1);
            }else{
                // If we're over the limit, trim the last word and break the loop.
                $stringBuilder[] = self::trimWord($word, ($limit - $chars));
                break;
            }
        }

        return implode(" ", $stringBuilder) . "...";
    }


    /**
     * @description Method trims word and validates output to prevent special character breaks due to encoding issues.
     * @param string | $word | The word to trim.
     * @param integer | $length | The length the word needs to be trimmed to.
     * @return string | Returns the trimmed word without special characters.
     */
    public static function trimWord($word, $length)
    {
        $out = '';
        $count = 0;
        do {
            // Only append the last char if it is an alpha character to prevent garbled return.
            if($count === $length && !preg_match("/[A-Za-z]/", $word[$count])) break;

            // Only append alpha numeric chars here because special characters break due to encoding.
            $out .= (preg_match("/[A-Za-z\d]/", $word[$count])) ? $word[$count] : '';
            $count++;
        } while ($count <= $length);

        return $out;
    }
}