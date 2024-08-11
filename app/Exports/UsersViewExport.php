<?php 

namespace App\Exports;
use App\Models\Users;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UsersViewExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
	protected $query;
    public function __construct($query)
    {
        $this->query = $query->select(Users::exportViewFields());
    }

    public function query()
    {
        return $this->query->orderBy("id", "desc");
    }

	public function headings(): array
    {
        return [
			'Kode Referral',
			'Referred By',
			'Username',
			'First Name',
			'Last Name',
			'Email',
			'Phone',
			'Saldo',
			'Poin',
			'Koin',
			'Status',
			'Joined At',
        ];
    }


    public function map($record): array
    {
        return [
			$record->code,
			$record->ref_code,
			$record->name,
			$record->first_name,
			$record->last_name,
			$record->email,
			$record->phone,
			rupiah($record->saldo),
			rupiah($record->poin),
			rupiah($record->koin),
			$record->status,
			$record->created_at,
        ];
    }
}
