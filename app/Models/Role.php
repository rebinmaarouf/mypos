<?php

namespace App\Models;

use Laratrust\Models\Role as LaratrustRole;  // Make sure to import Laratrust's Role model
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Role extends LaratrustRole
{

    public $guarded = [];
}
