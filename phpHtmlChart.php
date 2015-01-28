<?
	/**
	* phpHtmlChart
	*
	* This function will output a bar chart in HTML given
	* the supplied information.
	* The data array should be a multi-dim array as follows:
	*          0              1             2
	*    -------------------------------------------
	*    | Data Label | | Data Value | Unit Symbol |
	*    -------------------------------------------
	*  0 | Apples     | |    50      |      f      |
	*  1 | Oranges    | |    25      |      f      |
	*  2 | Limes      | |    15      |      f      |
	*    -------------------------------------------
	*
	* @author		Jason D. Agostoni (jason@agostoni.net)
	* @param	$paData				Multi-dim array of graph data
	* @param	$psOrientation		(optional) Currently unused
	* @param	$psTitle			(optional) Chart title (prints on the top)
	* @param	$psAxisLabel		(optional) Axis Label (prints on the data axis)
	* @param	$psFontSize			(optional) Font size to use for label/title (ex. 8pt)
	* @param	$piMaxSize			(optional) Max size of the graph (width for Horiz., Height for Vert.)
	* @param	$psMaxSizeUnit		(optional) Measurement unit of max size (px, cm, mm, etc.)
	* @param	$piBarSize			(optional) Width of the bar
	* @param	$psBarUnit			(optional) Measurement unit of the bar width
	* @param	$paColors			(optional) Array of HTML color codes to cycle through for bar colors
	* @return	Returns the HTML to render the chart
	*/
	function phpHtmlChart($paData, $psOrientation = 'H', $psTitle = '', $psAxisLabel = '', $psFontSize = '8pt',
						  $piMaxSize = 100, $psMaxSizeUnit = 'px', $piBarSize = 15, $psBarUnit = 'px',
						  $paColors = Array('#a0a0a0', '#707070')) {

		$iColors = sizeof($paColors);

		// Start HTML...
		$sHTML = "
			<table style='font-family: Arial; font-size: $psFontSize'><tr><tr><td colspan=2 align='center'><u><b>$psTitle</b></u></td></tr><td align='right'>
		";

		// Headers/scale
		$iMax = 0;
		for($iRow = 0; $iRow < sizeof($paData); $iRow++) {
			// Test for max...
			if($paData[$iRow][1] > $iMax) $iMax = $paData[$iRow][1];

			// Ouput the label
			$sHTML .= "<div style ='height: $piBarSize$psBarUnit;'>".$paData[$iRow][0]."</div>";
		} // Rows in paData...

		$iScale = $iMax / $piMaxSize;

		$sHTML .= "
			</td><td>
			<TABLE style='border-bottom: 1px solid black; border-left: 1px solid black;font-family: Arial; font-size: $psFontSize; '>
				<tr><td>
		";
		
		// Ouput the rows
		for($iRow = 0; $iRow < sizeof($paData); $iRow++) {
			$sColor = $paColors[$iRow%$iColors];
			$iBarLength = $paData[$iRow][1] / $iScale;
			$sHTML .= "
				<div style='background-color: $sColor; text-align: right; color: white;
							 height: $piBarSize$psBarUnit; 
							 width: $iBarLength$psMaxSizeUnit;'> ".
				$paData[$iRow][1].$paData[$iRow][2]."&nbsp;</div>
			";
		}

		// Wrap up HTML
		$sHTML .= "
			</td></tr>	
			</table></td></tr>
			<tr><td></td><td>$psAxisLabel</td></tr>
			</table>
		";
		return $sHTML;
	}
?>