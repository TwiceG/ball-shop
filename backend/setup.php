<?php

exec('composer install');
// Run migration
exec('php artisan migrate', $migrationOutput, $migrationExitCode);

if ($migrationExitCode !== 0) {
    // Migration failed, run forced migration
    exec('php artisan migrate --force', $forcedMigrationOutput, $forcedMigrationExitCode);

    if ($forcedMigrationExitCode !== 0) {
        echo "Migration failed. Unable to run forced migration.\n";
        exit(1);
    }

    echo "Forced migration completed.\n";
} else {
    echo "Migration completed.\n";
}

exec('php artisan db:seed');
echo('Tables Seeded with data!');



