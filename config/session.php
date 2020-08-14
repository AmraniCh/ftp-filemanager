<?php

return [

    /**
     * Specifies a custom session name.
     */
    'name'             => 'FTPAPPSESSID',

    /**
     * If enabled the session cookie wil be accessible only
     * via the Http protocol, this will prevent javascript
     * from accessing the session cookie.
     */
    'cookie_httponly'  => true,

    /**
     * Specifies the session cookie life time in seconds.
     */
    'cookie_lifetime'  => 60 * 15, // 15 minutes

    /**
     * The session cookie path.
     */
    'cookie_path'      => '/',

    /**
     * Specifies whether to use cookies in order to store session id
     * in the browser.
     */
    'use_cookies'      => true,

    /**
     * If enabled the session sent with URLs will not accepted.
     */
    'use_only_cookies' => true,

    /**
     * Disable or enable the URL based session management.
     */
    'use_trans_sid'    => false,

    /**
     * Specifies where the session files will be stored.
     */
    'save_path'        => dirname(__DIR__) . '/storage/sessions',

    /**
     * Whether to send the session cookie only via a secure connection
     * like when using HTTPS protocol.
     */
    'cookie_secure'    => false,

    /**
     * If enabled the uninitialized session ids by the session module will be discarded.
     */
    'use_strict_mode'  => true,
];