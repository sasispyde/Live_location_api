<!DOCTYPE html>
<html>

<head>
	<title>Current Location</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<style type="text/css">

		p
		{
			font-size: 40px;
		}

		table {
			margin-top: 35px;
		}
	</style>

</head>

<body style="text-align: center;">
	<div style="padding: 15px;">
		<a href="logout" class="btn btn-danger" style="float: right;margin-right: 40px;margin-top: 15px;">Logout</a>
	</div>
	<h2 style="font-size: 20px; margin-top: 15px; float: left; margin-left: 20px; ">Username : <?php echo  $user[0]->name; ?></h2>
	
	<div class="table-responsive">
		<table class="table table-striped table-bordered" id="table">
				<?php if (empty($location[0]->loc)) {
					echo "<p id='res'>"."Nothing to Show......"."<p>";
				} else { ?>
			<thead>
				<tr>
					<th>Longitude</th>
					<th>Latitude</th>
				</tr>
			</thead>
			<tbody id="records_table">

				<?php
					$data = $location[0]->loc->cor;
					$count = count($data);
					for ($i = 0; $i < $count; $i++) { 	?>
				<tr>
					<td><?php echo $data[$i][0]; ?></td>
					<td><?php echo $data[$i][1]; ?></td>
				</tr>
				<?php } ?>
				</tbody>
				<?php } ?>
		</table>
	</div>

	<?php $var = $_SESSION["id"]; ?>
	<?php
	if (!empty($location[0]->loc->cor)) {
		$oldLo = end($location[0]->loc->cor);
		$long = $oldLo[0];
		$lat = $oldLo[1];
	}
	?>

	<script type="text/javascript">

		var id = '<?php echo $var; ?>';
		var long = '<?php echo !empty($long) ? $long : ""; ?>';
		var lat = '<?php echo !empty($lat) ? $lat : ""; ?>';
		var header ='<?php echo empty($location[0]->loc->cor) ? true : false; ?>';
		var bool=false;
		// var head= true;
		var head ='<?php echo empty($location[0]->loc->cor) ? true : false; ?>';
		$(document).ready(function() {
			sendRequest();

			function sendRequest() {
				var res;
				$.ajax({
					url: "ajax",
					data: {
						user_id: id
					},
					success: function(data) {
						if (data.length!=1) 
						{
							res=data;
							res = JSON.parse(data);
							bool=true;
						}
						else
						{
							$("#resp").remove();
							var txt1 = "<p id='resp'>Nothing To Show....</p>";
							$("body").append(txt1);
							$("#res").remove();
							$("#table").remove();
							head=true;
							long ='';
							lat ='';
						}
						if (!jQuery.isEmptyObject(res)) 
						{
							if (long != res[0] || lat != res[1]) {
								var trHTML = '';
								var thHTML ='';
								var tbHTML ='';
								var table ='';
								if(bool)
								{
									$("#res").remove();
									table+="<table class='table table-striped table-bordered' id='table'>"+"</table>";
									$('.table-responsive').append(table);
									thHTML += "<thead><tr><th>" + "Longitude" + "</th><th>" + "Latitude" +
									"</th></tr></thead>";
									if(head){
										$('#table').append(thHTML);
										head=false;
									}
									tbHTML="<tbody id='records_table'></tbody>";
									$('#table').append(tbHTML);
									bool=false;
								}
									trHTML += '<tr><td>' + res[0] + "</td><td>" + res[1] +
									'</td></tr>';
									$("#res").remove();
									$("#resp").remove();
									$("#table2").remove();
									$('#records_table').prepend(trHTML);
									long = res[0];
									lat = res[1];
							}
						}
					},
				});
			}
			setInterval(sendRequest, 7000); // The interval set to 7 seconds
		});
	</script>

</body>
</html>	