<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Driver;
use Illuminate\Support\Str;
use App\Services\WalletService;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SendLoginNotificationJob;
use Maatwebsite\Excel\Concerns\ToModel;
use Stevebauman\Location\Facades\Location;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements ToModel,WithHeadingRow ,WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $ref_by = User::where("referral_code", $row['ref_by'])->first();

        $password = Str::random(10);

        $user = new User([
            'full_name' => $row['full_name'],
            'email' => $row['email'],
            'phone_number' => $row['phone_number'],
            'address' => $row['address'] ?? null,
            'password' => Hash::make($password),
            'role_id' => $row['role_id'],
            'ref_by' => $ref_by ? $ref_by->id : null,
            'referral_code' => generateReferralCode(),
            // 'location' => Location::get(request()->ip()),
            'user_agent' => request()->header('User-Agent'),
        ]);

        $role = Role::find($row['role_id']);
        if ($role) {
            $user->user_type = Str::slug($role->name, "_");
            $user->role_id = $role->id;
            $user->role = $role->name;
            $user->assignRole($role);
        }

        if ($role->id == 3) {
            $user->status = "Confirmed";
        }

        $user->save();

        //if is driver
        if ($role->id == 8) {
           $this->driverData($user, $row);
        }


        if ($ref_by !== null) {
            $data = [
                "amount" => 5,
                "payment_type" => 'wallet',
                "type" => 'credit',
                "fee" => 0,
                "description" => 'Bonus point for referring ' . $user->full_name
            ];

            WalletService::createWalletAndHistory($ref_by, $data);
        }

        $message = "Thank you for Registering with " . config('app.name');
        dispatch(new SendLoginNotificationJob($user, $message));

        // $token = $user->createToken("monodomebackend" . $user->email)->plainTextToken;

        // return $this->success(
        //     [
        //         "user" => new UserResource($user),
        //         "token" => $token
        //     ],
        //     "User registered successfully"
        // );
    }


    public function driverData($user, $row){

        $driver = new Driver([
            'user_id' => $user->id,
            'state_id' =>$row['state_id'],
            'street' =>$row['street'],
            'status' => 'Pending',
            'lga' =>$row['lga'],
            'nin_number' =>$row['nin_number'],
            'license_number' =>$row['license_number'],
            'have_motor' =>$row['have_motor'],
            'vehicle_type_id' =>$row['vehicle_type_id'],
            // Add other agent fields here
        ]);

        $driver->save();

    }

     /**
     * Write code on Method
     *
     * @return response()
     */
    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
            'ref_by' => 'nullable|string|max:10',
            'role_id' => [
                'required',
                'numeric',
                Rule::in([8, 3]),
            ],
            'state_id' => 'required_if:role_id,8|numeric|max:255',
            'street' => 'required_if:role_id,8|string|max:255',
            'lga' => 'required_if:role_id,8|string|max:255',
            'nin_number' => 'required_if:role_id,8|numeric',
            'license_number' => 'required_if:role_id,8|numeric',
            'have_motor' => 'required_if:role_id,8|string|max:255',
            'vehicle_type_id' => 'required_if:role_id,8|numeric',
        ];
    }

}
