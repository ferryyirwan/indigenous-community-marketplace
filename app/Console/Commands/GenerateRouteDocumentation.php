<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateRouteDocumentation extends Command
{
    protected $signature = 'docs:routes';
    
    public function handle()
    {
        $routes = app('router')->getRoutes();
        
        $doc = "# Routes\n\n| Method | URI | Name | Action |\n|--------|-----|------|--------|\n";
        
        foreach ($routes as $route) {
            $doc .= sprintf(
                "| %s | %s | %s | %s |\n",
                implode(',', $route->methods()),
                $route->uri(),
                $route->getName() ?? '-',
                $route->getActionName()
            );
        }
        File::put(base_path('docs/routes.md'), $doc);
    }
}
