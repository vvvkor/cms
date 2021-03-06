<?php

namespace vvvkor\cms\Http\Controllers;

//use Illuminate\Database\DatabaseManager;
//use vvvkor\cms\Repositories\SectionRepository as Repo;
//use vvvkor\cms\Models\Section as Section;

class SectionController extends EntityController
{
    
	//protected $entity = 'sections';
	protected $policy = true;
	protected $uniques = ['url'];
	protected $children = [['sections','vvvkor\cms\Http\Controllers\SectionController']];
	protected $lookups = ['sections'=>'name','users'=>'name'];
	
	protected $tabFields  = ['id','url','parent_id','redirect_id','name','h1','enabled','mode','lang','fnm','seq','pub_dt','owner_id'];
	protected $subTabFields  = ['id','url','name','enabled'];
	protected $recFields    = ['url','parent_id','redirect_id','name','h1','enabled','mode','lang','fnm','body','seq','pub_dt','owner_id'];
	protected $newRecFields = [];
	
	protected $fields = [
		//v:validate='', t:type=text, r:relation|[], n:nullable,
		//x:skip_in_query, d:number_decimals, a:auto_value_if_absent_in_request
		'id' => [
			],
		'url' => [
			//'v' => 'required|min:3',
			't' => ''
			],
		'parent_id' => [
			't' => 'select',
			'r' => 'sections',
			'n' => true,
			],
		'name' => [
			],
		'h1' => [
			],
		'enabled' => [
			't' => 'checkbox'
			],
		'fnm' => [
			't' => 'file'
			],
		'body' => [
			't' => 'textarea'
			],
		'redirect_id' => [
			't' => 'select',
			'r' => 'sections',
			'n' => true,
			],
		'mode' => [
			//'v' => 'max:1',
			't' => 'select',
			'r' => ['','a','f'],
			],
		'seq' => [
			't' => 'number'
			],
		'lang' => [
			'v' => 'max:2',
			],
		'pub_dt' => [
			't' => 'datetime-local'
			],
		'owner_id' => [
			't' => 'select',
			'r' => 'users',
			'n' => true,
			],
		];
	
	public function aside($record){
		//parent::aside($record);
		$modes = ['','a','f'];
		$r = '';
		foreach($modes as $mode){
			$d = $this->repo->subsections($record->id, $mode);
			if($d && $d->count()){
				$r .= view('cms::table', [
					'aside' => 1,
					'tag' => $mode,
					'title' => __('cms::list.sections-mode-'.$mode),
					//'model' => 'vvvkor\cms\Models\Section',
					'table' => 'sections',
					'columns' => $this->tableFields(1),
					'records' => $d,
					'root' => $record->id, //for tree
					]);
			}
		}
		return $r;
	}

}
