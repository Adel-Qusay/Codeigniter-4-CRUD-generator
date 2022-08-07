<?php
/*
==========================================================================
                   ADEL CODEIGNITER 4 CRUD GENERATOR            
==========================================================================
برمجة وتطوير: عادل قصي
البريد الإلكتروني: adelbak2014@gmail.com
الموقع الرسمي: www.e-net.xyz
الصفحة الرسمية للمبرمج: https://www.facebook.com/adel.qusay.9
==========================================================================
*/

class Engine
{	
	
	Public $config;
	
	function __construct($config)
	{
		$this->config = $config;
	}		
	
	public function getDatabases()
	{
		$db = mysqli_connect ($this->config['HOST'], $this->config['USER'], $this->config['PASS']);
		
		if(!$db) die("Database error");

		$result = mysqli_query($db,"show DATABASES");

		$databaseList = null;
		
		while($databases = mysqli_fetch_array($result))
		{

			$databaseList[]= $databases[0];
		}

		return $databaseList;

	}

	public function getTablesByDatabase($_FPOST)
	{    
		$_POST = $this->sanitize($_FPOST); 
		
		$db = mysqli_connect ($this->config['HOST'], $this->config['USER'], $this->config['PASS'], $_POST['database']);
		
		if(!$db) die("Database error");
	
		$result = mysqli_query($db,"SHOW TABLES FROM `".$_POST['database']."`");
		
		$tablesListHtml = '<option value="" selected="selected">-- Select --</option>';

		while($table = mysqli_fetch_array($result))
		{
			$tablesListHtml .= '<option value="' . $table[0] . '">' . $table[0] .'</option>';
		}

		die($tablesListHtml);

	}
	
	public function getPrimaryColumnsByTable($_FPOST)
	{    
		$_POST = $this->sanitize($_FPOST); 
		
		$db = mysqli_connect ($this->config['HOST'], $this->config['USER'], $this->config['PASS'], $_POST['database']);
		
		if(!$db) die("Database error");
		
		$result = mysqli_query($db,'SHOW KEYS FROM `'.$_POST['table'].'` WHERE Key_name = \'PRIMARY\'');

		$primaryColumnsListHtml = '';

		while($column = mysqli_fetch_array($result))
		{
			$primaryColumnsListHtml .= '<option value="' .trim($column['Column_name']).'">' . trim($column['Column_name']).'</option>';
		}

		die ($primaryColumnsListHtml);
	}
	
