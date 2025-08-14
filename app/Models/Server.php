<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Server
 *
 * @property int $id
 * @property string $name
 * @property string $hostname
 * @property string $ip_address
 * @property string $type
 * @property string|null $description
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ServerMetric> $serverMetrics
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\NetworkMetric> $networkMetrics
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Alert> $alerts
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Server newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Server newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Server query()
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereHostname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Server whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Server active()
 * @method static \Database\Factories\ServerFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Server extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'hostname',
        'ip_address',
        'type',
        'description',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the server metrics for the server.
     */
    public function serverMetrics(): HasMany
    {
        return $this->hasMany(ServerMetric::class);
    }

    /**
     * Get the network metrics for the server.
     */
    public function networkMetrics(): HasMany
    {
        return $this->hasMany(NetworkMetric::class);
    }

    /**
     * Get the alerts for the server.
     */
    public function alerts(): HasMany
    {
        return $this->hasMany(Alert::class);
    }

    /**
     * Get the latest server metric.
     */
    public function latestServerMetric()
    {
        return $this->serverMetrics()->latest()->first();
    }

    /**
     * Get the latest network metric.
     */
    public function latestNetworkMetric()
    {
        return $this->networkMetrics()->latest()->first();
    }

    /**
     * Scope a query to only include active servers.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}