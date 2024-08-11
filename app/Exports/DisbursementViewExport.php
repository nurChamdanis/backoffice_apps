<?php 

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Modules\InstTransfer\App\Models\Disbursement;

class DisbursementViewExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
	protected $query;

	protected $rec_id;

    public function __construct($query, $rec_id)
    {
        $this->query = $query->select(Disbursement::exportViewFields());
        $this->rec_id = $rec_id;
    }


    public function query()
    {
        return $this->query->where("id", $this->rec_id);
    }


	public function headings(): array
    {
        return [
			'Id',
			'User Id',
			'Ref Id',
			'Nominal',
			'Bank Code',
			'Account Number',
			'Account Holder Name',
			'Disbursement Description',
			'Status',
			'Respon Json',
			'Callback Json',
			'Created At',
			'Updated At'
        ];
    }


    public function map($record): array
    {
        return [
			$record->id,
			$record->user_id,
			$record->ref_id,
			$record->nominal,
			$record->bank_code,
			$record->account_number,
			$record->account_holder_name,
			$record->disbursement_description,
			$record->status,
			$record->respon_json,
			$record->callback_json,
			$record->created_at,
			$record->updated_at
        ];
    }
}
