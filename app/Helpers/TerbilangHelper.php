<?php

if (!function_exists('terbilang')) {
    function terbilang($angka)
    {
        $angka = abs($angka);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";

        if ($angka < 12) {
            $temp = " " . $huruf[$angka];
        } else if ($angka < 20) {
            $temp = terbilang($angka - 10) . " belas";
        } else if ($angka < 100) {
            $temp = terbilang($angka / 10) . " puluh" . terbilang($angka % 10);
        } else if ($angka < 200) {
            $temp = " seratus" . terbilang($angka - 100);
        } else if ($angka < 1000) {
            $temp = terbilang($angka / 100) . " ratus" . terbilang($angka % 100);
        } else if ($angka < 2000) {
            $temp = " seribu" . terbilang($angka - 1000);
        } else if ($angka < 1000000) {
            $temp = terbilang($angka / 1000) . " ribu" . terbilang($angka % 1000);
        } else if ($angka < 1000000000) {
            $temp = terbilang($angka / 1000000) . " juta" . terbilang($angka % 1000000);
        } else if ($angka < 1000000000000) {
            $temp = terbilang($angka / 1000000000) . " milyar" . terbilang($angka % 1000000000);
        } else if ($angka < 1000000000000000) {
            $temp = terbilang($angka / 1000000000000) . " triliun" . terbilang($angka % 1000000000000);
        }

        return $temp;
    }
}