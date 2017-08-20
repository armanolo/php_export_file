<?php
//Require DB class
require_once 'DB.php';
?>


<html>
	<head>
		<title>Task - Manuel Martin Martin</title>
		<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
		<style type="text/css">
			.button_class_delete{
				background-color: red; /* Red */
    			border: none;
			    color: white;
			    padding: 2% 2%;
			    text-align: center;
			    text-decoration: none;
			    display: inline-block;
			    font-size: 16px;
			}
			.button_class_new{
				background-color: #4CAF50; /* Green */
    			border: none;
			    color: white;
			    padding: 2% 2%;
			    text-align: center;
			    text-decoration: none;
			    display: inline-block;
			    font-size: 16px;
			}
			.button_class_export{
				background-color: blue; /* Blue */
    			border: none;
			    color: white;
			    padding: 2% 2%;
			    text-align: center;
			    text-decoration: none;
			    display: inline-block;
			    font-size: 16px;
			}
		</style>
	</head>
<body>
	<h3>Developer: Manuel Martin Martin. Task developed in PHP 7.1</h3>
	<form action="./export_file.php" method="post">
		<input type="hidden" id="export" name="export" value="txt">
		<table width='100%' border>
			<tr>
				<th>Id</th>
				<th>Name</th>
				<th>Date</th>
				<th>Money</th>
				<th></th>
			</tr>
			<?php
				$db = new DB();
				$typeVal = array(1=>'id',2=>'name',3=>'date',4=>'money');
				//echo var_export($db->getListOffers(),true);
				foreach ($db->getListOffers() as $offer){
					echo "<tr>";
					$numColumn = 1;
					foreach ($offer as $column){
						echo "<td><input type='text' name='".$typeVal[$numColumn]."[]' readonly='true' value='".$column."'/></td>";
						$numColumn++;
					}
					echo "<td align='center'><button class='button_class_delete' type='button'>Delete</button></td>";
					echo "</tr>";
				}
			?>
			<tr>
				<td> </td><td> </td><td> </td><td> </td><td align='center'><button class='button_class_new' type='button'>New</button></td>
			<tr>
		</table>
		<table width="100%" border="" style="margin-top:3%">
			<tr>
				<th colspan="3">Export file:</th>
			</tr>
			<tr>
				<td width="33%" align='center'><button class='button_class_export' type='button'>XML</button></td>
				<td width="33%" align='center'><button class='button_class_export' type='button'>CSV</button></td>
				<td width="33%" align='center'><button class='button_class_export' type='button'>PLAIN TEXT</button></td>
			</tr>
	</form>
</body>
<script type="text/javascript">
$(document).ready(function(){

	/**
	*	Create a new row
	*/
	function newRow(button){
		var newId = 1;
		var objTr = $(button).closest('tr');
		var newTr = null;

		if(objTr.prev().find('input').length > 0)
		{
			newId = parseInt(objTr.prev().find('input').first().val())+1;
			newTr = objTr.prev().clone();
			newTr.find('input').first().val(newId);
			newTr.find('button').click(function(){deleteRow(this)});
			newTr.find('input').not(':first').attr('readonly',false);
		}else{
			newTr = $('<tr>');
			var tdId = $('<td>').append($('<input>',{type:'text',name:'id[]',readonly:true,value:newId}));
			var tdName = $('<td>').append($('<input>',{type:'text',name:'name[]',value:'New Name'}));
			var tdDate = $('<td>').append($('<input>',{type:'text',name:'date[]',value:'1970-01-01'}));
			var tdMoney = $('<td>').append($('<input>',{type:'text',name:'money[]',value:'100'}));
			var tdButton = $('<td>',{align:'center'}).append($('<button>',{'class':'button_class_delete',type:'button',text:'Delete'}).
					click(function(){deleteRow(this)}));

			newTr.append(tdId);
			newTr.append(tdName);
			newTr.append(tdDate);
			newTr.append(tdMoney);
			newTr.append(tdButton);
		}
		newTr.insertBefore(objTr);
	}

	/**
	*	Delete
	*/
	function deleteRow(button){
		$(button).closest('tr').remove();
	}

	/**
	*	Export file
	*/
	function exportFie(button){
		if($(button).text() == 'CSV')
			$('#export').val('csv');
		else if($(button).text() == 'XML')
			$('#export').val('xml');
		else
			$('#export').val('txt');
		$('form').submit();
	}


	$('.button_class_delete').click(function(){deleteRow(this);});
	$('.button_class_new').click(function(){newRow(this);});
	$('.button_class_export').click(function(){exportFie(this);});

});
</script>
</html>
