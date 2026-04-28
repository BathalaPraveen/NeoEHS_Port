<?php

namespace App\Exports;

use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersProfileExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function headings(): array
    {
        return [
            'S NO',
            'User Name',
            'Email',
            'Contact No',
            'Profile Status',
        ];
    }

    public function collection()
    {

        $data = DB::table(DB::raw(' users, (SELECT @a:= 0) AS a'))
            ->select(
                DB::raw(' @a:=@a+1 "No." , name as "User Name", email as "Email ID", mobile as "Mobile No",
                 (CASE
                WHEN users.status = "0" THEN "In-Active"
                WHEN users.status = "1" THEN "Active"
                ELSE "In-Active"
                END) as "Profile Status",
                DATE_FORMAT(created_at,"%d-%m-%Y") as "Created At"')
            );


        $data = $data->where('trash', 'NO');
        $data = $data->orderBy('created_at', 'Desc');
        $data = $data->get();

        return $data;
    }
}
