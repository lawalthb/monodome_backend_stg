<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $settings = [
            [
                'name' => 'Email Address',
                'value' => 'admin@email.com',
                'slug' => 'email',
                'created_at' => '2019-11-22 06:41:04',
                'updated_at' => null,
            ],
            [
                'name' => 'Mobile',
                'value' => '9874563210',
                'slug' => 'mobile',
                'created_at' => '2019-11-22 06:41:04',
                'updated_at' => null,
            ],
            [
                'name' => 'Address',
                'value' => '216 , Regal Indl Estate, Acharya Dhonde Marg, Sewree',
                'slug' => 'address',
                'created_at' => '2019-11-22 06:41:04',
                'updated_at' => null,
            ],

            [
                'name' => 'Paystack Generate Recipient',
                'value' => 'https://api.paystack.co/transferrecipient',
                'slug' => 'paystackGenerateRecipient',
                'created_at' => '2020-01-07 18:30:00',
                'updated_at' => null,
            ],
            [
                'name' => 'Paystack OTP Verification',
                'value' => 'https://api.paystack.co/transfer',
                'slug' => 'paystackOtpVerify',
                'created_at' => '2020-01-07 18:30:00',
                'updated_at' => null,
            ],
            [
                'name' => 'Paystack Resend OTP',
                'value' => 'https://api.paystack.co/transfer/resend_otp',
                'slug' => 'paystackResendOtp',
                'created_at' => '2020-01-07 18:30:00',
                'updated_at' => null,
            ],
            [
                'name' => 'Paystack Finalize Transfer',
                'value' => 'https://api.paystack.co/transfer/finalize_transfer',
                'slug' => 'paystackFinalTransfer',
                'created_at' => '2020-01-07 18:30:00',
                'updated_at' => null,
            ],
            [
                'name' => 'Paystack Email',
                'value' => 'paytest@mailboxt.com',
                'slug' => 'paystackemail',
                'created_at' => '2019-11-22 06:41:04',
                'updated_at' => null,
            ],
            [
                'name' => 'Contact Us',
                'value' => 'donejeh@gmail.com',
                'slug' => 'contact_us',
                'created_at' => '2020-04-12 21:19:29',
                'updated_at' => '2020-04-12 21:17:26',
            ],
            [
                'name' => 'Paystack Charge',
                'value' => 'https://api.paystack.co/charge',
                'slug' => 'paystackCharge',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'name' => 'Paystack Verify transaction',
                'value' => 'https://api.paystack.co/transaction/verify',
                'slug' => 'paystackVerifytransaction',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'name' => 'Paystack Disable Subscription',
                'value' => 'https://api.paystack.co/subscription/disable',
                'slug' => 'paystackDisableSubscription',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'name' => 'Paystack Enable Subscription',
                'value' => 'https://api.paystack.co/subscription/enable',
                'slug' => 'paystackEnableSubscription',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'name' => 'Transaction Fees',
                'value' => '1',
                'slug' => 'transactionFees',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'name' => 'Push notification key',
                'value' => 'AAAANx8g43o:APA91bHW26755huHhI2-5idBElrpcayBmQWP6cP82i9F6bEMipD5cQvSjL_TDnEjJ6gsudZG0dnxjgQMK44KS4ngIRe-PYGvvDgcMqOfnL2aGxuD4Oerx-4VtsFDG-oSBLRskF7p3Wc4',
                'slug' => 'firebase_key',
                'created_at' => null,
                'updated_at' => null,
            ],

            [
                'name' => 'Secret Key',
                'value' => 'sk_test_5c5f8c527269a6cbf2d1be70abb555195ed0e869',
                'slug' => 'secretkey',
                'created_at' => '2020-01-07 18:30:00',
                'updated_at' => null,
            ],

            [
                'name' => 'Public Key',
                'value' => 'pk_test_050699a6e3ee4c79ec253cf5eeb1cbde63aa2c22',
                'slug' => 'publickey',
                'created_at' => '2020-01-07 18:30:00',
                'updated_at' => null,
            ],


        ];

        // Insert the data into the 'settings' table
        DB::table('settings')->insert($settings);
    }
}