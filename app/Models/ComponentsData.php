<?php 
namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
/**
 * Components data Model
 * Use for getting values from the database for page components
 * Support raw query builder
 * @category Model
 */
class ComponentsData{
	

	/**
     * token_option_list Model Action
     * @return array
     */
	function token_option_list(){
		$sqltext = "SELECT id as value, name_membership as label FROM membership";
		$query_params = [];
		$arr = DB::select($sqltext, $query_params);
		return $arr;
	}
	

	/**
     * user_id_option_list Model Action
     * @return array
     */
	function user_id_option_list(){
		$sqltext = "SELECT id as value, name as label FROM users";
		$query_params = [];
		$arr = DB::select($sqltext, $query_params);
		return $arr;
	}
	

	/**
     * typeid_option_list Model Action
     * @return array
     */
	function typeid_option_list(){
		$sqltext = "SELECT id as value, name as label FROM laravel_blocker_types";
		$query_params = [];
		$arr = DB::select($sqltext, $query_params);
		return $arr;
	}
	

	/**
     * permission_id_option_list Model Action
     * @return array
     */
	function permission_id_option_list(){
		$sqltext = "SELECT id as value, name as label FROM permissions";
		$query_params = [];
		$arr = DB::select($sqltext, $query_params);
		return $arr;
	}
	

	/**
     * role_id_option_list Model Action
     * @return array
     */
	function role_id_option_list(){
		$sqltext = "SELECT id as value, name as label FROM roles";
		$query_params = [];
		$arr = DB::select($sqltext, $query_params);
		return $arr;
	}
	

	/**
     * theme_id_option_list Model Action
     * @return array
     */
	function theme_id_option_list(){
		$sqltext = "SELECT id as value, name as label FROM themes";
		$query_params = [];
		$arr = DB::select($sqltext, $query_params);
		return $arr;
	}
}
