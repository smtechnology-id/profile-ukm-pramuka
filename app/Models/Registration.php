<?php

namespace App\Models;

use App\Models\Event;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Registration extends Model
{
    use HasFactory;
    protected $table = 'registrations';
    protected $fillable = ['event_id', 'name', 'nim', 'birth_date', 'birth_place', 'motivation'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
