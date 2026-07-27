<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'logo_url'];

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function reviews()
    {
        return $this->hasManyThrough(Review::class, Event::class);
    }

    public function averageRating(): float
    {
        $avg = $this->reviews()->avg('rating');
        return $avg ? round((float) $avg, 1) : 0.0;
    }

    public function totalReviews(): int
    {
        return $this->reviews()->count();
    }

    public function ratingBreakdown(): array
    {
        $total = $this->totalReviews();
        $counts = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];

        if ($total > 0) {
            $grouped = $this->reviews()
                ->selectRaw('rating, count(*) as count')
                ->groupBy('rating')
                ->pluck('count', 'rating')
                ->toArray();

            foreach ($counts as $star => &$val) {
                if (isset($grouped[$star])) {
                    $val = $grouped[$star];
                }
            }
        }

        return $counts;
    }
}
