<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ServerMetric
 *
 * @property int $id
 * @property int $server_id
 * @property float $cpu_usage
 * @property float $memory_usage
 * @property float $disk_usage
 * @property int $running_processes
 * @property int $disk_total_gb
 * @property int $memory_total_mb
 * @property float $load_average
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Server $server
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|ServerMetric newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServerMetric newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServerMetric query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServerMetric whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerMetric whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerMetric whereCpuUsage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerMetric whereMemoryUsage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerMetric whereDiskUsage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerMetric whereRunningProcesses($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerMetric whereDiskTotalGb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerMetric whereMemoryTotalMb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerMetric whereLoadAverage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerMetric whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerMetric whereUpdatedAt($value)

 * 
 * @mixin \Eloquent
 */
class ServerMetric extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'server_id',
        'cpu_usage',
        'memory_usage',
        'disk_usage',
        'running_processes',
        'disk_total_gb',
        'memory_total_mb',
        'load_average',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'cpu_usage' => 'decimal:2',
        'memory_usage' => 'decimal:2',
        'disk_usage' => 'decimal:2',
        'load_average' => 'decimal:2',
        'running_processes' => 'integer',
        'disk_total_gb' => 'integer',
        'memory_total_mb' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the server that owns the metric.
     */
    public function server(): BelongsTo
    {
        return $this->belongsTo(Server::class);
    }
}