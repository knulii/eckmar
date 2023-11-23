<?php


namespace App\Marketplace\Utility;

use Illuminate\Support\Facades\Cache;

/**
 * Class for rtm convert to usd and backwards
 *
 * Class Converter
 * @package App\Marketplace\Utility
 */
class RtmConverter
{

    /**
     * Returns the float amount of the usd
     *
     * @return float
     */
    public static function usdToRtm(float $amount): float
    {
        $rtmprice = Cache::remember('rtm_price',config('coins.caching_price_interval'),function(){
            // get rtm price
            $url = "https://api.xeggex.com/api/v2/ticker/RTM_USDT";
            $json = json_decode(file_get_contents($url), true);
            $RTM_USDT = $json["last_price"];

            return $RTM_USDT;
        });
        // calculate rtm and store
        return $amount / $rtmprice;


    }


    /**
     * Returns amount of raptoreum converted from usd
     *
     * @param $amount
     * @return float
     */
    public static function rtmToUsd(float $amount) : float
    {
        $rtmprice = Cache::remember('rtm_price',config('coins.caching_price_interval'),function(){
            // get rtm price
            $url = "https://api.xeggex.com/api/v2/ticker/RTM_USDT";
            $json = json_decode(file_get_contents($url), true);
            $RTM_USDT = $json["last_price"];

            return $RTM_USDT;
        });

        // calculate rtm and store
        return $amount * $rtmprice;
    }

    public static function satoshiToRtm(int $satoshi) : float
    {
        return $satoshi / 100000000;
    }

}