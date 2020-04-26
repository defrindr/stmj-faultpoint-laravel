<?php
namespace App\Helpers\Traits;

Trait GridviewTrait {

	public static $template;
	public static $options;
	public static $actionButtons;
	public static $paginate;
	public static $perPage;
	public static $pageNum;
	public static $numbering;
	public static $data;
	public static $routes;
	public static $headerTitles = [];
	public static $numIndex = 0;
	public static $withouts = [];


	public static function build(){

		// dd(self::$data);

		self::$numIndex = ( (self::$pageNum * self::$perPage) - self::$perPage );

		self::generateFormSearch();

		self::$template .= '
			<div class="table-responsive-sm">
				<table ';

		self::renderAttributes();

		self::$template .= '>';

		self::$template .= "<thead>";

		if(count(self::$data) > 0){

			self::$headerTitles = array_keys(self::$data[0]->getAttributes());

			self::generateHeader();
			
			foreach (self::$data as $rows) {
				$row = $rows->getAttributes();
				
				if(self::$withouts != []){
					foreach (self::$withouts as $element) {
						unset($row[$element]);
					}
				}

				self::$template .= "<tr>";

				self::generateColumnNumbers();

				
				foreach ($row as $attr) {
					self::$template .= "<td>";
					self::$template .= $attr;
					self::$template .= "</td>";
				}


				self::generetaActionButtons($rows);


				self::$template .= "</tr>";
			}
		} else {
			self::$template .= "<tr>";
			self::$template .= "<td> Tidak ada data tersedia. </td>";
			self::$template .= "</tr>";
		}

		self::$template .= "</table></div>";

		self::paginate();

		return new self;
	}


	private static function generateFormSearch(){

		self::$template = '
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-6 col-xs-12 mb-2">
					<p style="font-size: 18px;color:#aaa">Total : <b>'. self::$data->total() .'</b> Data </p>
				</div>
				<div class="col-md-6 col-md-6 col-xs-12 mb-2">
					<form action=' . route(\Route::current()->getName()) . ' class="form form-horizontal" >
						<div class="form-group row">
							<div class="col-sm-6 mb-2">
								<input type="text" placeholder="Masukkan Kata Kunci" name="query" style="margin-right:5px;" class="form-control">
							</div>
							<div class="col-sm-3 mb-2">
								<button class="btn btn-success btn-block">Search</button>
							</div>
							<div class="col-sm-3 mb-2">
								<a href="'. route(\Route::current()->getName()) .'" class="btn btn-danger  btn-block">Clear</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>';

		return new self;
	}


	public static function generetaActionButtons($rows){
		if(self::$actionButtons){
			self::$template .= "<td>";
			foreach (self::$actionButtons as $act) {
				switch ($act) {
					case 'show':
						$actTemplate = \HtmlHelper::a(
							route(self::$routes . '.show',[self::$routes => $rows]),
							[
								'class' => 'btn mr-1 mt-1 btn-success'
							])->label('Show')->get();
						break;
					
					case 'edit':
						$actTemplate = \HtmlHelper::a(
							route(self::$routes . '.edit',[self::$routes => $rows]),
							[
								'class' => 'btn mr-1 mt-1 btn-primary'
							])->label('Ubah')->get();
						break;
					
					case 'delete':
						$actTemplate = '<form style="display:inline-block" method="post" action="' . route(self::$routes . '.destroy',[self::$routes => $rows]) . '"><input type="hidden" name="_token" value="'.csrf_token().'"><input type="hidden" name="_method" value="delete">' . \HtmlHelper::submit(['class' => 'btn btn-danger mr-1 mt-1'])->label('Delete')->get() . '</form>';
						break;
					
					default:
						break;
				}
				self::$template .= $actTemplate;
			}
			self::$template .= "</td>";
		}

		return new self;

	}






	private static function generateColumnNumbers(){

		if(self::$numbering){
			self::$numIndex++;
			self::$template .= "<td>".self::$numIndex."</td>";
		}
	}





	private static function generateHeader($color="#000"){

			if(self::$numbering){
				self::$template .= "<th style='color:". $color ."'>";
				self::$template .= "#";
				self::$template .= "</th>";
			}
	
			if(self::$withouts != []){
				foreach (self::$withouts as $element) {
					if (($key = array_search($element, self::$headerTitles)) !== false) unset(self::$headerTitles[$key]);
				}
			}


			foreach (self::$headerTitles as $row) {
				self::$template .= "<th style='color:". $color ."'>";
				self::$template .= ucwords(str_replace('_',' ',$row));
				self::$template .= "</th>";
			}

			if(self::$actionButtons != []){
				self::$template .= "<th style='color:". $color ."'>";
				self::$template .= "Action";
				self::$template .= "<th>";
			}

			self::$template .= "</thead>";

			return new self;
	}


	private static function paginate(){

		if(self::$paginate){
			$paginationTemplate = self::$data->links(); 
			self::$template .= '<div class="mb-3"></div>'.$paginationTemplate;
		} 

		return new self;
	}




	private static function renderAttributes(){
		foreach (self::$options as $key => $value) {
			if($value != ""){
				if($key == "class"){
					self::$template .= $key. "='table " . $value . "' ";
				}else {

					self::$template .= $key. "='" . $value . "' ";
				}
			}
		}

		return new self;
	}



	public static function dgv($data,$options = [],$paginate=false,$perPage = 5,$pageNum = 1){
		// default value
		self::$options = array_replace([
			'id' => 'laravel_gridview_id',
			'class' => ''
		], $options);

		self::$paginate = $paginate;
		self::$perPage = $perPage;
		self::$pageNum = $pageNum;

		self::$data = $data;

		return new self;
	}




	public static function actions($routes,$actionButtons = ['show', 'edit', 'delete']){
		self::$routes = $routes;
		self::$actionButtons = $actionButtons;

		return new self;
	}





	public static function numbering($numbering=true){
		self::$numbering = $numbering;

		return new self;
	}

	public static function withouts($arr = []){
		self::$withouts = $arr;

		return new self;
	}
}