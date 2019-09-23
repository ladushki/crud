<?php declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    protected $fillable = ['first_name', 'last_name', 'email', 'phone', 'company_id'];

    /**
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function getNameAttribute(): string
    {
        return $this->first_name.' '.$this->last_name;
    }
}
