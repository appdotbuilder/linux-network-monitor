<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Server>
 */
class ServerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['linux', 'network_device'];
        $type = $this->faker->randomElement($types);
        
        return [
            'name' => $type === 'linux' 
                ? $this->faker->randomElement(['Web Server', 'Database Server', 'Mail Server', 'File Server', 'App Server']) . ' ' . $this->faker->numberBetween(1, 10)
                : $this->faker->randomElement(['Router', 'Switch', 'Firewall', 'Access Point']) . ' ' . $this->faker->numberBetween(1, 5),
            'hostname' => $this->faker->domainWord . ($type === 'linux' ? '.local' : '-net.local'),
            'ip_address' => $this->faker->localIpv4(),
            'type' => $type,
            'description' => $this->faker->sentence(),
            'is_active' => $this->faker->boolean(95), // 95% active
        ];
    }

    /**
     * Indicate that the server is a Linux server.
     */
    public function linux(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'linux',
            'name' => $this->faker->randomElement(['Web Server', 'Database Server', 'Mail Server', 'File Server', 'App Server']) . ' ' . $this->faker->numberBetween(1, 10),
            'hostname' => $this->faker->domainWord . '.local',
        ]);
    }

    /**
     * Indicate that the server is a network device.
     */
    public function networkDevice(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'network_device',
            'name' => $this->faker->randomElement(['Router', 'Switch', 'Firewall', 'Access Point']) . ' ' . $this->faker->numberBetween(1, 5),
            'hostname' => $this->faker->domainWord . '-net.local',
        ]);
    }
}