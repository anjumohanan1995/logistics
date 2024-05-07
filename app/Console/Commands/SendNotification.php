<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Hrm\Entities\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class SendNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:passport-expiration-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $employees = Employee::where('is_active',1)->orderBy('created_at','DESC')->get();

        foreach ($employees as $employee) {
            $name = $employee->name;
            $email = $employee->email;
            $expiry = date('d-m-Y', strtotime($employee->passport_expiry_date));

            $expiryDate = Carbon::parse($expiry);
            $daysUntilExpiry = now()->diffInDays($expiryDate, false);

            if ($daysUntilExpiry === 30) {
                Mail::send('emails.sendmail', ['expiryDate' => $expiry, 'name' => $name], function ($message) use ($email, $expiry) {
                    $message->to($email);
                    $message->subject('Passport Expiry Reminder');
                });
            }
        }
       // $this->info('Email sent successfully.');
    }
}
