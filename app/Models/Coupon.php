<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_purchase',
        'max_uses',
        'used_count',
        'starts_at',
        'expires_at',
        'is_active'
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_purchase' => 'decimal:2',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean'
    ];

    public function isValid($total = 0)
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->max_uses && $this->used_count >= $this->max_uses) {
            return false;
        }

        if ($this->starts_at && now()->lt($this->starts_at)) {
            return false;
        }

        if ($this->expires_at && now()->gt($this->expires_at)) {
            return false;
        }

        if ($this->min_purchase && $total < $this->min_purchase) {
            return false;
        }

        return true;
    }

    public function calculateDiscount($total)
    {
        if (!$this->isValid($total)) {
            return 0;
        }

        return $this->type === 'percentage'
            ? ($total * ($this->value / 100))
            : min($this->value, $total);
    }

    public function incrementUsage()
    {
        $this->increment('used_count');
    }
}