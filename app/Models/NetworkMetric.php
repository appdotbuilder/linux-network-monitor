<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\NetworkMetric
 *
 * @property int $id
 * @property int $server_id
 * @property bool $is_online
 * @property float|null $latency_ms
 * @property int $bytes_in
 * @property int $bytes_out
 * @property float $bandwidth_usage
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Server $server
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkMetric newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkMetric newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkMetric query()
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkMetric whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkMetric whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkMetric whereIsOnline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkMetric whereLatencyMs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkMetric whereBytesIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkMetric whereBytesOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkMetric whereBandwidthUsage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkMetric whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkMetric whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NetworkMetric online()

 * 
 * @mixin \Eloquent
 */
class NetworkMetric extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'server_id',
        'is_online',
        'latency_ms',
        'bytes_in',
        'bytes_out',
        'bandwidth_usage',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_online' => 'boolean',
        'latency_ms' => 'decimal:2',
        'bytes_in' => 'integer',
        'bytes_out' => 'integer',
        'bandwidth_usage' => 'decimal:2',
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

    /**
     * Scope a query to only include online metrics.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOnline($query)
    {
        return $query->where('is_online', true);
    }
}