<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Permission;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_displayname',
        'user_phone',
        'user_type',
        'is_blocked',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public static function roleID()
    {
        $activeroleid = Session::get('activeroleid');
        $roleId = Auth::user()->roles->first()->id;
        if (isset($activeroleid)) {
            return $activeroleid->id;
        } else {
            return $roleId;
        }
    }
    public static function user_permissions($permission)
    {
        $roleId = Session::get('activeroleid');      
        // dd($roleId->id);
        $permission_id = Permission::where('name', $permission)->pluck('id')->first();
        if (isset($permission_id)) {
            $hasPermission = RoleHasPermission::where('permission_id', $permission_id)->where('role_id', $roleId)->first();
            // dd($permission_id);          
            if (isset($hasPermission)) {
                return true;
            } else {
                return false;
            }
        }
    }
}
