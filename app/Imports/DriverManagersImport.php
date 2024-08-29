<?php
namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\DriverManger;
use App\Mail\SendUserPassword;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class DriverManagersImport implements ToModel, WithHeadingRow, WithValidation, WithChunkReading, ShouldQueue
{
    public function model(array $row)
    {
        // Validate the email before proceeding
        $validator = Validator::make($row, [
            'email' => 'required|email',
            'phone_number' => 'required',
        ]);

        if ($validator->fails()) {
            // Skip this row if the email or phone number is invalid
            return null;
        }

        // Check if the user already exists by either email or phone number
        $user = User::where('email', $row['email'])
                    ->orWhere('phone_number', $row['phone_number'])
                    ->first();

        if (!$user) {
            $referralCode = $row['referral_code'] ?? null;
            $ref_by = User::where("referral_code", $referralCode)->first();
            // Generate a random password
            $password = Str::random(10);

            // Create the user if it doesn't exist
            $user = new User([
                'full_name' => $row['name'] ?? $row['first_name'] . ' ' . $row['last_name'],
                'email' => $row['email'],
                'phone_number' => $row['phone_number'],
                'address' => $row['address'] ?? null,
                'password' => Hash::make($password),
                'role_id' => 9,
                'ref_by' => $ref_by->id ?? null,
                'referral_code' => $referralCode ?? generateReferralCode(),
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

            // Optionally send the password to the user via email
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

    public function chunkSize(): int
    {
        return 100;
    }
    public function rules(): array
    {
        return [
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'email' => 'required',
            'phone_number' => 'nullable',
            'state' => 'nullable|string',
            'lga' => 'nullable|string',
            'company_name' => 'nullable|string',
            'company_address' => 'nullable|string',
            'company_state' => 'nullable|string',
            'company_lga' => 'nullable|string',
            'address' => 'nullable|string',
            'referral_code' => 'nullable|string',
        ];
    }

    protected function getStateId($stateName)
    {
        // Assuming you have a method to get the state ID by the state name
        $state = \App\Models\State::where('name', $stateName)->first();
        return $state ? $state->id : 2;
    }
}
