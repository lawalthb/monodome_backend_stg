<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersByPlanExport implements FromCollection, WithHeadings, WithMapping
{
    protected $planId;

    public function __construct($planId)
    {
        $this->planId = $planId;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::where('plan_id', $this->planId)->get();
    }

    /**
     * Return the headings for the export.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Full Name',
            'Email',
            'Phone Number',
            'Address',
            'Status',
            'Plan ID',
            'Created At',
            'Updated At'
        ];
    }

    /**
     * Map the data for each row.
     *
     * @param \App\Models\User $user
     * @return array
     */
    public function map($user): array
    {
        return [
            $user->id,
            $user->full_name,
            $user->email,
            $user->phone_number,
            $user->address,
            $user->status,
            $user->plan_id,
            $user->created_at,
            $user->updated_at
        ];
    }
}
