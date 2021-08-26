<?php

namespace Academy\SuperDuperModule\Plugin;


use Academy\SuperDuperModule\Console\WriteHelloWorld;
use function GuzzleHttp\Psr7\str;

class ExpandWriteHelloWorld
{


    public function beforeTest(WriteHelloWorld $subject, string $test)
    {
        echo "Before\n";

        return ['changed TEXT'];
    }

    public function aroundTest(WriteHelloWorld $subject, callable $proceed, string $test)
    {
        $test = 'text changed again';

        echo "Around before\n";

        $result = $proceed($test);

        echo "Around after\n";

        return $result;
    }

    public function afterTest(WriteHelloWorld $subject, string $result, string $test)
    {
        echo "After\n";

        return $result;
    }
}
