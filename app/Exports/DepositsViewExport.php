<?php 

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Modules\Users\App\Models\Deposit;

class DepositsViewExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
	protected $query;

	protected $rec_id;

    public function __construct($query, $rec_id)
    {
        $this->query = $query->select(Deposit::exportViewFields());
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
			'Payment Id',
			'Order Id',
			'Ref Id',
			'Nominal',
			'Fee',
			'Total Payment',
			'Va Number',
			'Expired',
			'Status',
			'Callback Respon',
			'Created At',
			'Updated At'
        ];
    }


    public function map($record): array
    {
        return [
			$record->id,
			$record->user_id,
			$record->payment_id,
			$record->order_id,
			$record->ref_id,
			$record->nominal,
			$record->fee,
			$record->total_payment,
			$record->va_number,
			$record->expired,
			$record->status,
			$record->callback_respon,
			$record->created_at,
			$record->updated_at
        ];
    }
}
