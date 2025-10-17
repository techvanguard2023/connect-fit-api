<?php

namespace App\Mcp\Servers;

use Laravel\Mcp\Server;
use App\Mcp\Tools\PlanTool;
use App\Mcp\Resources\PlanResource;



class ConnectFitServer extends Server
{
    public string $serverName = 'Connect Fit Server';

    public string $serverVersion = '0.0.1';

    public string $instructions = 'Example instructions for LLMs connecting to this MCP server.';

    public array $tools = [
        PlanTool::class,
    ];

    public array $resources = [
        PlanResource::class,
    ];

    public array $prompts = [
        // ExamplePrompt::class,
    ];
}
