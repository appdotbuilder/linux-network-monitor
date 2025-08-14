<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\MonitoringService;
use App\Models\Server;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MonitoringController extends Controller
{
    /**
     * The monitoring service instance.
     */
    protected MonitoringService $monitoringService;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\MonitoringService  $monitoringService
     * @return void
     */
    public function __construct(MonitoringService $monitoringService)
    {
        $this->monitoringService = $monitoringService;
    }

    /**
     * Display the monitoring dashboard.
     */
    public function index()
    {
        $dashboardData = $this->monitoringService->getDashboardData();
        
        return Inertia::render('monitoring/dashboard', $dashboardData);
    }

    /**
     * Generate sample monitoring data.
     */
    public function store(Request $request)
    {
        $dashboardData = $this->monitoringService->generateSampleData();
        
        return Inertia::render('monitoring/dashboard', $dashboardData);
    }

    /**
     * Show server details with historical data.
     */
    public function show(Server $server, Request $request)
    {
        $period = $request->get('period', '24h');
        $historicalData = $this->monitoringService->getHistoricalData($server->id, $period);
        
        return Inertia::render('monitoring/server-details', $historicalData);
    }


}