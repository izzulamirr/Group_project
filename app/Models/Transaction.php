<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'donator_id',
        'amount',
        'remarks',
        'receipt', // Assuming you want to include receipt in the fillable attributes
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function donator()
    {
        return $this->belongsTo(Donator::class);
    }
}