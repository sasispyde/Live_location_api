<!DOCTYPE html>
<html>
<head>
	<title>Dashboard</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<style type="text/css">
		table
		{
			margin-top: 10px;

		}
		a.disabled {
		  pointer-events: none;
		  cursor: default;
		}
	</style>

</head>
<body style="text-align: center;">
	<div>
		<a href="logout" class="btn btn-danger" style="float: right;margin-right: 40px;margin-top: 15px;">Logout</a>
	</div>
			<div class="table-responsive">
			<table class="table table-striped table-bordered">
			<thead>
			    <tr>
				     <th >Phone Number</th>
				     <th >Country Code</th>
				     <th >Name</th>
				     <th >Email</th>
				     <th >Status</th>
				     <th >Registered</th>
				     <th >View Locations</th>
			   </tr>
			</thead>
			<tbody id="table">
				 <?php foreach ($data as $key => $value){ ?>
				  <tr>
				    <td>
				     <?php 
						if(!empty($value->phone_number))
						{
							echo $value->phone_number;
						}
						else
						{
							echo "-";
						}
				     ?>
				    </td>
					 <td>
				     <?php 
						if(!empty($value->country_code))
						{
							echo $value->country_code;
						}
						else
						{
							echo "-";
						}
				     ?>
				    </td>
				    				    <td>
				     <?php 
						if(!empty($value->name))
						{
							echo $value->name;
						}
						else
						{
							echo "-";
						}
				     ?>
				    </td>
				    				    <td>
				     <?php 
						if(!empty($value->email))
						{
							echo $value->email;
						}
						else
						{
							echo "-";
						}
				     ?>
				    </td>
				    <td>
				     <?php 
						if(!empty($value->status))
						{
							echo $value->status;
						}
						else
						{
							echo "-";
						}
				     ?>
				    </td>
				     <td>
				     <?php 
						if(!empty($value->name))
						{
							echo "Registered";
						}
						else
						{
							echo "Not Registered";
						}
				     ?>
				    </td>
				    <td>
				    	<?php if(!empty($value->name)){ ?>

				     		<a class="btn btn-primary" href="viewlocations?id=<?php echo $value->_id ?>">View Locations</a>
				     	<?php } else{ ?>
				     		<a class="btn btn-primary disabled" href="viewlocations?id=<?php echo $value->_id ?>">View Locations</a>
				     	<?php } ?>

				    </td>
				    </tr>
					 <?php } ?>
			 </tbody>
			</table>
			</div>

<script type = "text/javascript">
          var value=10;
          var value2=5;
          var boo=false;
$(window).scroll(function() {

    if(boo)
    {
      $(window).scroll(function (){
        event.preventDefault();
      })
    }
    else
    {
    if($(window).scrollTop() == $(document).height() - $(window).height()) {

	        	$.ajax({
	    	    type: "GET",
	    	    url: "pagination",
	    	    data: {
	    	        limit: value2,
	    	        skip : value
	    	    },
	    	    success: function (data)
	    	    {
	    	    	var dat=JSON.parse(data);
	    	    	var trHTML = '';
	    	    	if(dat.length==0)
	    	    	{
	    	    		boo = true;
	    	    	}
	    	    	else
	    	    	{
	    	    		console.log(dat);	
	    	    		console.log(value);
	        			console.log(value2);
	    	    		  $.each(dat, function (i,data) {
		                  trHTML += '<tr><td>' + 
		                  data.phone_number + '</td><td>' + 
		                  data.country_code + '</td><td>' +
		                  ("name" in data ? data.name: '-') +
		                  '</td><td>' +
		                  ("email" in data ? data.email: '-') + '</td><td>' +
		                  data.status + '</td><td>' +
		                  ("name" in data ? "Registered": 'Not Registered') + '</td><td>' + 
		                  '<a '+'href=' + "viewlocations?id=" 
		                  +data._id.$oid+ 
		                  ("name" in data ? " class=\"btn btn-primary\"": " class=\"btn btn-primary disabled\"") +">" +"viewlocations"+ '</a></td>' + '</tr>';          
		              });
		                $('#table').append(trHTML);
	    	    	}
	    	    	
	    	    }
    		});
	        	value=value+5;
	    }
	}
});
    	    

</script>

</body>
</html>	