	public function getColumnsByTable($_FPOST)
	{    
		$_POST = $this->sanitize($_FPOST); 
		
		$db = mysqli_connect ($this->config['HOST'], $this->config['USER'], $this->config['PASS'], $_POST['database']);
		
		if(!$db) die("Database error");
		
		$result = mysqli_query($db,"DESC ".$_POST['table']);
		$pkResult = mysqli_fetch_array(mysqli_query($db,'SHOW KEYS FROM `'.$_POST['table'].'` WHERE Key_name = \'PRIMARY\''));

		$columnsListHtml = '<ul class="list-group">';

		while($column = mysqli_fetch_array($result))
		{
            $disabled = ( $column[0] == trim((isset($pkResult['Column_name'])?$pkResult['Column_name']:'')))? 'disabled' : '';
			//list-group-item-action d-flex justify-content-between align-items-center
			$columnsListHtml .='<li class="list-group-item list-group-item-action justify-content-between align-items-center">
								<div ><b style="color:blue">Table Field: '. $column[0] .' | Max Length: [' . $this->getBetween($column[1], '(', ')') .']</b></div>
								<div class="row">
								<input type="text" name="column[]" id="column" class="form-control" value="'.$column[0].'" placeholder="" maxlength="50" hidden>
								<input type="hidden" name="unique[] id="unique" value="'.(strpos($column[3], 'UNI') !== false ? '1' : '0').'">
								<!--Name Disable ห้ามแก้ไข เพราะใช้ Validation แบบ getErrors แทน SweetAlert-->	
								<input type="hidden" name="name[]" id="name" class="form-control" value="'.$this->snakeToCamel($column[0]).'" placeholder="" maxlength="50" required>
								<!--<div class="col-md-2">
									<div class="form-group">
										<label for="name" class="form-label">Name/ID:</label>
										<input type="text" name="name[]" id="name" class="form-control" value="'.$this->snakeToCamel($column[0]).'" placeholder="" maxlength="50" required>
									</div>
								</div>-->
								<!--Label-->
								<div class="col-md-2">
									<div class="form-group">
										<label for="label" class="form-label">Label:</label>
										<input type="text" name="label[]" id="label" class="form-control" value="'.$this->colToLabel($column[0]).'" placeholder="" maxlength="50" required>
									</div>
								</div>	
								<!--Input Type-->	
								<div class="col-md-2">
									<div class="form-group">
										<label for="iType" class="form-label">Input type:</label>
										<select class="form-control" name="iType[]" id="iType">
											<option value="1" '.(strpos($column[1], 'var') !== false ? 'selected="selected"' : "").'>Text field</option>
											<option value="2" '.(strpos($column[1], 'int') !== false ? 'selected="selected"' : "").'>Number field</option>
											<option value="3" '.(strpos($column[0], 'pass') !== false ? 'selected="selected"' : "").'>Password field</option>
											<option value="4" '.(strpos($column[0], 'email') !== false ? 'selected="selected"' : "").'>Email field</option>
											<option value="5" '.(strpos($column[1], 'text') !== false ? 'selected="selected"' : "").'>Text area</option>
											<option value="6">Select</option>
											<option value="7" '.(strpos('datetimestampyear',$column[1]) !== false ? 'selected="selected"' : "").'>Date</option>
										</select>
									</div>
								</div>	
								<!-- เพิ่ม Min Length & Max Length ดึงจาก Database แทน-->									
								<div class="col-md-2">
									<div class="form-group">
										<label for="minlength" class="form-label">Min length:</label>
										<input type="number" name="minlength[]" id="minlength" class="form-control" value="0" placeholder="" number="true" min="0">
									</div>
									<div>
									<input type="hidden" name="maxlength[]" id="maxlength" class="form-control" value="'. $this->getBetween($column[1], '(', ')').'" placeholder="" number="true" >
									</div>
								</div>	
								<!--Required-->							
								<div class="col-md-2">
									<div class="form-group mb-3">
										<label for="required" class="form-label">Required:</label>
										<select class="form-control" name="required[]" id="required" required>
											<option value="1" '.(strpos($column[2], 'NO') !== false ? 'selected="selected"' : "").'>Y</option>
											<option value="0" '.(strpos($column[2], 'YES') !== false ? 'selected="selected"' : "").'>N</option>
										</select>
									</div>
								</div>	
								<!--Show In DataTables-->	
								<div class="col-md-2">
									<div class="form-group mb-3">
										<label for="dtShow" class="form-label">Show in Table:</label>
										<select class="form-control" name="dtShow[]" id="dtShow" required>
										  <option value="1" selected>Y</option>
										  <option value="0">N</option>
										</select>
									</div>
								</div>
								<!--Remove-->
								<div class="col-md-2 text-right">
									<div class="form-group mb-3">
										<a class="btn btn-danger mt-4 '.$disabled.'" href="#"><i class="fa fa-trash"></i></a>
									</div>
								</div>									
							</div>
							</li>';
		}
		die ($columnsListHtml.'</ul>');
	}
	
