<?php


namespace App\Marketplace\Utility;

use Illuminate\Support\Facades\Cache;

/**
 * Class for yerbas convert to usd and backwards
 *
 * Class YerbConverter
 * @package App\Marketplace\Utility
 */
class YerbConverter
{

    /**
     * Returns the float amount of the usd
     *
     * @return float
     */
    public static function usdToYerb(float $amount): float
    {
        $yerbprice = Cache::remember('yerb_price',config('coins.caching_price_interval'),function(){
            // get yerbas price
            $url = "https://api.xeggex.com/api/v2/ticker/YERB_USDT";
            $json = json_decode(file_get_contents($url), true);
            $YERB_USDT = $json["last_price"];

            return $YERB_USDT;
        });
        // calculate yerbass and store
        return $amount / $yerbprice;


    }


    /**
     * Returns amount of yerb converted from usd
     *
     * @param $amount
     * @return float
     */
    public static function yerbToUsd(float $amount) : float
    {
        $yerbprice = Cache::remember('yerb_price',config('coins.caching_price_interval'),function(){
            // get yerbas price
            $url = "https://api.xeggex.com/api/v2/ticker/YERB_USDT";
            $json = json_decode(file_get_contents($url), true);
            $YERB_USDT = $json["last_price"];

            return $YERB_USDT;
        });

        // calculate yerbass and store
        return $amount * $yerbprice;
    }

    public static function satoshiToYerb(int $satoshi) : float
    {
        return $satoshi / 100000000;
    }

}