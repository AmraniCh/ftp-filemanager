<?php

return [

    /**
     * If the debug mode enabled all exception and errors will be shows to
     * the end user, if disabled the errors will be logged to the logs
     * file.
     */
    'debug' => true,

    /**
     * The inactivity timeout in minutes.
     */
    'inactivityTimeout' => 1,

    /**
     * Ftp configs.
     */
    'ftp' => [

        /**
         * Specify the FTP connection timeout in seconds.
         */
        'timeout' => 90,

        /**
         * Enable auto seeking for transfer resuming operations.
         */
        'autoSeek'     => true,

        /**
         * Specifies whether to resume the upload operations in the server or start
         * the uploading from the beginning.
         *
         * note: in order for this option to work properly the autoSeek option must be enabled.
         */
        'resumeUpload' => true,
    ],
];