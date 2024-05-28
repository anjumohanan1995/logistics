<?php

namespace Modules\FreightManagementSystem\Entities;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FreightContainer extends Model
{
    use HasFactory;
    protected $table ='freight_containers';
    protected $fillable = ['code','container_number','name','size','size_uom','volume_price','state','workspace','created_by'];
    
    protected static function newFactory()
    {
        return \Modules\FreightManagementSystem\Database\factories\FreightContainerFactory::new();
    }
    public static function starting_number($id, $type)
    {
        if($type == 'container_code')
        {
            $key = 'container_code_starting_number';
        }
        elseif($type == 'container_number')
        {
            $key = 'container_number_starting_number';
        }
        if(!empty($key) && $id){

            $data = [
                'key' => $key,
                'workspace' => getActiveWorkSpace(),
                'created_by' => creatorId(),
            ];
            Setting::updateOrInsert($data, ['value' => $id]);
            // Settings Cache forget
            comapnySettingCacheForget();
            return true;
        }
        return false;
    }
    public static function containerCodeNumberFormat($number,$company_id = null,$workspace_id = null)
    {

        if(!empty($company_id) && empty($workspace))
        {
            $company_settings = getCompanyAllSetting($company_id);
        }
        elseif(!empty($company_id) && !empty($workspace))
        {
            $company_settings = getCompanyAllSetting($company_id,$workspace);
        }
        else
        {
            $company_settings = getCompanyAllSetting();
        }
        $data = !empty($company_settings['container_code_prefix']) ? $company_settings['container_code_prefix'] : '#CON';

        return $data. sprintf("%05d", $number);
    }

    public static function containerNumberNumberFormat($number,$company_id = null,$workspace_id = null)
    {

        if(!empty($company_id) && empty($workspace))
        {
            $company_settings = getCompanyAllSetting($company_id);
        }
        elseif(!empty($company_id) && !empty($workspace))
        {
            $company_settings = getCompanyAllSetting($company_id,$workspace);
        }
        else
        {
            $company_settings = getCompanyAllSetting();
        }
        $data = !empty($company_settings['container_number_prefix']) ? $company_settings['container_number_prefix'] : '#CSN';

        return $data. sprintf("%05d", $number);
    }
    
}
