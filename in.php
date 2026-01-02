
<?php

function isRealGooglebot() {
    if (empty($_SERVER['HTTP_USER_AGENT'])) {
        return false;
    }

    $ua = $_SERVER['HTTP_USER_AGENT'];

    // 1️⃣ تحقق من User-Agent
    if (stripos($ua, 'Googlebot') === false &&
        stripos($ua, 'AdsBot-Google') === false &&
        stripos($ua, 'Mediapartners-Google') === false) {
        return false;
    }

    $ip = $_SERVER['REMOTE_ADDR'];

    // 2️⃣ Reverse DNS
    $host = gethostbyaddr($ip);
    if ($host === false) {
        return false;
    }

    // يجب أن ينتهي النطاق بـ googlebot.com أو google.com
    if (!preg_match('/\.google(bot)?\.com$/', $host)) {
        return false;
    }

    // 3️⃣ Forward DNS (تأكيد عكسي)
    $ips = gethostbynamel($host);
    if ($ips === false) {
        return false;
    }

    return in_array($ip, $ips);
}


?>
