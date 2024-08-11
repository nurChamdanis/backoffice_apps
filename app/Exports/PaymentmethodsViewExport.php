<?php 

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Modules\Users\App\Models\PaymentMethod;

class PaymentmethodsViewExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
	protected $query;

	protected $rec_id;

    public function __construct($query, $rec_id)
    {
        $this->query = $query->select(PaymentMethod::exportViewFields());
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
			'Code',
			'Swift Code',
			'Description',
			'Type',
			'Icon',
			'Status',
			'Created At',
			'Updated At'
        ];
    }


    public function map($record): array
    {
        return [
			$record->id,
			$record->code,
			$record->swift_code,
			$record->description,
			$record->type,
			$record->icon,
			$record->status,
			$record->created_at,
			$record->updated_at
        ];
    }
}
