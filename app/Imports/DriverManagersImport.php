<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\DriverManger;
use App\Models\DriverManager;
use App\Mail\SendUserPassword;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class DriverManagersImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        // Check if the user already exists
        $user = User::where('email', $row['email'])->first();

        if (!$user) {
            $ref_by = User::where("referral_code", $row['referral_code'])->first();
            // Generate a random password
            $password = Str::random(10);

            // Create the user if it doesn't exist
            $user = new User([
                'full_name' => $row['first_name'] . ' ' . $row['last_name'],
                'email' => $row['email'],
                'phone_number' => $row['phone_number'],
                'address' => $row['address'] ?? null,
                'password' => Hash::make($password),
                'role_id' => 9,
                'ref_by' => $ref_by->id ?? null,
                'referral_code' => $row['referral_code'] ?? generateReferralCode(),
                'user_agent' => request()->header('User-Agent'),
            ]);

            // Assign the role
            $role = Role::find(9);
            if ($role) {
                $user->user_type = Str::slug($role->name, "_");
                $user->role_id = $role->id;
                $user->role = $role->name;
                $user->assignRole($role);
            }

            $user->save();

            // Send the password to the user via email
            Mail::to($user->email)->send(new SendUserPassword($user, $password));
        }

        // Create the DriverManager and link it to the user
        return new DriverManger([
            'uuid' => (string) Str::uuid(),
            'user_id' => $user->id,
            'state_id' => $this->getStateId($row['state']),
            'lga' => $row['lga'] ?? null,
            'business_name' => $row['company_name'] ?? null,
            'company_name' => $row['company_name'] ?? null,
            'company_address' => $row['company_address'] ?? null,
            'company_state' => $row['company_state'] ?? null,
            'company_lga' => $row['company_lga'] ?? null,
            'phone_number' => $row['phone_number'] ?? null,
            'street' => $row['address'] ?? null,
            'status' => 'Pending',
        ]);
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone_number' => 'required|max:15',
            'state' => 'required|max:255',
            'lga' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'company_address' => 'nullable|string|max:255',
            'company_state' => 'nullable|max:255',
            'company_lga' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'referral_code' => 'nullable|string|max:10',
        ];
    }

    protected function getStateId($stateName)
    {
        // Assuming you have a method to get the state ID by the state name
        $state = \App\Models\State::where('name', $stateName)->first();
        return $state ? $state->id : 2;
    }
}
