<?php

namespace App\Models;

use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use ApiResponseTrait;

    protected $guarded = [];

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    public function business() {
        return $this->belongsTo(User::class);
    }
}
