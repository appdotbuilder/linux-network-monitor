import React from 'react';
import AppLayout from '@/layouts/app-layout';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { router } from '@inertiajs/react';
import { type BreadcrumbItem } from '@/types';

interface Server {
    id: number;
    name: string;
    hostname: string;
    ip_address: string;
    type: string;
    server_metrics: Array<{
        cpu_usage: number;
        memory_usage: number;
        disk_usage: number;
        running_processes: number;
        load_average: number;
    }>;
    network_metrics: Array<{
        is_online: boolean;
        latency_ms: number | null;
        bandwidth_usage: number;
    }>;
}

interface Alert {
    id: number;
    type: string;
    severity: string;
    message: string;
    details: string | null;
    created_at: string;
    server: {
        name: string;
    };
}

interface Props {
    servers: Server[];
    totalServers: number;
    onlineServers: number;
    offlineServers: number;
    alerts: Alert[];
    criticalAlerts: number;
    averageMetrics: {
        cpu: number;
        memory: number;
        latency: number;
    };
    [key: string]: unknown;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Monitoring',
        href: '/monitoring',
    },
];

export default function MonitoringDashboard({
    servers,
    totalServers,
    onlineServers,
    offlineServers,
    alerts,
    criticalAlerts,
    averageMetrics,
}: Props) {
    const handleGenerateData = () => {
        router.post(route('monitoring.generate'), {}, {
            preserveState: true,
            preserveScroll: true,
        });
    };

    const handleResolveAlert = (alertId: number) => {
        router.patch(route('alerts.resolve', alertId), {}, {
            preserveState: true,
            preserveScroll: true,
        });
    };

    const getSeverityColor = (severity: string) => {
        switch (severity) {
            case 'critical': return 'bg-red-500';
            case 'high': return 'bg-orange-500';
            case 'medium': return 'bg-yellow-500';
            case 'low': return 'bg-blue-500';
            default: return 'bg-gray-500';
        }
    };

    const getUsageColor = (usage: number) => {
        if (usage >= 90) return 'text-red-500';
        if (usage >= 75) return 'text-orange-500';
        if (usage >= 60) return 'text-yellow-500';
        return 'text-green-500';
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <div className="p-6">
                <div className="flex justify-between items-center mb-6">
                    <div>
                        <h1 className="text-3xl font-bold">🖥️ Server & Network Monitor</h1>
                        <p className="text-gray-600 dark:text-gray-400">
                            Real-time monitoring dashboard untuk infrastruktur IT
                        </p>
                    </div>
                    <Button onClick={handleGenerateData} className="bg-blue-500 hover:bg-blue-600">
                        🔄 Generate Sample Data
                    </Button>
                </div>

                {/* Stats Cards */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <Card>
                        <CardHeader className="pb-2">
                            <CardTitle className="text-sm font-medium">🌐 Total Servers</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold">{totalServers}</div>
                            <p className="text-xs text-gray-600">Registered servers</p>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader className="pb-2">
                            <CardTitle className="text-sm font-medium">✅ Online</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold text-green-600">{onlineServers}</div>
                            <p className="text-xs text-gray-600">{offlineServers} offline</p>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader className="pb-2">
                            <CardTitle className="text-sm font-medium">📊 Avg CPU</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className={`text-2xl font-bold ${getUsageColor(averageMetrics.cpu)}`}>
                                {averageMetrics.cpu}%
                            </div>
                            <p className="text-xs text-gray-600">Across all servers</p>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader className="pb-2">
                            <CardTitle className="text-sm font-medium">🚨 Critical Alerts</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold text-red-600">{criticalAlerts}</div>
                            <p className="text-xs text-gray-600">Require attention</p>
                        </CardContent>
                    </Card>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    {/* Servers List */}
                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center gap-2">
                                🖥️ Server Status
                                <Badge variant="outline">{servers.length}</Badge>
                            </CardTitle>
                        </CardHeader>
                        <CardContent className="p-0">
                            <div className="max-h-96 overflow-y-auto">
                                {servers.map((server) => {
                                    const serverMetric = server.server_metrics[0];
                                    const networkMetric = server.network_metrics[0];
                                    
                                    return (
                                        <div key={server.id} className="p-4 border-b border-gray-200 dark:border-gray-700 last:border-b-0">
                                            <div className="flex items-center justify-between mb-2">
                                                <div className="flex items-center gap-2">
                                                    <div className={`w-3 h-3 rounded-full ${
                                                        networkMetric?.is_online ? 'bg-green-500' : 'bg-red-500'
                                                    }`}></div>
                                                    <div>
                                                        <div className="font-medium">{server.name}</div>
                                                        <div className="text-sm text-gray-500">{server.ip_address}</div>
                                                    </div>
                                                </div>
                                                <Badge variant={server.type === 'linux' ? 'default' : 'secondary'}>
                                                    {server.type === 'linux' ? '🐧 Linux' : '🌐 Network'}
                                                </Badge>
                                            </div>
                                            
                                            {serverMetric && (
                                                <div className="grid grid-cols-3 gap-4 text-sm">
                                                    <div>
                                                        <div className="text-gray-500">CPU</div>
                                                        <div className={getUsageColor(serverMetric.cpu_usage)}>
                                                            {serverMetric.cpu_usage}%
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div className="text-gray-500">Memory</div>
                                                        <div className={getUsageColor(serverMetric.memory_usage)}>
                                                            {serverMetric.memory_usage}%
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div className="text-gray-500">Disk</div>
                                                        <div className={getUsageColor(serverMetric.disk_usage)}>
                                                            {serverMetric.disk_usage}%
                                                        </div>
                                                    </div>
                                                </div>
                                            )}
                                            
                                            {networkMetric && (
                                                <div className="mt-2 text-sm text-gray-500">
                                                    Latency: {networkMetric.latency_ms ? `${networkMetric.latency_ms}ms` : 'N/A'} | 
                                                    Bandwidth: {networkMetric.bandwidth_usage}%
                                                </div>
                                            )}
                                        </div>
                                    );
                                })}
                            </div>
                        </CardContent>
                    </Card>

                    {/* Alerts */}
                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center gap-2">
                                🚨 Recent Alerts
                                <Badge variant="destructive">{alerts.length}</Badge>
                            </CardTitle>
                        </CardHeader>
                        <CardContent className="p-0">
                            <div className="max-h-96 overflow-y-auto">
                                {alerts.length === 0 ? (
                                    <div className="p-8 text-center text-gray-500">
                                        <div className="text-4xl mb-2">✅</div>
                                        <div>No active alerts</div>
                                        <div className="text-sm">All systems are running normally</div>
                                    </div>
                                ) : (
                                    alerts.map((alert) => (
                                        <div key={alert.id} className="p-4 border-b border-gray-200 dark:border-gray-700 last:border-b-0">
                                            <div className="flex items-start justify-between">
                                                <div className="flex-1">
                                                    <div className="flex items-center gap-2 mb-1">
                                                        <Badge className={getSeverityColor(alert.severity)}>
                                                            {alert.severity.toUpperCase()}
                                                        </Badge>
                                                        <Badge variant="outline">
                                                            {alert.type}
                                                        </Badge>
                                                    </div>
                                                    <div className="font-medium mb-1">{alert.message}</div>
                                                    <div className="text-sm text-gray-500 mb-2">
                                                        Server: {alert.server.name}
                                                    </div>
                                                    {alert.details && (
                                                        <div className="text-sm text-gray-600 dark:text-gray-400">
                                                            {alert.details}
                                                        </div>
                                                    )}
                                                    <div className="text-xs text-gray-500 mt-1">
                                                        {new Date(alert.created_at).toLocaleString()}
                                                    </div>
                                                </div>
                                                <Button
                                                    size="sm"
                                                    variant="outline"
                                                    onClick={() => handleResolveAlert(alert.id)}
                                                    className="ml-2"
                                                >
                                                    Resolve
                                                </Button>
                                            </div>
                                        </div>
                                    ))
                                )}
                            </div>
                        </CardContent>
                    </Card>
                </div>

                {/* Performance Metrics Summary */}
                <Card className="mt-8">
                    <CardHeader>
                        <CardTitle>📈 Performance Overview</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div className="text-center">
                                <div className="text-3xl font-bold text-blue-600 mb-2">
                                    {averageMetrics.cpu}%
                                </div>
                                <div className="text-sm text-gray-500">Average CPU Usage</div>
                                <div className="w-full bg-gray-200 rounded-full h-2 mt-2">
                                    <div 
                                        className={`h-2 rounded-full ${getUsageColor(averageMetrics.cpu).includes('red') ? 'bg-red-500' : 
                                                   getUsageColor(averageMetrics.cpu).includes('orange') ? 'bg-orange-500' :
                                                   getUsageColor(averageMetrics.cpu).includes('yellow') ? 'bg-yellow-500' : 'bg-green-500'}`}
                                        style={{ width: `${averageMetrics.cpu}%` }}
                                    ></div>
                                </div>
                            </div>
                            
                            <div className="text-center">
                                <div className="text-3xl font-bold text-purple-600 mb-2">
                                    {averageMetrics.memory}%
                                </div>
                                <div className="text-sm text-gray-500">Average Memory Usage</div>
                                <div className="w-full bg-gray-200 rounded-full h-2 mt-2">
                                    <div 
                                        className={`h-2 rounded-full ${getUsageColor(averageMetrics.memory).includes('red') ? 'bg-red-500' : 
                                                   getUsageColor(averageMetrics.memory).includes('orange') ? 'bg-orange-500' :
                                                   getUsageColor(averageMetrics.memory).includes('yellow') ? 'bg-yellow-500' : 'bg-green-500'}`}
                                        style={{ width: `${averageMetrics.memory}%` }}
                                    ></div>
                                </div>
                            </div>
                            
                            <div className="text-center">
                                <div className="text-3xl font-bold text-green-600 mb-2">
                                    {averageMetrics.latency}ms
                                </div>
                                <div className="text-sm text-gray-500">Average Network Latency</div>
                                <div className="text-xs text-gray-400 mt-1">
                                    {averageMetrics.latency < 50 ? '🟢 Excellent' : 
                                     averageMetrics.latency < 100 ? '🟡 Good' : '🔴 Poor'}
                                </div>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </AppLayout>
    );
}