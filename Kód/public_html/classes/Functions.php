<?php
    class Functions {
        /**
         * Převod SQL data na český formát
         * @param string|$sql_input SQL datum z databáze
         * @param bool|$time Ve výstupu bude i čas
         */
        public static function czDate($sql_input, $time = false) {
            $phpdate = strtotime($sql_input);
            if($time) {
                $mysqldate = date( 'd-m-Y H:i', $phpdate );
            }
            else {
                $mysqldate = date( 'd-m-Y', $phpdate );
            }
            return $mysqldate;
        }

        public static function DateToHtml($sqldate) {
            $phpdate = strtotime($sqldate);
            $html = '<span class="date">';
            $html .= '<span class="text" data-bs-toggle="tooltip" data-bs-placement="top" title="'.date( 'H:i', $phpdate ).'">';
            $html .= date( 'd. m. Y', $phpdate );
            $html .= '</span>';
            $html .= '</span>';
            return $html;
        }
    }