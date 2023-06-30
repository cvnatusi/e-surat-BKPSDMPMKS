<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\LogActivity;
use DataTables,Validator,DB,Hash,Auth,File,Storage;
class LogActivityController extends Controller
{
	private $title = "Log Activity";
	private $menuActive = "laporan";
	private $submnActive = "log-activity";

	public function index(Request $request)
	{
		$this->data['title'] = $this->title;
		$this->data['menuActive'] = $this->menuActive;
		$this->data['submnActive'] = $this->submnActive;
		$this->data['smallTitle'] = "";
		if ($request->ajax()) {
			$data = LogActivity::with('users')->orderBy('id','desc')->limit(500)->get();
			return Datatables::of($data)
				->addIndexColumn()
				->addColumn('pengguna', function($row){
					$btn = $row->users ? ($row->users->name.'<br>'.$this->level_name($row->users->level_user)) : '-';
					return $btn;
				})
				->addColumn('action', function($row){
					$btn = '<a href="javascript:void(0)" onclick="showForm('.$row->id.')" style="margin-right: 5px;" class="btn btn-md btn-info "><i class="bx bx-show me-0"></i> SHOW</a>';
					return $btn;
				})
				->rawColumns(['pengguna','action'])
				->make(true);
		}
		return view($this->menuActive.'.'.$this->submnActive.'.'.'main')->with('data',$this->data);
}

public function show(Request $request)
{
	try {
		$data['data'] = (!empty($request->id)) ? LogActivity::with('users')->find($request->id) : "";
		if ($data['data']->log_type == 'edit') {
			$dataDetail = json_decode($data['data']->data);
			$table = $data['data']->table_name;
			if (!empty($dataDetail->id)) {
				$id = $dataDetail->id;
				$logId = $data['data']->id;
				$currentData = DB::table($table)->find($id);
				if ($currentData) {
					$editHistory = LogActivity::with('users')
					->orderBy('log_date', 'desc')
					->whereNotIn('id', [$logId])
					->where(['table_name' => $table, 'log_type' => 'edit'])
					->whereRaw('data like ?', array('%"id":"' . $id . '"%'))
					->get();
					// return ['current_data' => $currentData, 'edit_history' => $editHistory];
				}
			}
		}
		$content = view($this->menuActive.'.'.$this->submnActive.'.'.'show', $data)->render();
		return ['status' => 'success', 'content' => $content, 'data' => $data];
	} catch (\Exception $e) {
		throw($e);
		return ['status' => 'error', 'content' => '','errMsg'=>$e];
	}
}
public function level_name($id)
{
	if ($id == '1') {
		$return = 'Admin';
	} elseif ($id == '2') {
		$return = 'KABAN';
	} elseif ($id == '3') {
		$return = 'KABID';
	} elseif ($id == '4') {
		$return = 'SEKRETARIS';
	}elseif ($id == '5') {
		$return = 'OPERATOR';
	} else {
		$return = $id;
	}
	return $return;
}

}
