<?php
$selectColumn = htmlspecialchars($_POST['selectColumn']);
$selectColumnArray = explode('-',$selectColumn);
$searchStr = htmlspecialchars($_POST['searchStr']);
//find in xml
$xml = simplexml_load_file('./xml/big.xml');
$resultArray = array();
foreach ($xml->mods as $child){
	if($selectColumn == 'name'){
		$tmp = '';
		foreach($child->name as $name){
			if($name->namePart){
				foreach ($name->namePart as $child2)
					$tmp .= (string)$child2.' ';
			}else if($name){
				foreach($name as $nameValue)
					$tmp .= (string)$nameValue->namePart[1].' '.(string)$nameValue->namePart[0];
			}
			//echo $tmp,'<br/>';
		}
		if(strpos($searchStr,' ')>-1){
			$peoplenameArr = explode(' ',$searchStr);
		}else{
			$peoplenameArr = mb_str_split($searchStr);
		}
		$flag = 1;
		foreach($peoplenameArr as $nameValue2){
			if(strpos($tmp,$nameValue2)===false){
				$flag = 0;
				break;
			}
		}
		
		/*var_dump($tmp);
		die();*/
		if($flag == 1)
			array_push($resultArray,$child);
	}else if(isset($child->$selectColumnArray[0])){
		$tmpObj = $child->$selectColumnArray[0];
		for($i = 0; $i<count($tmpObj); $i++){
			if(isset($selectColumnArray[1])){
					if(isset($selectColumnArray[2])){
						if(stripos((string)$tmpObj[$i]->$selectColumnArray[1]->$selectColumnArray[2],$searchStr)>-1){
							array_push($resultArray,$child);
						}
					}else{
							//要把物件轉成陣列
								//var_dump($tmpObj[$i]);
						if(stripos((string)$tmpObj[$i]->$selectColumnArray[1],$searchStr)>-1){
							array_push($resultArray,$child);
						}
					}
			}else{
				if(stripos((string)$tmpObj,$searchStr)>-1){
					array_push($resultArray,$child);
				}
			}
		}
	}
}
//var_dump($resultArray);
foreach ($resultArray as $value){
	echo '<div class="fromGerman">';
	foreach($value->name as $nameValue){
		echo '<p>',(string)$nameValue->role->roleTerm,' : ';
		$engNameStr = '';
		$chiNameStr = '';
		foreach($nameValue as $nameValue2){
			if((string)$nameValue2->attributes()->lang=='chi'){
				if((string)$nameValue2->attributes()->type=='family'){
					if((string)$nameValue2->attributes()->script=='Hant')
						$chiNameStr = (string)$nameValue2.$chiNameStr;
					else
						$engNameStr = (string)$nameValue2.' '.$engNameStr;
				}else{
					if((string)$nameValue2->attributes()->script=='Hant')
						$chiNameStr = $chiNameStr.(string)$nameValue2;
					else
						$engNameStr = $engNameStr.' '.(string)$nameValue2;
				}
			}else if((string)$nameValue2->attributes()->lang=='eng'){
				if((string)$nameValue2->attributes()->lang=='family')
					$engNameStr = (string)$nameValue2.$engNameStr;
				else
					$engNameStr = $engNameStr.(string)$nameValue2;
			}
		}
		echo str_ireplace($searchStr,'<span class="red">'.$searchStr.'</span>',$engNameStr.' '.$chiNameStr),' <a href="./index.php?selectColumn=name&searchStr=',$chiNameStr,'">find this</a></p>';
	}
	foreach($value->titleInfo as $titleInfoValue){
		if((string)$titleInfoValue->attributes()->type){
			if((string)$titleInfoValue->attributes()->transliteration)
				echo '<p>',(string)$titleInfoValue->attributes()->transliteration;
			else
				echo '<p>',(string)$titleInfoValue->attributes()->lang;
		}else
			echo (string)$titleInfoValue->attributes()->lang;
		
		echo ' title : ',str_ireplace($searchStr,'<span class="red">'.$searchStr.'</span>',(string)$titleInfoValue->title),'</p>';
	}
	foreach($value->originInfo as $originInfoValue){
		if($originInfoValue->place)
		echo '<p>publish place : ',$originInfoValue->place->placeTerm[0],' ',$originInfoValue->place->placeTerm[1],'</p>';
		if($originInfoValue->publisher)
		echo '<p>publisher : ',$originInfoValue->publisher[0],' ',$originInfoValue->publisher[1],'</p>';
		if($originInfoValue->dateIssued)
		echo '<p>publish time: ',$originInfoValue->dateIssued,'</p>';
	}
	$flag = 0;
	foreach($value->note as $note){
		if((string)$note->attributes()->type == 'citation'){
			$flag = 1;
			echo '<p>citation : ',(string)$note,'</p>';
		}
		if((string)$note->attributes()->type == 'price')
			echo '<p>price : ',(string)$note,'</p>';
	}
	foreach($value->abstract as $abstract){
		if((string)$abstract->attributes()->type == 'summary'){
			$flag = 1;
			echo '<p>summary : ',(string)$abstract,'</p>';
		}
	}
	if($flag == 0)
		echo '<p><a href="http://kjc-sv016.kjc.uni-heidelberg.de:8080/exist/apps/tamboti/modules/search/index.html?search-field=ID&value=' ,$value->attributes()->ID, '" target="_blank">link</a></p>';
	echo '</div>';
}
function mb_str_split( $string ) { 
    # Split at all position not after the start: ^ 
    # and not before the end: $ 
    return preg_split('/(?<!^)(?!$)/u', $string ); 
}
?>