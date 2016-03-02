<html>
<head></head>

<body>

<table>
	<tr><td>In Pool</td><td>Index</td><td>Name</td><td>Mana Cost</td></tr>
	<?php 

		foreach ($cards as $index => $card)
		{
			echo '<tr>';
			echo '<td><select name="selectCount">'
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
			echo '<td align="right">'.$card->index.'</td><td><a href="index.php?card='.$card->name.'">'.$card->name.'</a></td>';
			echo '<td>'.$card->manaCost.'</td></tr>';
		}

	?>
</table>

</body>
</html>
