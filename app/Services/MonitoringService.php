<?php

namespace App\Services;

use App\Models\Server;
use App\Models\ServerMetric;
use App\Models\NetworkMetric;
use App\Models\Alert;

class MonitoringService
{
    /**
     * Generate sample monitoring data for demo purposes
     */
    public function generateSampleData(): array
    {
        $servers = Server::active()->get();
        
        foreach ($servers as $server) {
            // Generate server metrics
            $cpuUsage = random_int(10, 90);
            $memoryUsage = random_int(20, 85);
            $diskUsage = random_int(15, 75);
            
            ServerMetric::create([
                'server_id' => $server->id,
                'cpu_usage' => $cpuUsage,
                'memory_usage' => $memoryUsage,
                'disk_usage' => $diskUsage,
                'running_processes' => random_int(50, 200),
                'disk_total_gb' => random_int(100, 1000),
                'memory_total_mb' => random_int(4096, 32768),
                'load_average' => random_int(1, 5) + (random_int(0, 99) / 100),
            ]);

            // Generate network metrics
            $isOnline = random_int(1, 100) > 5; // 95% uptime
            $latency = $isOnline ? random_int(1, 100) : null;
            
            NetworkMetric::create([
                'server_id' => $server->id,
                'is_online' => $isOnline,
                'latency_ms' => $latency,
                'bytes_in' => random_int(1000000, 10000000),
                'bytes_out' => random_int(500000, 5000000),
                'bandwidth_usage' => random_int(10, 80),
            ]);

            // Generate alerts for high usage
            if ($cpuUsage > 80) {
                Alert::create([
                    'server_id' => $server->id,
                    'type' => 'cpu',
                    'severity' => 'high',
                    'message' => "High CPU usage: {$cpuUsage}%",
                    'details' => "CPU usage has exceeded threshold on {$server->name}",
                ]);
            }

            if ($memoryUsage > 80) {
                Alert::create([
                    'server_id' => $server->id,
                    'type' => 'memory',
                    'severity' => 'high',
                    'message' => "High memory usage: {$memoryUsage}%",
                    'details' => "Memory usage has exceeded threshold on {$server->name}",
                ]);
            }

            if (!$isOnline) {
                Alert::create([
                    'server_id' => $server->id,
                    'type' => 'network',
                    'severity' => 'critical',
                    'message' => "Server offline",
                    'details' => "Server {$server->name} is not responding",
                ]);
            }
        }

        return $this->getDashboardData();
    }

    /**
     * Get comprehensive dashboard data
     */
    public function getDashboardData(): array
    {
        $servers = Server::active()->with(['serverMetrics' => function($query) {
            $query->latest()->limit(1);
        }, 'networkMetrics' => function($query) {
            $query->latest()->limit(1);
        }])->get();

        $totalServers = $servers->count();
        $onlineServers = $servers->filter(function($server) {
            $networkMetric = $server->networkMetrics->first();
            return $networkMetric && $networkMetric->is_online;
        })->count();

        $alerts = Alert::unresolved()
            ->with('server')
            ->orderBy('severity', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $criticalAlerts = Alert::unresolved()->critical()->count();

        // Calculate average metrics
        $avgCpu = $servers->map(function($server) {
            $metric = $server->serverMetrics->first();
            return $metric ? $metric->cpu_usage : 0;
        })->average();

        $avgMemory = $servers->map(function($server) {
            $metric = $server->serverMetrics->first();
            return $metric ? $metric->memory_usage : 0;
        })->average();

        $avgLatency = $servers->map(function($server) {
            $metric = $server->networkMetrics->first();
            return $metric ? $metric->latency_ms : null;
        })->filter()->average();

        return [
            'servers' => $servers,
            'totalServers' => $totalServers,
            'onlineServers' => $onlineServers,
            'offlineServers' => $totalServers - $onlineServers,
            'alerts' => $alerts,
            'criticalAlerts' => $criticalAlerts,
            'averageMetrics' => [
                'cpu' => round($avgCpu, 1),
                'memory' => round($avgMemory, 1),
                'latency' => round($avgLatency, 1),
            ]
        ];
    }

    /**
     * Get historical data for charts
     */
    public function getHistoricalData(int $serverId, string $period = '24h'): array
    {
        $server = Server::findOrFail($serverId);
        
        $hours = match($period) {
            '1h' => 1,
            '6h' => 6,
            '24h' => 24,
            '7d' => 168,
            default => 24,
        };

        $serverMetrics = ServerMetric::where('server_id', $serverId)
            ->where('created_at', '>=', now()->subHours($hours))
            ->orderBy('created_at')
            ->get();

        $networkMetrics = NetworkMetric::where('server_id', $serverId)
            ->where('created_at', '>=', now()->subHours($hours))
            ->orderBy('created_at')
            ->get();

        return [
            'server' => $server,
            'serverMetrics' => $serverMetrics,
            'networkMetrics' => $networkMetrics,
        ];
    }
}