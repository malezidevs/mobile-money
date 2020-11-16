<?php
return [
    'sandbox' => true,
    'c2b' => [
        'consumer_key' => 'Ei4lr5xbDZXS9XEAZ1BhNE4xCBcAYGVy',
        'consumer_secret' => 'eMhCDmzFQyx1SNSZ',
        'initiator' => 'testapi',
        'stk_callback' => env('APP_URL') . '/payments/callbacks/stk_callback',
        'id_validation_callback' => env('APP_URL') . '/payments/callbacks/validate',
        'callback_method' => 'POST',
        'short_code' => 600152,
        'till_number' => 174379,
        'passkey' => 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919',
        'security_credential' => 'GXiVXirQFaJvEFOQyn+VJ4Gp3Ccvpoq6aqzFiNgvH18UMU59Qxc+UTAX7Blzo6L0+tQG2wUJ1fKH4YlPagtzDHT37796uu0NysS85uPjxZMjnbGhPNeHnhJLzwyrjppl8mZpnmVg4CaVrEdcriuyifKIiF1hmc0A/RnjBMzY6yevbIV0kAgrn5cDvCN99O1rr1nl69GaVbP7a/6AWnRkVUldnalQmqQhfgLbOdxjGOVGU2arqjuvgQ6glo1uK9PUnp3UH2Vv66Lu99JglWyjlcWufZhJXUmFFB9tfoKAX2URnPGi4PvvJ6OgJNdsJmTsevnG2c/KKOa45rzdvwrwKA==',
        'timeout_url' => env('APP_URL') . '/payments/callbacks/timeout/',
        'result_url' => env('APP_URL') . '/payments/callbacks/result/',
        'validation_url' => env('APP_URL') . '/payments/callbacks/validate',
        'confirmation_url' => env('APP_URL') . '/payments/callbacks/confirmation',
    ],
    'bulk' => [
        'consumer_key' => 'Ei4lr5xbDZXS9XEAZ1BhNE4xCBcAYGVyA',
        'consumer_secret' => 'eMhCDmzFQyx1SNSZ',
        'short_code' => 600000,
        'security_credential' => 'GXiVXirQFaJvEFOQyn+VJ4Gp3Ccvpoq6aqzFiNgvH18UMU59Qxc+UTAX7Blzo6L0+tQG2wUJ1fKH4YlPagtzDHT37796uu0NysS85uPjxZMjnbGhPNeHnhJLzwyrjppl8mZpnmVg4CaVrEdcriuyifKIiF1hmc0A/RnjBMzY6yevbIV0kAgrn5cDvCN99O1rr1nl69GaVbP7a/6AWnRkVUldnalQmqQhfgLbOdxjGOVGU2arqjuvgQ6glo1uK9PUnp3UH2Vv66Lu99JglWyjlcWufZhJXUmFFB9tfoKAX2URnPGi4PvvJ6OgJNdsJmTsevnG2c/KKOa45rzdvwrwKA==',
        'initiator' => 'testapi',
        'timeout_url' => env('APP_URL') . '/payments/callbacks/timeout/',
        'result_url' => env('APP_URL') . '/payments/callbacks/result/',
    ],
    'notifications' => [
        'slack_web_hook' => 'https://hooks.slack.com/services/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',
        'only_important' => false,
    ],
];
