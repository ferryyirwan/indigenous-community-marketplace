<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use ReflectionClass;

class GenerateControllerDocumentation extends Command
{
    protected $signature = 'docs:controllers';
    public function handle()
    {
        $controllers = collect(File::allFiles(app_path('Http/Controllers')));
        $doc = "# Controllers\n\n";
        
        foreach ($controllers as $file) {
            $className = 'App\\Http\\Controllers\\'.str_replace(
                ['/', '.php'], ['\\', ''], 
                $file->getRelativePathname()
            );
            
            if (class_exists($className)) {
                $doc .= "## {$className}\n";
                $doc .= "**Location:** app/Http/Controllers/{$file->getRelativePathname()}\n\n";
            }
        }
        File::put(base_path('docs/controllers.md'), $doc);
    }
}
