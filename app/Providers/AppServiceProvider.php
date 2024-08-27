<?php

namespace App\Providers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('req_actions', function () {
            $result = DB::select("SELECT id FROM tbl_actions where status != 'Closed'");
            return count($result);
        });
        $this->app->bind('salaries', function () {
            $user_id = Auth::user()->id;
            $lkp_company  = DB::select("SELECT DISTINCT lkp_company.id,lkp_company.companyName FROM `users_privilege` JOIN warehouse ON warehouse.id = users_privilege.warehouseId JOIN lkp_company ON lkp_company.id = warehouse.companyId WHERE users_privilege.user_id = '$user_id' AND lkp_company.id <> 6 AND lkp_company.status = 'active'");
            return count($lkp_company);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(199);
        if($this->app->environment('production')) {
            \URL::forceScheme('https');
        }
    }
}
