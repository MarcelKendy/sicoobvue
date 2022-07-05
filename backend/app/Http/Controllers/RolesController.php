<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Department;
use App\Models\User;

class RolesController extends Controller
{
    // ROLES

    public function getRoles(Request $request)
    {
        $result = Role::where('id', '!=', 1)->with('department')->get();
        return response()->json($result);
    }

    public function addRole(Request $request)
    {
        $newRole = new Role();
        $newRole->name = $request->name;
        $newRole->department_id = $request->department_id;
        $newRole->save();
        return true;
    }

    public function editRole(Role $role, Request $request)
    {
        $role->name = $request->name;
        $role->department_id = $request->department_id;
        $role->save();
        return true;
    }

    public function deleteRole(Role $role, Request $request)
    {
        User::where('role_id', $role->id)->update(['role_id' => 1]);
        $role->delete();
        return true;
    }

    //

    // DEPARTMENTS

    public function getDepartments(Request $request)
    {
        $result = Department::all();
        return response()->json($result);
    }

    public function addDepartment(Request $request)
    {
        $newDepartment = new Department();
        $newDepartment->name = $request->name;
        $newDepartment->team = $request->team;
        $newDepartment->save();
        return true;
    }

    public function editDepartment(Department $department, Request $request)
    {
        $department->name = $request->name;
        $department->team = $request->team;
        $department->save();
        return true;
    }

    public function deleteDepartment(Department $department, Request $request)
    {
        Role::where('department_id', $department->id)->update(['department_id' => 1]);
        $department->delete();
        return true;
    }

    //
}
