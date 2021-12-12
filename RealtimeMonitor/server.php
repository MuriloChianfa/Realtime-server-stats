<?php

declare(strict_types=1);

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

/* Remove the execution time limit */
set_time_limit(0); 

/* Set default time to UTC */
date_default_timezone_set('UTC');

$startMicrotime = microtime(true);

require_once __DIR__ . '/vendor/autoload.php';

use Swoole\WebSocket\Server;
use Swoole\WebSocket\Frame;
use Swoole\Http\Request;

use Source\Core\ServerMonitor;

$server = new Server(SERVER_HOST, SERVER_PORT);

$server->on('Start', function(Server $server)
{
    echo 'Swoole WebSocket Server started at ' . SERVER_HOST . ':' . SERVER_PORT . PHP_EOL;
});

$server->on('Open', function(Server $server, Swoole\Http\Request $request) {
    echo "Connection open: {$request->fd}" . PHP_EOL;

    $data = [
        'cpu' => 0,
        'disk' => 0,
        'mem' => [
            'total' => 0,
            'used' => 0,
            'free' => 0,
            'percent' => 0,
        ]
    ];

    $server->push($request->fd, json_encode($data));
});

$server->tick(1000, function() use ($server)
{
    if (empty($server->connections)) {
        echo 'Empty connections...' . PHP_EOL;
        return;
    }

    $mem = ServerMonitor::getMemory();

    $data = [
        'cpu' => ServerMonitor::getServerLoad(),
        'disk' => (ServerMonitor::getDisk())->percent,
        'mem' => [
            'total' => $mem->memTotalBytes,
            'used' => $mem->memUsedBytes,
            'free' => $mem->memFreeBytes,
            'percent' => $mem->percent,
        ]
    ];

    /*
     * Loop through all the WebSocket connections to
     * send back a response to all clients. Broadcast
     * a message back to every WebSocket client.
     */
    foreach($server->connections as $fd) {
        // Validate a correct WebSocket connection otherwise a push may fail
        if ($server->isEstablished($fd) === false) {
            echo "WebSocket connection from {$fd} is NOT valid..." . PHP_EOL;
    
            // 1015 = Bad TLS handshake, disconnect the client
            $server->disconnect($fd, 1015, 'Bad TLS handshake');
            return;
        }

        $server->push($fd, json_encode($data));
    }
});

$server->on('Message', function(Server $server, Frame $frame) {
    echo "Received message: {$frame->data}" . PHP_EOL;
});

$server->on('Close', function(Server $server, int $fd) {
    echo "Connection close: {$fd}" . PHP_EOL;
});

$server->on('Disconnect', function(Server $server, int $fd) {
    echo "Connection disconnect: {$fd}" . PHP_EOL;
});

$server->start();

