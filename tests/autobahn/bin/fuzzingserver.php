<?php
use helpers\Ratchet\Mock\Connection;
use Ratchet\WebSocket\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\WebSocket\WsServer;
use Ratchet\http\HttpServer;
use Ratchet\Server\IoServer;

require dirname(dirname(dirname(__DIR__))) . '/vendor/autoload.php';

class BinaryEcho implements MessageComponentInterface{
    public function onMessage(ConnectionInterface $conn, MessageInterface $msg) {
        $conn->send($msg);
    }

    public function onOpen(ConnectionInterface $conn) {
    }

    public function onClose(ConnectionInterface $conn) {
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
    }
}

    $port = $argc > 1 ? $argv[1] : 8000;
    $impl = sprintf('React\EventLoop\%sLoop', $argc > 2 ? $argv[2] : 'StreamSelect');

    $loop = new $impl;
    $sock = new React\Socket\SocketServer('0.0.0.0:' . $port, $loop);

    $wsServer = new WsServer(new BinaryEcho);
    // This is enabled to test https://github.com/ratchetphp/Ratchet/issues/430
    // The time is left at 10 minutes so that it will not try to every ping anything
    // This causes the Ratchet server to crash on test 2.7
    $wsServer->enableKeepAlive($loop, 600);

    $app = new HttpServer($wsServer);

    $server = new IoServer($app, $sock, $loop);
    $server->run();
