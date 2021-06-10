<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Pizza extends Model
{
    use HasFactory;

    const PIZZA_PENDING = 'Pending';
    const PIZZA_PROCESSING = 'Processing';
    const PIZZA_COMPLETE = 'Complete';

    protected $fillable = [
        'user_id',
        'pizza_status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
