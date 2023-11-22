<?php

namespace App\Marketplace\Payment;


use App\Marketplace\Utility\RPCWrapper;
use App\Marketplace\Utility\RtmConverter;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class RtmPayment implements Coin
{

    /**
     * RPCWrapper Server instance
     *
     * @var
     */
    protected $raptoreumd;

    /**
     * RPCWrapper constructor.
     */
    public function __construct()
    {
        $this -> raptoreumd = new RPCWrapper(config('coins.rtm.username'),
            config('coins.rtm.password'),
            config('coins.rtm.host'),
            config('coins.rtm.port'));
    }

    /**
     * Generate new address with optional rtm user parameter
     *
     * @param array $params
     * @return string
     * @throws \Exception
     */
    function generateAddress(array $params = []): string
    {
        // only if the rtm user is set then call with parameter
        if(array_key_exists('rtm_user', $params))
            $address = $this -> raptoreumd -> getnewaddress($params['rtm_user']);
        else
            $address = $this -> raptoreumd -> getnewaddress();

        // Error in rtm
        if($this -> raptoreumd -> error)

            throw new \Exception($this -> raptoreumd -> error);

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
            $accountBalance = $this -> raptoreumd -> getreceivedbyaddress($params['address'], (int)config('marketplace.rtm.minconfirmations'));
//        else if(array_key_exists('account', $params))
//            // fetch the balance of the account if this parameter is set
//            $accountBalance = $this -> raptoreumd -> getbalance($params['account'], (int)config('marketplace.rtm.minconfirmations'));
        else
            throw new \Exception('You havent specified any parameter');

        if($this -> raptoreumd -> error)
            throw new \Exception($this -> raptoreumd -> error);

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
        // call raptoreumd procedure
        $this -> raptoreumd -> sendtoaddress($toAddress, $amount);

        if($this -> raptoreumd -> error)
            throw new \Exception("Sending to $toAddress amount $amount \n" . $this -> raptoreumd -> error);

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
//            $this -> raptoreumd -> sendtoaddress($address, $amount);
//        }

        $this->raptoreumd->sendmany("", $addressesAmounts, (int)config('marketplace.rtm.minconfirmations'));


        if ($this->raptoreumd->error) {
            $errorString = "";
            foreach ($addressesAmounts as $address => $amount){
                $errorString .= "To $address : $amount \n";
            }
            throw new \Exception( $this->raptoreumd->error . "\nSending to: $errorString" );
        }
    }
    /**
     * Convert USD to equivalent RTM amount, rounded on 8 decimals
     *
     * @param $usd
     * @return float
     */
    function usdToCoin($usd): float
    {
        return round( RtmConverter::usdToRtm($usd), 8, PHP_ROUND_HALF_DOWN );
    }


    /**
     * Returns the string label of the coin
     *
     * @return string
     */
    function coinLabel(): string
    {
        return 'rtm';
    }


}