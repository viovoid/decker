<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitio
nal.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Decker</title>
	<meta content="en-us" http-equiv="Content-Language" />
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<style type="text/css">
		.auto-style1 {
			text-align: center;
		}
		.auto-style2 {
			text-align: left;
		}
		table#t01 th {
			color: white;
			background-color: black;
		}
		table#t01 tr:nth-child(even) {
			background-color: #eee;
		}
		table#t01 tr:nth-child(odd) {
		   background-color:#fff;
		}
		a:visited {
			color: #0000FF;
		}

		body {
		  background: url("http://cdn.shopify.com/s/files/1/0514/0113/files/Facebook_Cover_Photo_EN.jpg?8910001730877757600") no-repeat left fixed;
		  background: url("http://www.manaleak.com/mtguk/files/2015/10/Shadows-over-Innistrad-wallpaper.jpg") no-repeat left fixed;
		  -webkit-background-size: cover;
		  -moz-background-size: cover;
		  -o-background-size: cover;
		  background-size: cover;
		}
	</style>
	<script type="text/javascript" src="http://deckbox.org/javascripts/bin/tooltip.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">
	<script type='text/javascript' src='http://code.jquery.com/jquery-1.12.0.min.js'></script>
	<script type='text/javascript' src='https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js'></script>
	<script type="text/javascript" class="init">
		$(document).ready(function() {
			$('#t01').DataTable( {
				"order": [[ 1, "asc" ]],
				"columnDefs": [ { "orderable": false, "targets": [0, 3] } ], 
				"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
				"scrollY": "75vh",
				"scrollCollapse": true
			} );
		} );
	</script>
</head>

<body>
	<?php if($_SERVER['REQUEST_METHOD'] == 'POST') {
		// XXX: do i actually have to make a new one?
		$_controller = new Controller();
		$_controller->submit();
		die();
	}
	?>

	<form name="deckForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<div style="overflow: auto; width:420px; height:700px; float:left">
	<table id="t01" class="display" cellpadding="2">
		<thead>
			<tr>
				<th>Quantity</th>
				<th style="width: 15px">Card Number</th>
				<th>Card Name</th>
				<th>Mana Cost</th>
			</tr>
		</thead>
		<tbody>
		<?php 
			
			foreach ($cards as $index => $card) {
				echo '<tr>';
				// XXX: rewrite this as a loop?
				echo '<td><select name="count['.$card->index.']">'
						.'<option selected="selected" value="0">0</option>'
						.'<option value="1">1</option>'
						.'<option value="2">2</option>'
						.'<option value="3">3</option>'
						.'<option value="4">4</option>'
						.'<option value="5">5</option>'
						.'<option value="6">6</option>'
						.'<option value="7">7</option>'
						.'<option value="8">8</option>'
						.'<option value="9">9</option>'
						.'<option value="10">10</option>'
						.'<option value="11">11</option>'
						.'<option value="12">12</option>'
					.'</select></td>';
				echo '<td align="right">'.$card->index.'</td><td><a target="_blank" href="http://deckbox.org/mtg/'.$card->name.'">'.$card->name.'</a></td>';
				echo '<td>'.$card->manaCost.'</td></tr>';
			}

		?>
		</tbody>
	</table></div>

	<div style="float:left">
		Deck size<br>
		<input type="radio" name="size" value="40" checked>40<br>
		<input type="radio" name="size" value="60" checked>60<br>
		<br>Colors<br>
		<input type="checkbox" name="colors[]" value="W">W<br>
		<input type="checkbox" name="colors[]" value="U">U<br>
		<input type="checkbox" name="colors[]" value="B">B<br>
		<input type="checkbox" name="colors[]" value="R">R<br>
		<input type="checkbox" name="colors[]" value="G">G<br>
		<br>
		<input type="submit" name="submit" value="Deck!">
	</div>
	</form>

</body>
</html>
