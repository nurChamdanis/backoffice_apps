<?php 

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Modules\Transaksi\App\Models\Transaksi;

class TransactionsListExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
	
	protected $query;
	
    public function __construct($query)
    {
        $this->query = $query->select(Transaksi::exportListFields());
    }
	
    public function query()
    {
        return $this->query;
    }
	
	public function headings(): array
    {
        return [
			'Id',
			'User Id',
			'Produk Id',
			'Ref Id',
			'Invoice',
			'Tujuan',
			'Status',
			'Sn',
			'Harga',
			'Margin',
			'Desc',
			'Flag',
			'Tipe',
			'Created At',
			'Updated At',
			'Seller Ref'
        ];
    }
	
    public function map($record): array
    {
        return [
			$record->id,
			$record->user_id,
			$record->produk_id,
			$record->ref_id,
			$record->invoice,
			$record->tujuan,
			$record->status,
			$record->sn,
			$record->harga,
			$record->margin,
			$record->desc,
			$record->flag,
			$record->tipe,
			$record->created_at,
			$record->updated_at,
			$record->seller_ref
        ];
    }
}
