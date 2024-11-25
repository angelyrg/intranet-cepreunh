<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'guard_name'];

}
