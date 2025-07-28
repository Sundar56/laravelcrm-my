<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use App\Models\CompanyDatabase;
use App\Models\Company;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class CreateCompanyDatabaseJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;
    protected $companyId;
    protected $companyName;

    /**
     * Create a new job instance.
     */
    public function __construct(int $companyId, string $companyName)
    {
        $this->companyId = $companyId;
        $this->companyName = $companyName;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // set_time_limit(0);
        ini_set('max_execution_time', '1200');     
        ini_set('memory_limit', '2108M');

        // error_log('max_execution_time::' . ini_get('max_execution_time'));
        // error_log('memory_limit::' . ini_get('memory_limit'));
        $companyId   = $this->companyId;
        $companyName = $this->companyName;
        $dbName      = 'comp_' . strtolower($companyName);
        $dbHost      = env("DB_ROOT_HOST");
        $serverIp    = env("SERVER_IP");
        $dbUsername  = $dbHost == 'localhost' ? 'root' : env("DB_ROOT_USERNAME");
        $dbPassword  = $dbHost == 'localhost' ? null : env("DB_ROOT_PASSWORD");

        error_log('companyId::' . $companyId);
        error_log('dbPassword' . $dbPassword);
        //store company database details
        CompanyDatabase::create([
            'company_id'  => $companyId,
            'db_name'     => $dbName,
            'dbuser_name' => $dbUsername,
            'db_password' => $dbPassword,
            'collation'   => '',
        ]);
        error_log('company database created');
        $host = $dbHost == $serverIp ? 'localhost' : '%';
        $createUserQuery = "CREATE USER IF NOT EXISTS '$dbUsername'@'$host' IDENTIFIED BY '$dbPassword'";
        error_log('createuserQuery::' . $createUserQuery);
        error_log('dbname::' . $dbName);

        $createDatabase = "CREATE DATABASE IF NOT EXISTS `$dbName`";
        error_log('createDatabase::' . $createDatabase);

        DB::connection('mysql_root')->statement($createDatabase);
        $privileges = "GRANT ALL PRIVILEGES ON `$dbName`.* TO '$dbUsername'@'$host' WITH GRANT OPTION";
        // Set the dynamic database connection
        $this->setDynamicDatabaseConnection($dbName, $dbUsername, $dbPassword);

        //Test Database connection
        try {
            DB::connection($dbName)->getPdo();
            error_log('Successfully connected to the databas::' . $dbName);
        } catch (\Exception $e) {
            error_log('MySQL connection failed::' . $e->getMessage());
            return; // Stop execution
        }
        error_log('Migration started at: ' . now());
        // Run migrations with progress bar
        $this->runMigrations($dbName);
        error_log('Migration ended at: ' . now());

        error_log('Start console for cloud_variabler' . now());
        Artisan::call('app:populate-general-settings', [
            'companydbname' => $dbName
        ]);
        error_log('End console for cloud_variabler' . now());

        error_log('Start console command for cloud_sso_users' . now());
        Artisan::call('insert:users', [
            'company_id' => $companyId
        ]);
        error_log('End console command for cloud_sso_users' . now());
        error_log('Users inserted for company ' . $companyName);

        error_log('Files & Folders Transfer started at: ' . now());
        $this->copyCompanyFiles($companyName);
        error_log('Files & Folders Transfer ended at: ' . now());

        Company::where('id', $companyId)->update(['lastfile_updated_at' => now()]);
    }
    public function runMigrations(string $dbName): void
    {
        // set_time_limit(0);
        // Get the migration files from the path
        $migrationsPath = database_path('migrations/companymigrations');
        $migrationFiles = File::files($migrationsPath);

        // Total number of migrations
        $totalMigrations = count($migrationFiles);
        error_log("Starting migrations... Total migrations: $totalMigrations");

        // Initialize the console output and progress bar
        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output, $totalMigrations);

        // Start the progress bar
        $progressBar->start();

        // Iterate over each migration file and apply it
        foreach ($migrationFiles as $migration) {
            $migrationName = pathinfo($migration)['basename'];
            // Run each migration manually
            $exitCode = Artisan::call('migrate', [
                '--database' => $dbName,
                '--path' => "database/migrations/companymigrations/{$migrationName}",
            ]);
            // Log progress after each migration
            $progressBar->advance();
            // You can also log any errors or exit code for each migration
            if ($exitCode !== 0) {
                error_log("Migrations failed:. $migrationName");
            }
        }
        // Finish the progress bar
        $progressBar->finish();
        error_log("Migrations completed!");
    }
    public function setDynamicDatabaseConnection($dbName, $dbUsername, $dbPassword)
    {
        config([
            "database.connections.$dbName" => [
                'driver' => 'mysql',
                'host' => env('DB_ROOT_HOST', '127.0.0.1'),
                'port' => env('DB_ROOT_PORT', '3306'),
                'database' => $dbName,
                'username' => $dbUsername,
                'password' => $dbPassword,
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix' => '',
                'strict' => true,
                'engine' => null,
            ]
        ]);
    }
    public function copyCompanyFiles($companyName)
    {
        $companyFolderPath = env("COMPANY_FOLDER_CREATION");
        error_log('Folderpath::' . $companyFolderPath);
        $folderPath = $companyFolderPath . DIRECTORY_SEPARATOR . $companyName;
        $sourcePath = 'D:\sundar\crmcompanies\basesetup';
        // $sourcePath = '/home/sns-centos9/webroot/crmcompanies/basesetup';

        if (!file_exists($folderPath)) {
            if (mkdir($folderPath, 0755, true)) {
                error_log('Created directory::' . $folderPath);
            } else {
                error_log('Failed to create directory::' . $folderPath);
                return; // Exit if directory creation fails
            }
        } else {
            error_log('Directory already exists::' . $folderPath);
        }
        // Define the paths for cloudcrm and cloud-router-profile directories
        $cloudCrmFolderPath = $folderPath . DIRECTORY_SEPARATOR . 'cloudcrm' . DIRECTORY_SEPARATOR . 'Config';
        $cloudRouterProfileFolderPath = $folderPath . DIRECTORY_SEPARATOR . 'cloud-router-profile' . DIRECTORY_SEPARATOR . 'Config';

        // Ensure the cloudcrm\Config and cloud-router-profile\Config directories exist and create apiconfig.php
        $this->createDirectoryIfNotExists($cloudCrmFolderPath);
        $this->createDirectoryIfNotExists($cloudRouterProfileFolderPath);

        // Create apiconfig.php file inside each Config folder
        $this->createApiConfigFile($cloudCrmFolderPath . DIRECTORY_SEPARATOR . 'apiconfig.php');
        $this->createApiConfigFile($cloudRouterProfileFolderPath . DIRECTORY_SEPARATOR . 'apiconfig.php');

        // Copy files and folders from the source path to the new folder
        try {
            $this->copyDirectory($sourcePath, $folderPath);
            error_log('Files and folders copied from::' . $sourcePath . " to " . $folderPath);
        } catch (\Exception $e) {
            error_log('Failed to copy files and folders::' . $e->getMessage());
        }
    }
    private function copyDirectory($source, $destination)
    {
        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }
        $items = scandir($source);
        foreach ($items as $item) {
            if ($item == '.' || $item == '..') continue;
            $sourcePath = $source . DIRECTORY_SEPARATOR . $item;
            $destinationPath = $destination . DIRECTORY_SEPARATOR . $item;

            if (is_dir($sourcePath)) {
                // If the item is a directory, call this function recursively
                $this->copyDirectory($sourcePath, $destinationPath);
            } else {
                // If the item is a file, copy it
                copy($sourcePath, $destinationPath);
            }
        }
    }
    // create directory if it doesn't exist
    private function createDirectoryIfNotExists($path)
    {
        if (!file_exists($path)) {
            if (mkdir($path, 0755, true)) {
                error_log('Created directoryt::' . $path);
            } else {
                error_log('Failed to create directory::' . $path);
            }
        } else {
            error_log('Directory already exists::' . $path);
        }
    }
    // create the apiconfig.php file
    private function createApiConfigFile($filePath)
    {
        $companyId = $this->companyId;
        $company = Company::where('id', $companyId)->first();

        if (!$company) return error_log('Company not found::' . $companyId);

        if (!file_exists($filePath)) {
            // $siteType = '';
            $siteType = (strpos($filePath, 'cloudcrm') !== false) ? 'crm' : 'cms';
            $fileContent = "<?php\n define('APIKEY', '{$company->apikey}');\n define('APIKSECRET', '{$company->apisecret}');\n define('SITETYPE', '{$siteType}');";
            // Try to create the apiconfig.php file
            try {
                file_put_contents($filePath, $fileContent);
                error_log('Created apiconfig.php file at::' . $filePath);
            } catch (\Exception $e) {
                error_log('Failed to create apiconfig.php file::' . $e->getMessage());
            }
        } else {
            error_log('apiconfig.php already exists at::' . $filePath);
        }
    }
}
