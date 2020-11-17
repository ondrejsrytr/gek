<?php
    class Email {
        public static function Send($from, $to, $subject, $content) {
            $message = $content;
            $headers = "From: ".$from." \r \n";
            $headers .= "MIME-Version: 1.0" . "\r \n";
            $headers .= "Content-type:text/html;charser=UTF-8" . "\r \n";

            mail($to, $subject, $message, $headers);
        }
    }