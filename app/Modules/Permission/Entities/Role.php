<?php

namespace App\Modules\Permission\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasFactory;
    
    protected static function newFactory()
    {
        return \App\Modules\Permission\Database\factories\RoleFactory::new();
    }
}
