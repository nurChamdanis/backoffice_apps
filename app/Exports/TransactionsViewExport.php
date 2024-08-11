<?php 

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Modules\Transaksi\App\Models\Transaksi;

class TransactionsViewExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
	protected $query;

	protected $rec_id;

    public function __construct($query, $rec_id)
    {
        $this->query = $query->select(Transaksi::exportViewFields());
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
