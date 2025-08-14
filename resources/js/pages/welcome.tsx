import React from 'react';
import { Link } from '@inertiajs/react';
import { Button } from '@/components/ui/button';

interface Props {
    canLogin?: boolean;
    canRegister?: boolean;
    [key: string]: unknown;
}

export default function Welcome({ canLogin, canRegister }: Props) {
    return (
        <div className="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900">
            <div className="container mx-auto px-4 py-16">
                {/* Header */}
                <div className="text-center mb-16">
                    <div className="flex justify-center items-center mb-8">
                        <div className="w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center text-4xl">
                            🖥️
                        </div>
                    </div>
                    <h1 className="text-5xl font-bold text-white mb-4">
                        🔍 Server & Network Monitor
                    </h1>
                    <p className="text-xl text-gray-300 max-w-2xl mx-auto">
                        Sistem monitoring komprehensif untuk server Linux dan perangkat jaringan dengan 
                        dashboard real-time, data historis, dan sistem peringatan otomatis.
                    </p>
                </div>

                {/* Features Grid */}
                <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                    <div className="bg-slate-800/50 backdrop-blur-lg rounded-xl p-6 border border-slate-700">
                        <div className="text-3xl mb-4">📊</div>
                        <h3 className="text-xl font-semibold text-white mb-2">Server Monitoring</h3>
                        <p className="text-gray-400">
                            Monitor CPU, memory, disk usage, running processes, dan load average 
                            dari semua server Linux Anda.
                        </p>
                    </div>

                    <div className="bg-slate-800/50 backdrop-blur-lg rounded-xl p-6 border border-slate-700">
                        <div className="text-3xl mb-4">🌐</div>
                        <h3 className="text-xl font-semibold text-white mb-2">Network Monitoring</h3>
                        <p className="text-gray-400">
                            Pantau status online/offline, latensi, dan statistik bandwidth 
                            dari perangkat jaringan.
                        </p>
                    </div>

                    <div className="bg-slate-800/50 backdrop-blur-lg rounded-xl p-6 border border-slate-700">
                        <div className="text-3xl mb-4">⚡</div>
                        <h3 className="text-xl font-semibold text-white mb-2">Real-time Dashboard</h3>
                        <p className="text-gray-400">
                            Dashboard interaktif dengan data real-time, grafik, dan 
                            overview status sistem.
                        </p>
                    </div>

                    <div className="bg-slate-800/50 backdrop-blur-lg rounded-xl p-6 border border-slate-700">
                        <div className="text-3xl mb-4">📈</div>
                        <h3 className="text-xl font-semibold text-white mb-2">Historical Data</h3>
                        <p className="text-gray-400">
                            Analisis trend dengan data historis, grafik timeline, 
                            dan laporan performa.
                        </p>
                    </div>

                    <div className="bg-slate-800/50 backdrop-blur-lg rounded-xl p-6 border border-slate-700">
                        <div className="text-3xl mb-4">🚨</div>
                        <h3 className="text-xl font-semibold text-white mb-2">Alert System</h3>
                        <p className="text-gray-400">
                            Sistem peringatan otomatis untuk high CPU/memory usage, 
                            server offline, dan threshold lainnya.
                        </p>
                    </div>

                    <div className="bg-slate-800/50 backdrop-blur-lg rounded-xl p-6 border border-slate-700">
                        <div className="text-3xl mb-4">📋</div>
                        <h3 className="text-xl font-semibold text-white mb-2">Log Analysis</h3>
                        <p className="text-gray-400">
                            Monitor log webserver (Apache/Nginx), slow query MySQL, 
                            dan system logs.
                        </p>
                    </div>
                </div>

                {/* Demo Preview */}
                <div className="bg-slate-800/30 backdrop-blur-lg rounded-2xl p-8 border border-slate-700 mb-12">
                    <h3 className="text-2xl font-bold text-white mb-6 text-center">
                        📱 Dashboard Preview
                    </h3>
                    <div className="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <div className="bg-gradient-to-br from-green-500 to-green-600 rounded-lg p-4">
                            <div className="text-green-100 text-sm">Servers Online</div>
                            <div className="text-2xl font-bold text-white">12/15</div>
                        </div>
                        <div className="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg p-4">
                            <div className="text-blue-100 text-sm">Avg CPU</div>
                            <div className="text-2xl font-bold text-white">45%</div>
                        </div>
                        <div className="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg p-4">
                            <div className="text-purple-100 text-sm">Avg Memory</div>
                            <div className="text-2xl font-bold text-white">62%</div>
                        </div>
                        <div className="bg-gradient-to-br from-red-500 to-red-600 rounded-lg p-4">
                            <div className="text-red-100 text-sm">Active Alerts</div>
                            <div className="text-2xl font-bold text-white">3</div>
                        </div>
                    </div>
                    <div className="text-center text-gray-400">
                        Monitor semua server dan perangkat jaringan dalam satu dashboard terpusat
                    </div>
                </div>

                {/* CTA Section */}
                <div className="text-center">
                    <h3 className="text-2xl font-bold text-white mb-6">
                        Mulai Monitor Infrastruktur Anda
                    </h3>
                    <div className="flex justify-center space-x-4">
                        {canLogin && (
                            <Link href="/login">
                                <Button className="bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white px-8 py-3 text-lg">
                                    🔑 Login
                                </Button>
                            </Link>
                        )}
                        {canRegister && (
                            <Link href="/register">
                                <Button 
                                    variant="outline" 
                                    className="border-slate-600 text-white hover:bg-slate-800 px-8 py-3 text-lg"
                                >
                                    📝 Register
                                </Button>
                            </Link>
                        )}
                    </div>
                    <p className="text-gray-500 mt-4">
                        Daftar sekarang untuk mengakses dashboard monitoring lengkap
                    </p>
                </div>
            </div>

            {/* Background Effects */}
            <div className="fixed inset-0 -z-10">
                <div className="absolute top-10 left-10 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
                <div className="absolute top-0 right-4 w-72 h-72 bg-blue-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
                <div className="absolute -bottom-8 left-20 w-72 h-72 bg-pink-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>
            </div>
        </div>
    );
}