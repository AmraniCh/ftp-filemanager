<?php

return [

    /**
     * If the debug mode enabled all exception and errors will be shows to
     * the end user, if disabled the errors will be logged to the logs
     * file.
     */
    'debug' => true,

    /**
     * Ftp configs.
     */
    'ftp'   => [

        /**
         * Specify the FTP connection timeout in seconds.
         */
        'timeout' => 90,

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