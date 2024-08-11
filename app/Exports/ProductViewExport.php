<?php 

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Modules\Produk\App\Models\Produk;

class ProductViewExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
	protected $query;

	protected $rec_id;

    public function __construct($query, $rec_id)
    {
        $this->query = $query->select(Produk::exportViewFields());
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
			'Name',
			'Description',
			'Category',
			'Type',
			'Price',
			'Margin',
			'Discount',
			'Sale Price',
			'Status',
			'Is Promo',
			'Prabayar',
			'Icon',
			'Created At',
			'Updated At'
        ];
    }


    public function map($record): array
    {
        return [
			$record->id,
			$record->code,
			$record->name,
			$record->description,
			$record->category,
			$record->type,
			$record->price,
			$record->margin,
			$record->discount,
			$record->sale_price,
			$record->status,
			$record->is_promo,
			$record->prabayar,
			$record->icon,
			$record->created_at,
			$record->updated_at
        ];
    }
}
