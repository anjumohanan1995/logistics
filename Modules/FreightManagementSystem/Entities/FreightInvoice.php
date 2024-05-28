<?php

namespace Modules\FreightManagementSystem\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\FreightManagementSystem\Entities\FreightShipping;
use App\Models\Setting;
class FreightInvoice extends Model
{
    use HasFactory;

    protected $table = "freight_invoices";
    protected $fillable = [
        'shipping_id',
        'customer_id', 
        'status', 
        'amount',
        'invoice_date',
        'due_date',
        'workspace', 
        'created_by', 
    ];
    public static $statues = [
        'Unpaid',
        'Partialy Paid',
        'Paid',
    ];
    public function freightShipping()
    {
        return $this->hasOne(FreightShipping::class, 'id', 'shipping_id');
    }
    protected static function newFactory()
    {
        return \Modules\FreightManagementSystem\Database\factories\FreightInvoiceFactory::new();
    }
    public static function starting_number($id, $type,$company_id=null,$workspace=null)
    {
        
        if($type == 'freight-invoice')
        {
            $key = 'freight_invoice_code_starting_number';
        }
       
        if(!empty($key) && $id){
            
            $data = [
                'key' => $key,
                'workspace' => !empty($workspace) ? $workspace : getActiveWorkSpace(),
                'created_by' =>!empty($company_id) ? $company_id : creatorId()
            ];
            Setting::updateOrInsert($data, ['value' => $id]);
            // Settings Cache forget
            comapnySettingCacheForget();
            return true;
        }
        return false;
    }
    public function payments()
    {
        return $this->hasMany(FreightPayment::class, 'invoice_id', 'id');
    }
    public function getDue()
    {
        $due = 0;
        foreach ($this->payments as $payment)
        {
            $due += $payment->amount;
        }
       
        return ($this->amount - $due);
    }
    public static function freightCodeNumberFormat($number,$company_id = null,$workspace_id = null)
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
        $data = !empty($company_settings['freight_invoice_code_prefix']) ? $company_settings['freight_invoice_code_prefix'] : '#FRE-INVO';

        return $data. sprintf("%05d", $number);
    }
    public static function freightCode($user_id=null)
    {
        if(!empty($user_id))
        {
            $latest = company_setting('freight_invoice_code_starting_number',$user_id);
        }
        else{
            $latest = company_setting('freight_invoice_code_starting_number');
        }
        
        if ($latest == null) {
            return 1;
        } else {
            return $latest;
        }
    }
}
