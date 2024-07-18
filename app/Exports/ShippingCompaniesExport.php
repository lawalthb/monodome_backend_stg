<?php

namespace App\Exports;

use App\Models\ShippingCompany;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ShippingCompaniesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ShippingCompany::all();
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
            'Name',
            'Phone Number',
            'Street',
            'City',
            'State',
            'Country',
            'Status',
            'NIN Number',
            'Created At',
            'Updated At'
        ];
    }
}
