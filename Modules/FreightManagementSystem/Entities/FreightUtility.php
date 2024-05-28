<?php

namespace Modules\FreightManagementSystem\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\WorkSpace;
use App\Models\Setting;
use Modules\FreightManagementSystem\Entities\FreightPayment;
class FreightUtility extends Model
{
    use HasFactory;
    public static function GivePermissionToRoles($role_id = null, $rolename = null)
{
    $client_permissions = [
        'freight management system manage',
        'booking request manage',
        'booking request show',
        'shipping manage',
        'shipping show',
        'freight route manage',
        'freight invoice show',
        'freight invoice manage'
    ];

    if ($role_id == null) {
        // client
        $roles_c = Role::where('name', 'client')->get();
        foreach ($roles_c as $role) {
            foreach ($client_permissions as $permission_c) {
                $permission = Permission::where('name', $permission_c)->first();
                if ($permission && !$role->hasPermission($permission_c)) {
                    $role->givePermission($permission);
                }
            }
        }
    } else {
        if ($rolename == 'client') {
            $roles_c = Role::where('name', 'client')->where('id', $role_id)->first();
            foreach ($client_permissions as $permission_c) {
                $permission = Permission::where('name', $permission_c)->first();
                if ($permission && !$roles_c->hasPermission($permission_c)) {
                    $roles_c->givePermission($permission);
                }
            }
        }
    }
}


    public static function defaultdata($company_id = null, $workspace_id = null)
    {
        $company_setting = [
            "booking_request_code_prefix" => "#BOOK",
            "booking_request_code_starting_number" => "1",
            "container_code_starting_number"=>"1",
            "container_number_starting_number"=>"1",
            "freight_invoice_code_starting_number"=>"1",
            "shipping_code_starting_number"=>"1",
            "container_code_prefix"=>"#CON",
            "container_number_prefix"=>"#CSN",
            "freight_invoice_code_prefix"=>"#FRE-INVO",
            "shipping_code_prefix"=>"#FSN-",
        ];
        if ($company_id == Null) {
            $companys = User::where('type', 'company')->get();
            foreach ($companys as $company) {
                $WorkSpaces = WorkSpace::where('created_by', $company->id)->get();
                foreach ($WorkSpaces as $WorkSpace) {
                   
                    foreach ($company_setting as $key => $value) {
                        // Define the data to be updated or inserted
                        $data = [
                            'key' => $key,
                            'workspace' => !empty($WorkSpace->id) ? $WorkSpace->id : 0,
                            'created_by' => $company->id,
                        ];

                        // Check if the record exists, and update or insert accordingly
                        Setting::updateOrInsert($data, ['value' => $value]);
                    }
                }
            }
        } elseif ($workspace_id == Null) {
            $company = User::where('type', 'company')->where('id', $company_id)->first();
            $WorkSpaces = WorkSpace::where('created_by', $company->id)->get();
            foreach ($WorkSpaces as $WorkSpace) {
               
                foreach ($company_setting as $key => $value) {
                    // Define the data to be updated or inserted
                    $data = [
                        'key' => $key,
                        'workspace' => !empty($WorkSpace->id) ? $WorkSpace->id : 0,
                        'created_by' => $company->id,
                    ];

                    // Check if the record exists, and update or insert accordingly
                    Setting::updateOrInsert($data, ['value' => $value]);
                }
            }
        } else {
            $company = User::where('type', 'company')->where('id', $company_id)->first();
            $WorkSpace = WorkSpace::where('created_by', $company->id)->where('id', $workspace_id)->first();
           
            foreach ($company_setting as $key => $value) {
                // Define the data to be updated or inserted
                $data = [
                    'key' => $key,
                    'workspace' => !empty($WorkSpace->id) ? $WorkSpace->id : 0,
                    'created_by' => $company->id,
                ];

                // Check if the record exists, and update or insert accordingly
                Setting::updateOrInsert($data, ['value' => $value]);
            }
        }
        
    }

    public static function getPaymentLineChartDate()
    {
        $m = date("m");
        $de = date("d");
        $y = date("Y");
        $format = 'Y-m-d';
        $arrDate = [];
        $arrDateFormat = [];

        for ($i = 0; $i <= 15 - 1; $i++) {
            $date = date($format, mktime(0, 0, 0, $m, ($de - $i), $y));

            $arrDay[] = date('D', mktime(0, 0, 0, $m, ($de - $i), $y));
            $arrDate[] = $date;
            $arrDateFormat[] = date("d-M", strtotime($date));
        }
        $dataArr['day'] = $arrDateFormat;

        for ($i = 0; $i < count($arrDate); $i++) {
        
            $dayPament = FreightPayment::selectRaw('sum(amount) amount')->where('workspace', getActiveWorkSpace())->whereRaw('date = ?', $arrDate[$i])->first();
            
            $paymentAmount = !empty($dayPament->amount) ? $dayPament->amount : 0;
            $paymentArr[] = str_replace(",", "", number_format($paymentAmount, 2));
        }
        $dataArr['payment'] = $paymentArr;
        return $dataArr;
    }
}
