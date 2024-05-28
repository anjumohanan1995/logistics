<?php

namespace Modules\FreightManagementSystem\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Setting;
use App\Models\User;

class FreightBookingRequest extends Model
{
    use HasFactory;
    protected $table = "freight_booking_requests";
    protected $fillable = [
        'convert_shipping_id',
        'is_convert',
        'code',
        'status',
        'customer_name',
        'customer_email',
        'direction',
        'transport',
        'loading_port',
        'discharge_port',
        'vessel',
        'date',
        'barcode',
        'tracking_no',
        'attechment',
        'workspace',
        'created_by'
    ];
    
    protected static function newFactory()
    {
        return \Modules\FreightManagementSystem\Database\factories\FreightBookingRequestFactory::new();
    }
    public function customer()
    {
        return $this->hasOne(User::class, 'email', 'customer_email');
    }
    public static function starting_number($id, $type,$company_id=null,$workspace=null)
    {
        
        if($type == 'booking_request')
        {
            $key = 'booking_request_code_starting_number';
        }
       
        if(!empty($key) && $id){
            
            $data = [
                'key' => $key,
                'workspace' => !empty($workspace) ? $workspace : getActiveWorkSpace(),
                'created_by' =>!empty($company_id) ? $company_id : creatorId()
            ];
            Setting::updateOrInsert($data, ['value' => $id]);
            // Settings Cache forget
            comapnySettingCacheForget($company_id,$workspace);
            return true;
        }
        return false;
    }
    public static function bookingRequestCodeNumberFormat($number,$company_id = null,$workspace_id = null)
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
        $data = !empty($company_settings['booking_request_code_prefix']) ? $company_settings['booking_request_code_prefix'] : '#BOOK';

        return $data. sprintf("%05d", $number);
    }
    public static function bookingRequestCode($user_id=null)
    {
        if(!empty($user_id))
        {
            $latest = company_setting('booking_request_code_starting_number',$user_id);
        }
        else{
            $latest = company_setting('booking_request_code_starting_number');
        }
        
        if ($latest == null) {
            return 1;
        } else {
            return $latest;
        }
    }
    public static $statues = [
        'Draft',
        'Accept',
        'Reject',
        'Convert',
        'Complete',
    ];

}
