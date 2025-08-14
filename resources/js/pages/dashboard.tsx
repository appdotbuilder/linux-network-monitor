
import AppLayout from '@/layouts/app-layout';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

export default function Dashboard() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-6 p-6">
                {/* Welcome Section */}
                <div className="space-y-2">
                    <h1 className="text-3xl font-bold">🖥️ Server & Network Monitor</h1>
                    <p className="text-gray-600 dark:text-gray-400">
                        Sistem monitoring komprehensif untuk infrastruktur IT Anda
                    </p>
                </div>

                {/* Quick Actions */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <Card className="hover:shadow-lg transition-shadow">
                        <CardHeader>
                            <CardTitle className="flex items-center gap-2">
                                🖥️ Server Monitoring
                            </CardTitle>
                        </CardHeader>
                        <CardContent className="space-y-4">
                            <p className="text-gray-600 dark:text-gray-400">
                                Monitor CPU, memory, disk usage, dan performa server Linux secara real-time.
                            </p>
                            <Link href="/monitoring">
                                <Button className="w-full">
                                    Lihat Dashboard
                                </Button>
                            </Link>
                        </CardContent>
                    </Card>

                    <Card className="hover:shadow-lg transition-shadow">
                        <CardHeader>
                            <CardTitle className="flex items-center gap-2">
                                🌐 Network Status
                            </CardTitle>
                        </CardHeader>
                        <CardContent className="space-y-4">
                            <p className="text-gray-600 dark:text-gray-400">
                                Pantau status online/offline perangkat jaringan dan latensi koneksi.
                            </p>
                            <Link href="/monitoring">
                                <Button className="w-full" variant="outline">
                                    Cek Status
                                </Button>
                            </Link>
                        </CardContent>
                    </Card>

                    <Card className="hover:shadow-lg transition-shadow">
                        <CardHeader>
                            <CardTitle className="flex items-center gap-2">
                                🚨 Alert System
                            </CardTitle>
                        </CardHeader>
                        <CardContent className="space-y-4">
                            <p className="text-gray-600 dark:text-gray-400">
                                Sistem peringatan otomatis untuk masalah performa dan konektivitas.
                            </p>
                            <Link href="/monitoring">
                                <Button className="w-full" variant="secondary">
                                    Lihat Alerts
                                </Button>
                            </Link>
                        </CardContent>
                    </Card>
                </div>

                {/* Features Overview */}
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <Card>
                        <CardHeader>
                            <CardTitle>📊 Monitoring Features</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <ul className="space-y-3">
                                <li className="flex items-center gap-2">
                                    <span className="w-2 h-2 bg-green-500 rounded-full"></span>
                                    <span>Real-time CPU, Memory, Disk monitoring</span>
                                </li>
                                <li className="flex items-center gap-2">
                                    <span className="w-2 h-2 bg-blue-500 rounded-full"></span>
                                    <span>Network latency dan bandwidth tracking</span>
                                </li>
                                <li className="flex items-center gap-2">
                                    <span className="w-2 h-2 bg-purple-500 rounded-full"></span>
                                    <span>Running processes monitoring</span>
                                </li>
                                <li className="flex items-center gap-2">
                                    <span className="w-2 h-2 bg-orange-500 rounded-full"></span>
                                    <span>System load average tracking</span>
                                </li>
                            </ul>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader>
                            <CardTitle>⚡ Advanced Capabilities</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <ul className="space-y-3">
                                <li className="flex items-center gap-2">
                                    <span className="w-2 h-2 bg-red-500 rounded-full"></span>
                                    <span>Automated alerting system</span>
                                </li>
                                <li className="flex items-center gap-2">
                                    <span className="w-2 h-2 bg-yellow-500 rounded-full"></span>
                                    <span>Historical data analysis</span>
                                </li>
                                <li className="flex items-center gap-2">
                                    <span className="w-2 h-2 bg-teal-500 rounded-full"></span>
                                    <span>Performance trend visualization</span>
                                </li>
                                <li className="flex items-center gap-2">
                                    <span className="w-2 h-2 bg-pink-500 rounded-full"></span>
                                    <span>Log analysis (Apache/Nginx/MySQL)</span>
                                </li>
                            </ul>
                        </CardContent>
                    </Card>
                </div>

                {/* Getting Started */}
                <Card className="bg-gradient-to-r from-blue-50 to-purple-50 dark:from-blue-950 dark:to-purple-950">
                    <CardHeader>
                        <CardTitle className="flex items-center gap-2">
                            🚀 Quick Start
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="flex flex-col md:flex-row items-center justify-between gap-4">
                            <div>
                                <p className="text-gray-700 dark:text-gray-300 mb-2">
                                    Mulai monitoring infrastruktur Anda dalam hitungan menit
                                </p>
                                <p className="text-sm text-gray-600 dark:text-gray-400">
                                    Generate sample data atau hubungkan server production Anda
                                </p>
                            </div>
                            <Link href="/monitoring">
                                <Button size="lg" className="bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700">
                                    Start Monitoring →
                                </Button>
                            </Link>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </AppLayout>
    );
}
