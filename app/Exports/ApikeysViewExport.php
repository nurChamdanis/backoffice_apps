<?php 

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Modules\Setting\App\Models\ApiKey;

class ApikeysViewExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
	protected $query;

	protected $rec_id;

    public function __construct($query, $rec_id)
    {
        $this->query = $query->select(ApiKey::exportViewFields());
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
			'Provider',
			'Key',
			'Secret',
			'Username',
			'Merchant Id',
			'Email',
			'Phone',
			'Ip Address',
			'Api Url',
			'Callback Url',
			'Token',
			'Created At',
			'Updated At'
        ];
    }


    public function map($record): array
    {
        return [
			$record->id,
			$record->provider,
			$record->key,
			$record->secret,
			$record->username,
			$record->merchant_id,
			$record->email,
			$record->phone,
			$record->ip_address,
			$record->api_url,
			$record->callback_url,
			$record->token,
			$record->created_at,
			$record->updated_at
        ];
    }
}
