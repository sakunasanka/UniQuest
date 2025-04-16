<?php
    class LogHelper {
        public static function logError($message) {
            error_log("[".date("Y-m-d H:i:s")."] [ERROR] ".$message."\n", 3, ERROR_LOG);
        }

        public static function logMail($message) {
            error_log("[".date("Y-m-d H:i:s")."] [MAIL] ".$message."\n", 3, MAIL_LOG);
        }

        public static function logDebug($message) {
            error_log("[".date("Y-m-d H:i:s")."] [DEBUG] ".$message."\n", 3, DEBUG_LOG);
        }
    }
?>