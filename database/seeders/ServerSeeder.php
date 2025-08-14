<?php

namespace Database\Seeders;

use App\Models\Server;
use Illuminate\Database\Seeder;

class ServerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Linux servers
        Server::factory()
            ->linux()
            ->count(8)
            ->create();

        // Create network devices
        Server::factory()
            ->networkDevice()
            ->count(4)
            ->create();

        // Create some specific servers
        Server::create([
            'name' => 'Production Web Server',
            'hostname' => 'web-prod.company.local',
            'ip_address' => '192.168.1.10',
            'type' => 'linux',
            'description' => 'Main production web server running Apache',
            'is_active' => true,
        ]);

        Server::create([
            'name' => 'Database Master',
            'hostname' => 'db-master.company.local',
            'ip_address' => '192.168.1.20',
            'type' => 'linux',
            'description' => 'Primary MySQL database server',
            'is_active' => true,
        ]);

        Server::create([
            'name' => 'Core Switch',
            'hostname' => 'switch-core.company.local',
            'ip_address' => '192.168.1.1',
            'type' => 'network_device',
            'description' => 'Main network switch for office',
            'is_active' => true,
        ]);
    }
}