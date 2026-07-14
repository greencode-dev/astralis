<?php

namespace App\Http\Controllers\Admin\Concerns;

use Illuminate\Support\Facades\Cache;

trait ClearDashboardCache
{
    protected function clearDashboardCache(): void
    {
        Cache::forget('admin.dashboard');
        Cache::forget('api.dashboard.stats');
    }
}
