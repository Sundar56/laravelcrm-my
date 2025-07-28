<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Encryptable;

class CompanyDatabase extends Model
{
    use HasFactory, SoftDeletes, Encryptable;

    protected $table = "company_databases";

    protected $fillable = [
        'company_id',
        'db_name',
        'dbuser_name',
        'db_password',
        'collation',
    ];

    // Define the attributes that should be encrypted
    protected static $encryptable = [
        'db_name',
        'dbuser_name',
        'db_password',
    ];
}
