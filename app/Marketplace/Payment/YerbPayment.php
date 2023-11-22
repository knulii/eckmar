<?php

namespace App\Marketplace\Payment;


use App\Marketplace\Utility\RPCWrapper;
use App\Marketplace\Utility\YerbConverter;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class YerbPayment implements Coin
{

    /**
     * RPCWrapper Server instance
     *
     * @var
     */
    protected $yerbasd;

    /**
     * RPCWrapper constructor.
     */
    public function __construct()
    {
        $this -> yerbasd = new RPCWrapper(config('coins.yerb.username'),
            config('coins.yerb.password'),
            config('coins.yerb.host'),
            config('coins.yerb.port'));
    }

    /**
     * Generate new address with optional yerb user parameter
     *
     * @param array $params
     * @return string
     * @throws \Exception
     */
    function generateAddress(array $params = []): string
    {
        // only if the yerb user is set then call with parameter
        if(array_key_exists('yerb_user', $params))
            $address = $this -> yerbasd -> getnewaddress($params['yerb_user']);
        else
            $address = $this -> yerbasd -> getnewaddress();

        // Error in yerbas
        if($this -> yerbasd -> error)

            throw new \Exception($this -> yerbasd -> error);

        return $address;
    }


    /**
     * Returns the total received balance of the account
     *
     * @param array $params
     * @return float
     * @throws \Exception
     */
    function getBalance(array $params = []): float
    {
        // first check by address
        if(array_key_exists('address', $params))
            $accountBalance = $this -> yerbasd -> getreceivedbyaddress($params['address'], (int)config('marketplace.yerbas.minconfirmations'));
//        else if(array_key_exists('account', $params))
//            // fetch the balance of the account if this parameter is set
//            $accountBalance = $this -> yerbasd -> getbalance($params['account'], (int)config('marketplace.yerbas.minconfirmations'));
        else
            throw new \Exception('You havent specified any parameter');

        if($this -> yerbasd -> error)
            throw new \Exception($this -> yerbasd -> error);

        return $accountBalance;
    }

    /**
     * Calls a procedure to send from address to address some amount
     *
     * @param string $fromAddress
     * @param string $toAddress
     * @param float $amount
     * @throws \Exception
     */
    function sendToAddress(string $toAddress, float $amount)
    {
        // call yerbasd procedure
        $this -> yerbasd -> sendtoaddress($toAddress, $amount);

        if($this -> yerbasd -> error)
            throw new \Exception("Sending to $toAddress amount $amount \n" . $this -> yerbasd -> error);

    }

    /**
     * Send to array of addresses
     *
     * @param string $fromAccount
     * @param array $addressesAmounts
     * @throws \Exception
     */
    function sendToMany(array $addressesAmounts)
    {
        // send to many addresses
//        foreach ($addressesAmounts as $address => $amount){
//            $this -> yerbasd -> sendtoaddress($address, $amount);
//        }

        $this->yerbasd->sendmany("", $addressesAmounts, (int)config('marketplace.yerbas.minconfirmations'));


        if ($this->yerbasd->error) {
            $errorString = "";
            foreach ($addressesAmounts as $address => $amount){
                $errorString .= "To $address : $amount \n";
            }
            throw new \Exception( $this->yerbasd->error . "\nSending to: $errorString" );
        }
    }
    /**
     * Convert USD to equivalent YERB amount, rounded on 8 decimals
     *
     * @param $usd
     * @return float
     */
    function usdToCoin($usd): float
    {
        return round( YerbConverter::usdToYerb($usd), 8, PHP_ROUND_HALF_DOWN );
    }


    /**
     * Returns the string label of the coin
     *
     * @return string
     */
    function coinLabel(): string
    {
        return 'yerb';
    }


}