<?php

use Laravel\Mcp\Server\Facades\Mcp;
use App\Mcp\Servers\ConnectFitServer;

Mcp::web('connect-fit', ConnectFitServer::class);
