<?php

namespace App\Mcp\Tools;

use Generator;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\Title;
use Laravel\Mcp\Server\Tools\ToolInputSchema;
use Laravel\Mcp\Server\Tools\ToolResult;

#[Title('Plan Tool')]
class PlanTool extends Tool
{
    /**
     * A description of the tool.
     */
    public function description(): string
    {
        return 'A description of what this tool does.';
    }

    /**
     * The input schema of the tool.
     */
    public function schema(ToolInputSchema $schema): ToolInputSchema
    {
        $schema->string('example')
            ->description('An example input description.')
            ->required();

        return $schema;
    }

    /**
     * Execute the tool call.
     *
     * @return ToolResult|Generator
     */
    public function handle(array $arguments): ToolResult|Generator
    {
        // Implement tool logic here

        return ToolResult::text('Tool executed successfully.');
    }
}
