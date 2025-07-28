<ul class="list-group list-group-flush gap-2">
    @if($roles->isEmpty())
    <li class="list-group-item text-center">No data available</li>
    @else
    @foreach($roles as $role)
    <li class="list-group-item d-flex justify-content-between align-items-center role-item {{ 'role-selector' . (isset($role_settings) && $role_settings ? '_' . $role_settings : '') }}  {{ $loop->first ? 'selected' : '' }}" id="selectedRole" data-id="{{Crypt::encrypt($role->id)}}" data-moduleid="{{$module_type ?? '' }}" data-companyid="{{Crypt::encrypt($role->company_id)}}">
        <span data-id="{{$role->id}}" class="">{{$role->display_name}}</span>
        @if( $role->name != 'superadmin')
        <div>
            <span title="Edit" class="{{ 'EditRolesModal' . (isset($role_settings) && $role_settings? '_' . $role_settings : '') }} me-2" id="editRole_{{$role->id}}" data-id="{{Crypt::encrypt($role->id)}}">
                <i class="bx bx-edit"></i>
            </span>
            <span title="Delete" class="{{ 'deleteRoles' . (isset($role_settings) && $role_settings ? '_' . $role_settings : '') }}" id="deleteRole_{{$role->id}}" data-id="{{Crypt::encrypt($role->id)}}" data-companyid="{{Crypt::encrypt($role->company_id)}}" data-rolestype="{{$role->type}}">
                <i class="bx bx-trash-alt"></i>
            </span>      
        </div>
        @endif
    </li>
    @endforeach
    @endif
</ul>