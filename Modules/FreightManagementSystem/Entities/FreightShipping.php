<?php

namespace Modules\FreightManagementSystem\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Setting;
use App\Models\User;

class FreightShipping extends Model
{
    use HasFactory;

    protected $table = "freight_shippings_requests";
    protected $fillable = [
        'code', 
        'container',
        'quantity',
        'volume',
        'invoice_status',
        'booking_id', 
        'user_id', 
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
    public static $statues = [
        'Draft',
        'Accept',
        'Reject',
        'Delivered',
        'Complete',
    ];
    public static $invoiceStatues = [
        'Nothing to invoice',
        'Waiting for payment',
        'Partialy Paid',
        'Paid',
    ];
    public function frieghtServices()
    {
        return $this->hasMany(FreightShippingService::class, 'shipping_id', 'id');
    }
    public function frieghtTracking()
    {
        return $this->hasMany(FreightTracking::class, 'shipping_id', 'id');
    }
    protected static function newFactory()
    {
        return \Modules\FreightManagementSystem\Database\factories\FreightShippingFactory::new();
    }
    public static function starting_number($id, $type, $company_id = null, $workspace = null)
    {

        if ($type == 'shipping') {
            $key = 'shipping_code_starting_number';
        }

        if (!empty($key) && $id) {

            $data = [
                'key' => $key,
                'workspace' => !empty($workspace) ? $workspace : getActiveWorkSpace(),
                'created_by' => !empty($company_id) ? $company_id : creatorId()
            ];
            Setting::updateOrInsert($data, ['value' => $id]);
            // Settings Cache forget
            comapnySettingCacheForget($company_id, $workspace);
            return true;
        }
        return false;
    }
    public static function shippingCodeNumberFormat($number, $company_id = null, $workspace_id = null)
    {

        if (!empty($company_id) && empty($workspace)) {
            $company_settings = getCompanyAllSetting($company_id);
        } elseif (!empty($company_id) && !empty($workspace)) {
            $company_settings = getCompanyAllSetting($company_id, $workspace);
        } else {
            $company_settings = getCompanyAllSetting();
        }
        $data = !empty($company_settings['shipping_code_prefix']) ? $company_settings['shipping_code_prefix'] : '#FSN-';

        return $data . sprintf("%05d", $number);
    }
    public static function shippingCode($user_id = null)
    {
        if (!empty($user_id)) {
            $latest = company_setting('shipping_code_starting_number', $user_id);
        } else {
            $latest = company_setting('shipping_code_starting_number');
        }

        if ($latest == null) {
            return 1;
        } else {
            return $latest;
        }
    }
}
