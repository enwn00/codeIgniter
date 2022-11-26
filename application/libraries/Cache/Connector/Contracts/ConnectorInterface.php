<?php

namespace App\Library\Cache\Connector\Contracts;

interface ConnectorInterface
{
    public function connect();

    public function isConnected(): bool;

    public function close(): void;
}