	public function generate($_FPOST)
	{
		$_POST = $this->sanitize($_FPOST); 
		
		$crudLang = $_POST['crudLang'];
		$crudTitle = $_POST['crudTitle'];
		$controlerName = lcfirst(preg_replace("/[^A-Za-z0-9]/", "", $_POST['crudName']));
		$uControlerName = ucfirst($controlerName);
		$modelName = $controlerName.'Model';
		$uModelName = ucfirst($modelName);
		$crudName = $_POST['crudName'];
		$table = $_POST['table'];
		$primaryKey = $_POST['primaryKey'];
		$column = $_POST['column'];			
		$label = $_POST['label'];
		$name = $_POST['name'];
		$iType = $_POST['iType'];
		$minlength = $_POST['minlength']; //new features
		$maxlength = $_POST['maxlength'];
		$required = $_POST['required'];
		$unique = $_POST['unique']; //new features
		$dtShow = $_POST['dtShow'];
		$response = array();		
		$htmlInputs = '<div class="row">'."\n";
		$ciSelect = '';			
		$ciFields = '';
		$ciValidation = '';	
		$ciDataTable = '';
		$htmlDataTable = '';
		$allowedFields = '';
		$htmlEditFields = '';
		
		if (!isset($crudLang) || $crudLang =='' || !isset($crudName) || $crudName =='' || !isset($crudTitle) || $crudTitle =='' || !isset($table) || $table =='' || !isset($primaryKey) || $primaryKey ==''){ 			
			$response['success'] = false;
			$response['message'] = 'Please fill all required fields.';			
			die(json_encode($response));			
		}
		
		for ($i=0; $i < count($column); $i++) {
			$inputlabel = (isset($label[$i]) AND $label[$i] != '')? $label[$i] : '';
			$inputName = (isset($column[$i]) AND $column[$i] != '')? $column[$i] : '';
			$inputMinlength = (isset($minlength[$i]) AND $minlength[$i] != '')? ' minlength="'.$minlength[$i].'"' : '';
			$inputMaxlength = (isset($maxlength[$i]) AND $maxlength[$i] != '')? ' maxlength="'.$maxlength[$i].'"' : ''; //defined by database
			$inputRequired = (isset($required[$i]) AND $required[$i] == 1)? 'required' : '';
			$htmlInputRequired = (isset($required[$i]) AND $required[$i] == 1)? '<span class="text-danger">*</span> ' : '';
			$crudShow = (isset($name[$i]) AND $name[$i] != '')? 1 : 0;	
			$ciValidationMinlength = (isset($minlength[$i]) AND $minlength[$i] != '')? '|min_length['.$minlength[$i].']' : '';	
			$ciValidationMaxlength = (isset($maxlength[$i]) AND $maxlength[$i] != '')? '|max_length['.$maxlength[$i].']' : '';
			$ciValidationRequired = (isset($required[$i]) AND $required[$i] == 1)? 'required' : 'permit_empty';
			$ciValidationUnique = (isset($unique[$i]) AND $unique[$i] == 1)? '|is_unique['.$table.'.'.$column[$i]. ','. $primaryKey. ',{'. $primaryKey . '}]' : '';			
			$ciValidationType = '';	
			
			if($column[$i] == trim($primaryKey)){
				$htmlInputs .='<input type="hidden" id="'.$inputName.'" name="'.$inputName.'" class="form-control" placeholder="'.$inputlabel.'"'.$inputMaxlength.' '.$inputRequired.'>'."\n";
			
				$ciValidationType = '|numeric';														

			}elseif($iType[$i] == '1' && $crudShow == '1') { 
				$htmlInputs .= '							<div class="col-md-12">
								<div class="form-group mb-3">
									<label for="'.$inputName.'" class="col-form-label"> '.$inputlabel.': '.$htmlInputRequired.'</label>
									<input type="text" id="'.$inputName.'" name="'.$inputName.'" class="form-control" placeholder="'.$inputlabel.'"'.$inputMinlength.' '.$inputMaxlength.' '.$inputRequired.'>
								</div>
							</div>'."\n";
						
			}elseif($iType[$i] == '2' && $crudShow == '1') {
				$htmlInputs .= '							<div class="col-md-12">
								<div class="form-group mb-3">
									<label for="'.$inputName.'" class="col-form-label"> '.$inputlabel.': '.$htmlInputRequired.'</label>
									<input type="number" id="'.$inputName.'" name="'.$inputName.'" class="form-control" placeholder="'.$inputlabel.'"'.$inputMinlength.' '.$inputMaxlength.' '.$inputRequired.'>
								</div>
							</div>'."\n";
				
				$ciValidationType = '|numeric';														
			}elseif($iType[$i] == '3' && $crudShow == '1') {//password input
				$htmlInputs .= '							<div class="col-md-12">
								<div class="form-group mb-3">
									<label for="'.$inputName.'" class="col-form-label"> '.$inputlabel.': '.$htmlInputRequired.'</label>
									<input type="password" id="'.$inputName.'" name="'.$inputName.'" class="form-control" placeholder="'.$inputlabel.'"'.$inputMinlength.' '.$inputMaxlength.' '.$inputRequired.'>
								</div>
							</div>'."\n";
				
			}elseif($iType[$i] == '4' && $crudShow == '1') {//email input
				$htmlInputs .= '							<div class="col-md-12">
								<div class="form-group mb-3">
									<label for="'.$inputName.'" class="col-form-label"> '.$inputlabel.': '.$htmlInputRequired.'</label>
									<input type="email" id="'.$inputName.'" name="'.$inputName.'" class="form-control" placeholder="'.$inputlabel.'"'.$inputMinlength.' '.$inputMaxlength.' '.$inputRequired.'>
								</div>
							</div>'."\n";
				$ciValidationType = '|valid_email';
														
			}elseif($iType[$i] == '5' && $crudShow == '1') {
				$htmlInputs .= '							<div class="col-md-12">
								<div class="form-group mb-3">
									<label for="'.$inputName.'" class="col-form-label"> '.$inputlabel.': '.$htmlInputRequired.'</label>
									<textarea cols="40" rows="5" id="'.$inputName.'" name="'.$inputName.'" class="form-control" placeholder="'.$inputlabel.'"'.$inputMinlength.' '.$inputMaxlength.' '.$inputRequired.'></textarea>
								</div>
							</div>'."\n";
									
			}elseif($iType[$i] == '6' && $crudShow == '1') {
				$htmlInputs .= '							<div class="col-md-12">
								<div class="form-group mb-3">
									<label for="'.$inputName.'" class="col-form-label"> '.$inputlabel.': '.$htmlInputRequired.'</label>
									<select id="'.$inputName.'" name="'.$inputName.'" class="form-select" '.$inputRequired.'>
										<option value="select1">select1</option>
										<option value="select2">select2</option>
										<option value="select3">select3</option>
									</select>
								</div>
							</div>'."\n";
								
			}elseif($iType[$i] == '7' && $crudShow == '1') {
				$htmlInputs .= '<div class="col-md-12">
								<div class="form-group mb-3">
									<label for="'.$inputName.'" class="col-form-label"> '.$inputlabel.': '.$htmlInputRequired.'</label>
									<input type="date" id="'.$inputName.'" name="'.$inputName.'" class="form-control" dateISO="true" '.$inputRequired.'>
								</div>
							</div>'."\n";
									
				$ciValidationType = '|valid_date';								
			}else{
				$htmlInputs .= '<div class="row">'."\n"; $htmlInputs .='<input type="text" id="'.$inputName.'" name="'.$inputName.'" class="form-control" placeholder="'.$inputlabel.'"'.$inputMinlength.' '.$inputMaxlength.' '.$inputRequired.'>'."\n";					
				
			}
			
			$ciFields .= '$fields[\''.$column[$i].'\'] = $this->request->getPost(\''.$inputName.'\');'."\n";
			
			if($column[$i] != $primaryKey) $ciValidation .= '            \''.$column[$i].'\' => [\'label\' => \''.$inputlabel.'\', \'rules\' => \''.$ciValidationRequired.$ciValidationType.$ciValidationMinlength.$ciValidationMaxlength.$ciValidationUnique.'\'],'."\n";
			if($dtShow[$i] == '1'){
				$ciDataTable .= '$value->'.$column[$i].','."\n";
				$htmlDataTable .= '<th>'.$inputlabel.'</th>'."\n";
				$ciSelect .= $column[$i].', ';
			}
			if($column[$i] != $primaryKey) $allowedFields .= '\''.$column[$i].'\', ';
			if(($i % 10 == 0))  {$htmlInputs .= '						</div>'."\n"; $htmlInputs .= '						<div class="row">'."\n"; }
			if(!next($column)) {$htmlInputs .= '						</div>'."\n";}
			if($crudShow == '1') $htmlEditFields .= '			$("#data-form #'.$inputName.'").val(response.'.$column[$i].');'."\n";
		}	

		$ciSelect = substr($ciSelect, 0, -2);
		$allowedFields = substr($allowedFields, 0, -2);
		
		$model = file_get_contents(MVC_TPL .'/Model.tpl.php');
		$controler = file_get_contents(MVC_TPL .'/Controler.tpl.php');
		$view = file_get_contents(MVC_TPL .'/View.tpl.php');
		
		$find   = ['@@@table@@@','@@@primaryKey@@@', '@@@allowedFields@@@', '@@@controlerName@@@', '@@@uControlerName@@@' , '@@@modelName@@@' , '@@@uModelName@@@', '@@@crudTitle@@@', '@@@htmlInputs@@@', '@@@ciFields@@@', '@@@ciValidation@@@', '@@@ciDataTable@@@', '@@@htmlDataTable@@@', '@@@htmlEditFields@@@', '@@@ciSelect@@@'];
		$replace   = [$table, $primaryKey, $allowedFields, $controlerName, $uControlerName , $modelName , $uModelName, $crudTitle, $htmlInputs, $ciFields, $ciValidation, $ciDataTable, $htmlDataTable, $htmlEditFields, $ciSelect];

		$model = str_replace($find, $replace, $model);
		$controler = str_replace($find, $replace, $controler);
		$view = str_replace($find, $replace, $view);
		
		file_put_contents(DOWNLOADS .'/Models/'.$uModelName.'.php',$model);
		file_put_contents(DOWNLOADS .'/Controllers/'.$uControlerName.'.php',$controler);
		file_put_contents(DOWNLOADS .'/Views/'.$controlerName.'.php',$view);
		
		$response['success'] = true;
		$response['message'] = '<a class="text-white" href="'.BASE_URL .'/download.php?t=c&f='.$uControlerName.'.php'.'" target="_blank">('.$uControlerName.'.php'.') Controler</a>
		<br><a class="text-white" href="'.BASE_URL .'/download.php?t=m&f='.$uModelName.'.php'.'" target="_blank">('.$uModelName.'.php'.') Model</a>
		<br><a class="text-white" href="'.BASE_URL .'/download.php?t=v&f='.$controlerName.'.php'.'" target="_blank">('.$controlerName.'.php'.') View</a>
		<br><p>Looking "download/template-bs5.zip and read readme.txt first!"</p>';
		
		die(json_encode($response));
	}
		
