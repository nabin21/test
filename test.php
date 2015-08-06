<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Converge CSV</title>
</head>

<body>

<?php 

$file_contract=fopen('contracts.csv','r');     //opening a file 'contract';
$file_awards=fopen('awards.csv','r');
while(($data=fgetcsv($file_contract))!=FALSE){
	$contracts_info[]=$data;					//gets all data from contracts file to $contract array
}
while(($data=fgetcsv($file_awards))!=FALSE){
	$awards_info[]=$data;
	}
$con_count=count($contracts_info);	

for($x=0;$x<$con_count;$x++){
	
		if($x==0){
			unset($awards_info[0][0]);
			$data[$x]=array_merge($contracts_info[0],$awards_info[0]);      // merge two common column contractname
			}
			
		else{
			$check=0;
			$award_count=count($awards_info);
			
			for($y=1;$y<$award_count;$y++){
				
				if(isset($awards_info[$y][0])){
					
					if($awards_info[$y][0]==$contracts_info[$x][0])
					{
						unset($awards_info[$y][0]);
						$data[$x]=array_merge($contracts_info[$x],$awards_info[$y]);  // merge data if they have common contract date
						$check=1;
						}
					}
				}
				
				if($check==0){
					$data[$x]=$contracts_info[$x];
					}
				
			}
	}

	$final_data=fopen('final.csv','w');
	foreach($data as $list_data){
		fputcsv($final_data,$list_data);
		}
		fclose($final_data);
		
		$c=0;
		
	
	foreach ($data as $list_data){
		if(($list_data[1]=='Current') && isset($list_data[12]))
		{
			$c+=$list_data[12];                                  // adds amount of current awarded contracts
		
			}
		}
		
	?> Total Amount of Current Contracts: <?php echo $c;
?>
</body>
</html>