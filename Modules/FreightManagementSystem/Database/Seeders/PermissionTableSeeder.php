<?php

namespace Modules\FreightManagementSystem\Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;

class PermissionTableSeeder extends Seeder
{
     public function run()
    {
        Model::unguard();
        Artisan::call('cache:clear');
        $module = 'FreightManagementSystem';

        $permissions  = [
            'freight management system manage',
            'freight dashboard manage',
            'freight customer manage',
            'freight customer create',
            'freight customer edit',
            'freight customer delete',
            'freight invoice manage',
            'freight invoice create',
            'freight invoice delete',
            'freight invoice show',
            'freight invoice payment delete',
            'freight invoice payment create',
            'booking request manage',
            'booking request create',
            'booking request edit',
            'booking request delete',
            'booking request show',
            'booking request accept',
            'booking request reject',
            'booking request convert',
            'booking request manage',
            'shipping manage',
            'shipping edit',
            'shipping delete',
            'shipping show',
            'shipping convert',
            'shipping accept',
            'shipping reject',
            'container manage',
            'container create',
            'container edit',
            'container delete',
            'price manage',
            'price create',
            'price edit',
            'price delete',
            'freight route manage',
            'freight route create',
            'freight route edit',
            'freight route delete',
            'service manage',
            'service create',
            'service edit',
            'service delete'
            
        ];

        $company_role = Role::where('name','company')->first();
        foreach ($permissions as $key => $value)
        {
            $check = Permission::where('name',$value)->where('module',$module)->exists();
            if($check == false)
            {
                $permission = Permission::create(
                    [
                        'name' => $value,
                        'guard_name' => 'web',
                        'module' => $module,
                        'created_by' => 0,
                        "created_at" => date('Y-m-d H:i:s'),
                        "updated_at" => date('Y-m-d H:i:s')
                    ]
                );
                if(!$company_role->hasPermission($value))
                {
                    $company_role->givePermission($permission);
                }
            }
        }
    }
}