	public function getBetween($string, $start, $end){
	  $string = ' ' . $string;
	  $ini = strpos($string, $start);
	  if ($ini == 0) return '';
	  $ini += strlen($start);
	  $len = strpos($string, $end, $ini) - $ini;
	  //fix bug: example >> decimal(8,2)
	  $result = substr($string, $ini, $len);
	  $ini = strpos($result, ',');
	  if($ini != false){
	    $result = substr($result,0,$ini);
	  }
	  return $result;
	}
	
	public function snakeToCamel($str) {
	  return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $str))));
	}
	
	public function colToLabel($str) {
	  return ucfirst(str_replace('_', ' ', $str));
	}		
	
	public function sanitize(array $input, array $fields = array() , $utf8_encode = true)
	{
		if (empty($fields))
		{
			$fields = array_keys($input);
		}
		$return = array();
		foreach($fields as $field)
		{
			if (!isset($input[$field]))
			{
				continue;
			}
			else
			{
				$value = $input[$field];
				if (is_array($value))
				{
					$value = $this->sanitize($value);
				}
				if (is_string($value))
				{
					if (strpos($value, "\r") !== false)
					{
						$value = trim($value);
					}
					if (function_exists('iconv') && function_exists('mb_detect_encoding') && $utf8_encode)
					{
						$current_encoding = mb_detect_encoding($value);
						if ($current_encoding != 'UTF-8' && $current_encoding != 'UTF-16')
						{
							$value = iconv($current_encoding, 'UTF-8', $value);
						}
					}
					$value = filter_var($value, FILTER_SANITIZE_STRING);
				}
				$return[$field] = $value;
			}
		}
		return $return;
	}
	
}
