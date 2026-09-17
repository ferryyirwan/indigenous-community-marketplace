<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use ReflectionClass;
use Illuminate\Database\Eloquent\Model;
use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Types\Type;

class GenerateModelDocumentation extends Command
{
    protected $signature = 'docs:models';
    protected $description = 'Generate comprehensive model documentation with schema details';

    public function handle()
    {
        // Verify Doctrine DBAL is installed
        if (!class_exists(\Doctrine\DBAL\Schema\Column::class)) {
            $this->error('Doctrine DBAL is required. Install with: composer require doctrine/dbal');
            return 1;
        }
        $modelsPath = app_path('Models');
        
        if (!File::exists($modelsPath)) {
            $this->error("Models directory not found at: {$modelsPath}");
            return 1;
        }
        $models = collect(File::allFiles($modelsPath))
            ->filter(fn($file) => str_ends_with($file, '.php'));

        if ($models->isEmpty()) {
            $this->warn("No model files found in: {$modelsPath}");
            return 0;
        }

        $doc = "# Laravel Models Documentation\n\n";
        $doc .= "Generated on: " . now()->toDateTimeString() . "\n\n";

        foreach ($models as $file) {
            $className = 'App\\Models\\'.str_replace(
                ['/', '.php'], 
                ['\\', ''], 
                $file->getRelativePathname()
            );
            
            if (!class_exists($className) || !is_subclass_of($className, Model::class)) {
                continue;
            }

            $doc .= $this->documentModel($className);
        }

        File::ensureDirectoryExists(base_path('docs'));
        File::put(base_path('docs/models.md'), $doc);
        $this->info('Model documentation generated at docs/models.md');
        return 0;
    }

    protected function documentModel(string $className): string
    {
        $reflection = new ReflectionClass($className);
        $model = app($className);
        $table = $model->getTable();
        $connection = $model->getConnection();

        try {
            $schema = $connection->getDoctrineSchemaManager();
            $columns = $schema->listTableColumns($table);
            $indexes = $schema->listTableIndexes($table);
        } catch (\Exception $e) {
            $this->error("Could not read schema for table {$table}: " . $e->getMessage());
            return "";
        }

        $output = "## " . $reflection->getShortName() . "\n\n";
        $output .= "**Table:** `{$table}`\n\n";
        $output .= "**Primary Key:** `{$model->getKeyName()}`\n\n";

        // Fields documentation
        $output .= "### Database Columns\n";
        $output .= "| Column | Type | Nullable | Default | Attributes | Description |\n";
        $output .= "|--------|------|----------|---------|------------|-------------|\n";

        foreach ($columns as $column) {
            /** @var Column $column */
            $name = $column->getName();
            $type = $column->getType()->getName();
            $nullable = $column->getNotnull() ? 'NO' : 'YES';
            $default = $this->formatDefaultValue($column->getDefault());
            $attributes = $this->getColumnAttributes($column);
            
            $output .= sprintf(
                "| `%s` | %s | %s | %s | %s | [Description] |\n",
                $name,
                $type,
                $nullable,
                $default,
                implode(', ', $attributes)
            );
        }

$output .= "\n";

        // Indexes and Foreign Keys
        $output .= "### Indexes & Constraints\n";
        foreach ($indexes as $index) {
            $columns = implode(', ', $index->getColumns());
            if ($index->isPrimary()) {
                $output .= "- **PRIMARY KEY** (`{$columns}`)\n";
            } elseif ($index->isUnique()) {
                $output .= "- **UNIQUE** (`{$columns}`)\n";
            } elseif ($index->hasFlag('foreign')) {
                $output .= "- **FOREIGN KEY** (`{$columns}`) REFERENCES {$index->getForeignTableName()}({$index->getForeignColumns()[0]})\n";
            } else {
                $output .= "- **INDEX** (`{$columns}`)\n";
            }
        }
        $output .= "\n";

        // Relationships
        $output .= "### Eloquent Relationships\n";
        $methods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
        
        foreach ($methods as $method) {
            if ($method->getNumberOfParameters() > 0 || $method->class !== $className) {
                continue;
            }

            try {
                $return = $method->getReturnType();
                if (!$return || !str_contains($return, 'Illuminate\Database\Eloquent\Relations')) {
                    continue;
                }

                $relation = $model->{$method->name}();
                $output .= "- `{$method->name}()`: " . class_basename($relation);
 
                // Add foreign key info if available
                if (method_exists($relation, 'getForeignKeyName')) {
                    $output .= " (Foreign Key: `{$relation->getForeignKeyName()}`)";
                }
                
                $output .= "\n";

            } catch (\Exception $e) {
                // Skip if relationship can't be resolved
                continue;
            }
        }
        // Model properties
         if (property_exists($model, 'fillable') || property_exists($model, 'casts')) {
            $output .= "\n### Model Properties\n";
            
            if (property_exists($model, 'fillable')) {
                $output .= "**Fillable Attributes:**\n";
                foreach ($model->getFillable() as $field) {
                    $output .= "- `{$field}`\n";
                }
                $output .= "\n";
            }
            
            if (property_exists($model, 'casts')) {
                $output .= "**Attribute Casts:**\n";
                foreach ($model->getCasts() as $field => $type) {
                    $output .= "- `{$field}` => `{$type}`\n";
                }
                $output .= "\n";
            }
        }
        $output .= "\n---\n\n";
        return $output;
    }

    protected function formatDefaultValue($value): string
    {
        if ($value === null) return 'NULL';
        if ($value === '') return "''";
        if (is_bool($value)) return $value ? 'true' : 'false';
        return (string)$value;
    }

    protected function getColumnAttributes(Column $column): array
    {
        $attributes = [];
        
        if ($column->getAutoincrement()) {
            $attributes[] = 'AUTO_INCREMENT';
        }
        if ($column->getUnsigned()) {
            $attributes[] = 'UNSIGNED';
        }
        if ($column->getComment()) {
            $attributes[] = 'COMMENT: ' . $column->getComment();
        }
        return $attributes;
    }
}

