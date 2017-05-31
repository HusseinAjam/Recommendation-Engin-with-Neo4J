<?php
$test = array(1,2,3,4,5,6,7,8,9);
 
function onDTo2D ($array, $col_count=2){
    
	$result = false;
	if(!empty($array) && is_array($array)){
		$row_count = ceil( count($array) / $col_count);
		$pointer = 0;
		for($row=0; $row < $row_count; $row++) {
			for($col=0; $col < $col_count; ++$col){
				if(isset($array[$pointer])) {
					$result[$row][$col] = $array[$pointer];
					$pointer++;
				}
			}
		}
	}
	return $result;
}

$result = onDTo2D($test, 3);


    $rows = count($result);
     for ($row = 0; $row < $rows; $row++) {
     $cols = count($result[$row]);
     for($col = 0; $col < $cols; $col++ ) {
         echo $result[$row][$col]." ";
     }
         echo '</br>';
}

?>



    
