<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Alert
 *
 * @property int $id
 * @property int $server_id
 * @property string $type
 * @property string $severity
 * @property string $message
 * @property string|null $details
 * @property bool $is_resolved
 * @property \Illuminate\Support\Carbon|null $resolved_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Server $server
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Alert newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Alert newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Alert query()
 * @method static \Illuminate\Database\Eloquent\Builder|Alert whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alert whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alert whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alert whereSeverity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alert whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alert whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alert whereIsResolved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alert whereResolvedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alert whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alert whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alert unresolved()
 * @method static \Illuminate\Database\Eloquent\Builder|Alert critical()

 * 
 * @mixin \Eloquent
 */
class Alert extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'server_id',
        'type',
        'severity',
        'message',
        'details',
        'is_resolved',
        'resolved_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_resolved' => 'boolean',
        'resolved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the server that owns the alert.
     */
    public function server(): BelongsTo
    {
        return $this->belongsTo(Server::class);
    }

    /**
     * Scope a query to only include unresolved alerts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnresolved($query)
    {
        return $query->where('is_resolved', false);
    }

    /**
     * Scope a query to only include critical alerts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCritical($query)
    {
        return $query->where('severity', 'critical');
    }
}