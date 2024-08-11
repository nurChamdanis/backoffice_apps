<?php 

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Modules\Users\App\Models\Banner;

class BannersViewExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
	protected $query;
	protected $rec_id;

    public function __construct($query, $rec_id)
    {
        $this->query = $query->select(Banner::exportViewFields());
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
			'Title',
			'Subtitle',
			'Type',
			'Link',
			'Image',
			'Created At',
			'Updated At'
        ];
    }


    public function map($record): array
    {
        return [
			$record->id,
			$record->title,
			$record->subtitle,
			$record->type,
			$record->link,
			$record->image,
			$record->created_at,
			$record->updated_at
        ];
    }
}
