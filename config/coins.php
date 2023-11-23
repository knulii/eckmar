<?php

return [

    /**
     * List of coins supported by this market
     * Mapped in the implementations
     *
     * 'btc' => RPCWrapper
     * 'xmr' => Monero
     * 'yerb' => Yerbas
     */
    'coin_list' => [
//          'btc' => \App\Marketplace\Payment\BitcoinPayment::class,
//       'btcm' => \App\Marketplace\Payment\BitcoinMutlisig::class, // bitcoin multisig
          'xmr' => \App\Marketplace\Payment\MoneroPayment::class,
          'yerb' => \App\Marketplace\Payment\YerbPayment::class,
//          'ltc' => \App\Marketplace\Payment\LitecoinPayment::class,
          'rtm' => \App\Marketplace\Payment\RtmPayment::class,
//        'dash' => \App\Marketplace\Payment\DashPayment::class,
    ],

    /**
     * RPCWrapper settings
     *
     * Uses data from .env file
     */
    'bitcoin' => [
        'host' => env('BITCOIND_HOST', 'localhost'),
        'username' => env('BITCOIND_USERNAME', 'myuser'),
        'password' => env('BITCOIND_PASSWORD', 'mypassword'),
        'port' => env('BITCOIND_PORT', 18332),
        'minconfirmations' => env('BITCOIND_MINCONFIRMATIONS', 1),
    ],

    /**
     * Monero settings
     *
     * Uses data from .env file
     */

     'monero' => [
        'host' => env('MONERO_HOST','127.0.0.1'),
        'port' => intval(env('MONERO_PORT',18083)),
        'username' => env('MONERO_USERNAME','username'),
        'password' => env('MONERO_PASSWORD','password')
    ],

    /**
     * YERB settings
     */
    'yerb' => [
        'host' => env('YERB_HOST','127.0.0.1'),
        'port' => intval(env('YERB_PORT',15419)),
        'username' => env('YERB_USERNAME','username'),
        'password' => env('YERB_PASSWORD','password')
    ],

    /**
     * Litecoin settings
     */
    'litecoin' => [
        'host' => env('LITECOIN_HOST','127.0.0.1'),
        'port' => intval(env('LITECOIN_PORT',19332)),
        'username' => env('LITECOIN_USERNAME','myuser'),
        'password' => env('LITECOIN_PASSWORD','mypassword')
    ],

    /**
     * DASH settings
     */
    'dash' => [
        'host' => env('DASH_HOST','127.0.0.1'),
        'port' => intval(env('DASH_PORT',19998)),
        'username' => env('DASH_USERNAME','myuser'),
        'password' => env('DASH_PASSWORD','mypassword')
    ],

    /**
     * Raptoreum settings
     */
    'rtm' => [
        'host' => env('RTM_HOST','127.0.0.1'),
        'port' => intval(env('RTM_PORT',8001)),
        'username' => env('RTM_USERNAME','username'),
        'password' => env('RTM_PASSWORD','password')
    ],

    /**
     * VergeCurrency settings
     */
    'xvg' => [
        'host' => env('VERGE_HOST','127.0.0.1'),
        'port' => intval(env('VERGE_PORT',21102)),
        'username' => env('VERGE_USERNAME','myuser'),
        'password' => env('VERGE_PASSWORD','mypassword')
    ],

    /**
     * Refreshing cache for RPCWrapper price loading
     */
    'caching_price_interval' => 20,

    /**
     * Leave empty array if you want to keep the funds on the purchase addresses
     *
     * Market addresses, funds from fee will be sent to one random address from this array
     */
    'market_addresses' => [
        'btc' => [ // list of btc addresses
            '02a017c9869f8378303f02310b9b719e6cb6bea37f87f95d89e187546d09b22b1c'
        ],
        'yerb' => [ // list of pivx addresses
            'yaDfcdCupB1T5YoVRjYr8fXCvB8U5AuNX8'
        ],
        'dash' => [
            'yQgr9ix7L7JuA5NeZdj3yux7sNXCX3H843'
        ],
        'rtm' => [
            'yQgr9ix7L7JuA5NeZdj3yux7sNXCX3H843'
        ],
        'ltc' => [
            'yQgr9ix7L7JuA5NeZdj3yux7sNXCX3H843'
        ],
    ],
    'multisig' => [
        'balance_api' => 'https://testnet.blockchain.info/balance?active=',
        'unspent_api' => 'https://testnet.blockchain.info/unspent?active=',
    ],
];