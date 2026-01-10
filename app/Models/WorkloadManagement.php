<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkloadManagement extends Model
{
    use HasFactory;

    protected $fillable = [
        'developer_id',
        'current_projects_count',
        'max_projects_capacity',
        'availability_status',
        'workload_percentage',
        'last_updated_at',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'current_projects_count' => 'integer',
        'max_projects_capacity' => 'integer',
        'workload_percentage' => 'float',
        'last_updated_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the developer that owns this workload.
     */
    public function developer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'developer_id');
    }

    /**
     * Calculate current workload based on active projects.
     */
    public function calculateWorkload(): array
    {
        $activeProjects = $this->developer->projects()
            ->whereIn('status', ['in_progress', 'accepted'])
            ->count();

        $workloadPercentage = $this->max_projects_capacity > 0 
            ? ($activeProjects / $this->max_projects_capacity) * 100 
            : 0;

        // Update the record
        $this->update([
            'current_projects_count' => $activeProjects,
            'workload_percentage' => round($workloadPercentage, 2),
            'availability_status' => $this->determineAvailabilityStatus($workloadPercentage),
            'last_updated_at' => now(),
        ]);

        return [
            'active_projects' => $activeProjects,
            'max_capacity' => $this->max_projects_capacity,
            'workload_percentage' => round($workloadPercentage, 2),
            'availability_status' => $this->determineAvailabilityStatus($workloadPercentage),
        ];
    }

    /**
     * Determine availability status based on workload percentage.
     */
    private function determineAvailabilityStatus(float $percentage): string
    {
        return match(true) {
            $percentage >= 100 => 'overloaded',
            $percentage >= 75 => 'busy',
            default => 'available'
        };
    }

    /**
     * Check if developer is available for new projects.
     */
    public function isAvailable(): bool
    {
        return $this->availability_status === 'available';
    }

    /**
     * Check if developer is overloaded.
     */
    public function isOverloaded(): bool
    {
        return $this->availability_status === 'overloaded';
    }

    /**
     * Get remaining capacity.
     */
    public function getRemainingCapacity(): int
    {
        return max(0, $this->max_projects_capacity - $this->current_projects_count);
    }
}
