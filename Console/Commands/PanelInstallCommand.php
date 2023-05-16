<?php

namespace App\Console\Commands;

use App\Models\Activity;
use App\Models\Admin;
use App\Models\Allergy;
use App\Models\Clinic;
use App\Models\DailyCaffeine;
use App\Models\DailyWater;
use App\Models\Destination;
use App\Models\DietCategory;
use App\Models\DietCompatibility;
use App\Models\Disease;
use App\Models\EatingHabit;
use App\Models\Job;
use App\Models\PhysicalActivity;
use App\Models\RecipeCategory;
use App\Models\Role;
use App\Models\SleepPattern;
use App\Models\WeeklyExerciseCount;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class PanelInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'panel:install {--f|force : Overwrite} {--d|dummy : Dummy}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        set_time_limit(0);
        ini_set('memory_limit', '10240M');

        // Database check
        try {
            DB::connection()->getPdo();
        } catch (\PDOException $PDOException) {
            $this->error('Database Connection Error');

            return false;
        }

        // Install Check
        if (!$this->option('force') && Schema::hasTable('admins')) {
            $this->error('Panel Already Installed');

            return false;
        }

        Artisan::call('migrate:fresh', [
            '--force' => $this->option('force'),
        ]);

        // Users
        $this->callSilent('passport:client', [
            '--client' => true,
            '--name' => config('app.name') . ' Access Client',
            '--provider' => 'users',
        ]);
        \Laravel\Passport\Client::where('name', config('app.name') . ' Access Client')->update([
            'id' => '97336ac7-7b98-4834-b38b-64251c735e80',
            'secret' => 'seimnWqy80FCcqIFghd0AJzNPD6ja5DM0zxXrTLL',
        ]);

        // Admin
        $this->callSilent('passport:client', [
            '--client' => true,
            '--name' => config('app.name') . ' Admin Password Grant Client',
            '--provider' => 'admins',
        ]);
        \Laravel\Passport\Client::where('name', config('app.name') . ' Admin Password Grant Client')->update([
            'id' => '959b3030-9da2-4b2d-ac6d-03038aa58286',
            'secret' => 'ilMvT2b8HJsxDcU1kieq6XWC95dvqKyFxdThc5qf',
        ]);

        $this->callSilent('passport:client', [
            '--personal' => true,
            '--name' => config('app.name') . ' Personal Access Client',
        ]);

        if (app()->environment('production')) {
            $this->call('cache:clear');

            foreach ([
                         'assets', 'private', 'media', 'public',
                     ] as $disk) {
                foreach (Storage::disk($disk)->allDirectories() as $directory) {
                    Storage::deleteDirectory($directory);
                }

                foreach (Storage::disk($disk)->allFiles() as $file) {
                    Storage::delete($file);
                }
            }
        }
        if ($this->option('dummy')) {
            Activity::factory()->count(10)->create();
            Allergy::factory()->count(10)->create();
            Clinic::factory()->count(3)->create();
            DailyCaffeine::factory()->count(10)->create();
            DailyWater::factory()->count(10)->create();
            Destination::factory()->count(5)->create();
            DietCategory::factory()->count(10)->create();
            DietCompatibility::factory()->count(10)->create();
            Disease::factory()->count(10)->create();
            EatingHabit::factory()->count(10)->create();
            Job::factory()->count(10)->create();
            PhysicalActivity::factory()->count(10)->create();
            RecipeCategory::factory()->count(10)->create();
            SleepPattern::factory()->count(10)->create();
//            Subscription::factory()->count(10)->create();
            WeeklyExerciseCount::factory()->count(10)->create();
        }
        Clinic::create([
            'name'=>'İstanbul',
            'location' => 'Google Maps linki'
        ]);
        Clinic::create([
            'name'=>'Diyarbakır',
            'location' => 'Google Maps linki'
        ]);
        $role = Role::create([
            'name' =>'Yönetici',
            'modules'=>[0,1,2,3,4,5,6,7,8],
        ]);
        Admin::create([
            'first_name' => 'Kumsal',
            'last_name' => 'Developer',
            'email' => 'developer@kumsalajans.com',
            'password' => Hash::make('kumsalajans'),
            'phone' => '+902222222222',
            'role_id'=>$role->id
        ]);

        return 0;
    }
}
