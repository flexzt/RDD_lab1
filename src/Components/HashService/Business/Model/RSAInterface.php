<?php

namespace RDD\Lab1\Components\HashService\Business\Model;

interface RSAInterface
{
    public function encrypt($m, $e, $n, $s = 3);

    public function decrypt($c, $d, $n);

    public function sign($message, $d, $n);

    public function prove($message, $signature, $e, $n);

    public function signFile($file, $d, $n);

    public function proveFile($file, $signature, $e, $n);

    public function generate_keys($p, $q, $show_debug = 0);
}
