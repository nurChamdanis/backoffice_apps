<?php 

namespace App\Exports;
use App\Models\Users;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class UsersListExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
	
	protected $query;
	
    public function __construct($query)
    {
        $this->query = $query->select(Users::exportListFields());
    }
	
    public function query()
    {
        return $this->query;
    }
	
	public function headings(): array
    {
        return [
			'Id',
			'Plan Id',
			'Code',
			'Ref Code',
			'Google Id',
			'Name',
			'First Name',
			'Last Name',
			'Saldo',
			'Markup',
			'Email',
			'Phone',
			'Email Verified At',
			'Pin',
			'Verification Code',
			'Remember Token',
			'Activated',
			'Status',
			'Is Kyc',
			'Is Outlet',
			'Token',
			'Fcm',
			'Signup Ip Address',
			'Signup Confirmation Ip Address',
			'Signup Sm Ip Address',
			'Admin Ip Address',
			'Updated Ip Address',
			'Deleted Ip Address',
			'Created At',
			'Updated At',
			'Device Id'
        ];
    }
	
    public function map($record): array
    {
        return [
			$record->id,
			$record->plan_id,
			$record->code,
			$record->ref_code,
			$record->google_id,
			$record->name,
			$record->first_name,
			$record->last_name,
			$record->saldo,
			$record->markup,
			$record->email,
			$record->phone,
			$record->email_verified_at,
			$record->pin,
			$record->verification_code,
			$record->remember_token,
			$record->activated,
			$record->status,
			$record->is_kyc,
			$record->is_outlet,
			$record->token,
			$record->fcm,
			$record->signup_ip_address,
			$record->signup_confirmation_ip_address,
			$record->signup_sm_ip_address,
			$record->admin_ip_address,
			$record->updated_ip_address,
			$record->deleted_ip_address,
			$record->created_at,
			$record->updated_at,
			$record->device_id
        ];
    }
}
