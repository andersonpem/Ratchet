<?php
namespace helpers\Ratchet\WebSocket\Stub;
use helpers\Ratchet\MessageComponentInterface;
use helpers\Ratchet\WebSocket\WsServerInterface;

interface WsMessageComponentInterface extends MessageComponentInterface, WsServerInterface {
}
