<?php
declare(strict_types=1);
namespace LaravelCompany\Mail;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use RuntimeException;

class UpgradeMigration extends Migration
{
    protected function getTableName(string $baseName): string
    {
        if (Schema::hasTable("laravel_mail_{$baseName}")) {
            return "laravel_mail_{$baseName}";
        }

        if (Schema::hasTable($baseName)) {
            return $baseName;
        }

        throw new RuntimeException('Could not find appropriate table for base name ' . $baseName);
    }
}
