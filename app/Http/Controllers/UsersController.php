<?php 
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\UsersRegisterRequest;
use App\Http\Requests\UsersAccountEditRequest;
use App\Http\Requests\UsersAddRequest;
use App\Http\Requests\UsersEditRequest;
use App\Models\Users;
use Illuminate\Http\Request;
use \PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersListExport;
use Exception;
class UsersController extends Controller
{
	

	/**
     * List table records
	 * @param  \Illuminate\Http\Request
     * @param string $fieldname //filter records by a table field
     * @param string $fieldvalue //filter value
     * @return \Illuminate\View\View
     */
	function index(Request $request, $fieldname = null , $fieldvalue = null){
		$view = "pages.users.list";
		$query = Users::query();
		$limit = $request->limit ?? 10;
		if($request->search){
			$search = trim($request->search);
			Users::search($query, $search); // search table records
		}
		$orderby = $request->orderby ?? "users.id";
		$ordertype = $request->ordertype ?? "desc";
		$query->orderBy($orderby, $ordertype);
		$query->where("users.id", auth()->user()->id);
		if($fieldname){
			$query->where($fieldname , $fieldvalue); //filter by a table field
		}
		// if request format is for export example:- product/index?export=pdf
		if($this->getExportFormat()){
			return $this->ExportList($query); // export current query
		}
		$records = $query->paginate($limit, Users::listFields());
		return $this->renderView($view, compact("records"));
	}
	

	/**
     * Select table record by ID
	 * @param string $rec_id
     * @return \Illuminate\View\View
     */
	function view($rec_id = null){
		$query = Users::query();
		$query->where("users.id", auth()->user()->id);
		$record = $query->findOrFail($rec_id, Users::viewFields());
		return $this->renderView("pages.users.view", ["data" => $record]);
	}
	

	/**
     * Display Master Detail Pages
	 * @param string $rec_id //master record id
     * @return \Illuminate\View\View
     */
	function masterDetail($rec_id = null){
		return View("pages.users.detail-pages", ["masterRecordId" => $rec_id]);
	}
	

	/**
     * Update table record with form data
	 * @param string $rec_id //select record by table primary key
     * @return \Illuminate\View\View;
     */
	function edit(UsersEditRequest $request, $rec_id = null){
		$query = Users::query();
		$query->where("users.id", auth()->user()->id);
		$record = $query->findOrFail($rec_id, Users::editFields());
		if ($request->isMethod('post')) {
			$modeldata = $this->normalizeFormData($request->validated());
		
		if( array_key_exists("picture", $modeldata) ){
			//move uploaded file from temp directory to destination directory
			$fileInfo = $this->moveUploadedFiles($modeldata['picture'], "picture");
			$modeldata['picture'] = $fileInfo['filepath'];
		}
			$record->update($modeldata);
			return $this->redirect("users", "Record updated successfully");
		}
		return $this->renderView("pages.users.edit", ["data" => $record, "rec_id" => $rec_id]);
	}
	

	/**
     * Delete record from the database
	 * Support multi delete by separating record id by comma.
	 * @param  \Illuminate\Http\Request
	 * @param string $rec_id //can be separated by comma 
     * @return \Illuminate\Http\Response
     */
	function delete(Request $request, $rec_id = null){
		$arr_id = explode(",", $rec_id);
		$query = Users::query();
		$query->where("users.id", auth()->user()->id);
		$query->whereIn("id", $arr_id);
		$query->delete();
		$redirectUrl = $request->redirect ?? url()->previous();
		return $this->redirect($redirectUrl, "Record deleted successfully");
	}
	

	/**
     * Export table records to different format
	 * supported format:- PDF, CSV, EXCEL, HTML
	 * @param \Illuminate\Database\Eloquent\Model $query
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
	private function ExportList($query){
		ob_end_clean(); // clean any output to allow file download
		$filename = "ListUsersReport-" . date_now();
		$format = $this->getExportFormat();
		if($format == "print"){
			$records = $query->get(Users::exportListFields());
			return view("reports.users-list", ["records" => $records]);
		}
		elseif($format == "pdf"){
			$records = $query->get(Users::exportListFields());
			$pdf = PDF::loadView("reports.users-list", ["records" => $records]);
			return $pdf->download("$filename.pdf");
		}
		elseif($format == "csv"){
			return Excel::download(new UsersListExport($query), "$filename.csv", \Maatwebsite\Excel\Excel::CSV);
		}
		elseif($format == "excel"){
			return Excel::download(new UsersListExport($query), "$filename.xlsx", \Maatwebsite\Excel\Excel::XLSX);
		}
	}
}
