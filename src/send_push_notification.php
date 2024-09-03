<?php
require __DIR__ . '/../vendor/autoload.php';
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;
// here I'll get the subscription endpoint in the POST parameters
// but in reality, you'll get this information in your database
// because you already steored it (cf. push_subscription.php)
$subscription = Subscription::create(json_decode(file_get_contents('php://input'), true));
// VAPID key generator https://vapidkeys.com/
$auth = array(
    'VAPID' => array(
        'subject' => 'mailto: <k.kravchenko.inits@gmail.com>',
        'publicKey' => 'BHDkMhnYCY9TsSO_EjvuHUxT4fuvKpUIQrGaH0jvPX4znJktW5mCXbCINsNkC-zgyiilEFxjSZCl_v8v-aBLG44', // don't forget that your public key also lives in app.js
        'privateKey' => 'eNcGizSgZAUNCGxyhe6VGHm2pOnlv-8w4WMoJAkUu5M', // in the real world, this would be in a secret file
    ),
);

$webPush = new WebPush($auth);

$report = $webPush->sendOneNotification(
    $subscription,
    '{"message":"Hello! 👋"}',
);

// handle eventual errors here, and remove the subscription from your server if it is expired
$endpoint = $report->getRequest()->getUri()->__toString();

if ($report->isSuccess()) {
    echo "[v] Message sent successfully for subscription {$endpoint}.";
} else {
    echo "[x] Message failed to sent for subscription {$endpoint}: {$report->getReason()}";
}
