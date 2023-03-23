<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $table = 'reports';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'tech_id',
        'report_title',
        'solving_description',
        'report_status'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function tech()
    {
        return $this->belongsTo('App\Models\User', 'tech_id');
    }
}
