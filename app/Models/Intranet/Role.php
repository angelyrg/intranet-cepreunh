<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Role extends Model
{

    use HasFactory, SoftDeletes;
    
    protected $fillable = ['name', 'guard_name'];

    // tegno este error: Llamada al método indefinido App\Models\Intranet\Role::permissions()
    // public function permissions()
    // {
    //     return $this->belongsToMany(Permission::class);
    // }



}
