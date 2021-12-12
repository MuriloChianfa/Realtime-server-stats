<?php

declare(strict_types=1);

/**
 * Simple shutdown function
 */
function shutdown()
{
    global $argv;
    global $startMicrotime;

    $endMicrotime = round((microtime(true) - $startMicrotime), 2);

    $usedMemory =    round(memory_get_usage(false) / 1024);
    $allocedMemory = round(memory_get_usage(true)  / 1024);

    print("[*] Used memory: {$usedMemory}KB, Alocated memory: {$allocedMemory}KB");
    print("[*] Execution time: {$endMicrotime}, Exiting...");

    exit(0);
}
