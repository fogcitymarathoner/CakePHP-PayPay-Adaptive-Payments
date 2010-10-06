<?php

class EkoppHelper extends Helper {
	
	function topmenu()
	{
		$topmenu = '';
		$topmenu .= '<div style="border: 1px solid blue; ">';
		$topmenu .= '	<ul class="jd_menu">';
		$topmenu .= '		<li><a href="'.$this->webroot.'adaptive_checkouts/"  >Home</a></li>';
		$topmenu .= '		<li><a href="#" class="accessible">Adaptive Payments</a>';
		$topmenu .= '			<ul>';
		$topmenu .= '				<li>Test &raquo;';
		$topmenu .= '					<ul>';
		$topmenu .= '						<li><a href="'.$this->webroot.'adaptive_checkouts/testpayment1" target="_blank" >Test 1</a></li>';
		$topmenu .= '					</ul>';
		$topmenu .= '				</li>';
		$topmenu .= '			</ul>';
		$topmenu .= '		</li>';
		$topmenu .= '	</ul>';
		$topmenu .= '</div>';
		return $topmenu;
	}	
	function printinirow($elementName = 'X-PAYPAL-REQUEST-DATA-FORMAT',$elementValue='NV', $mode ='edit', $ad='HEADERS')
	{
		$readonlystyle = ' STYLE="color: #ffffff; font-family: Verdana; font-weight: bold; font-size: 12px; background-color: #e37469;"';
		$editstyle = ' STYLE="color: #ffffff; font-family: Verdana; font-weight: bold; font-size: 12px; background-color: #69ff69;"';
		$leftcolwidth = 150;
		$rtcolwidth = 200;
		$inputsize = 63;
		$inputmaxlength = 200;
		$return = "
		<tr>
		<td WIDTH={$leftcolwidth}>{$elementName}</td>
		<td WIDTH={$rtcolwidth}>";
		$return .="<label for=\"{$ad}_{$elementName}\"></label>
<input name=\"data[{$ad}][{$elementName}]\" 
type=\"text\" value=\"{$elementValue}\"";
		if ($mode == 'ro')
			$return .= ' '.$readonlystyle;
		else
			$return .= ' '.$editstyle;
		
		$return .= "size=\"{$inputsize}\" maxlength=\"{$inputmaxlength}\" id=\"APCO{$elementName}\" />";
		$return .= '</td></tr>';
		return $return;
	}	
	function index($contacts)
	{
		$res = '
<h2>
		';
$res = '
<table cellpadding="0" cellspacing="0" >
<tr>
	<th>First</th>
	<th>Last</th>
	<th>Phone</th>
	<th>Problem, Company, Scheduled Time</th>
	<th class="actions">Actions</th>
</tr>
';
$i = 0;
$bgcolorName="gray";
foreach ($contacts as $contact):
		if ($bgcolorName=="gray") // Alternate background in records
		{
			$bgcolor="efefef";
			$bgcolorName="white";
		} else {
			$bgcolor="ffffff";
			$bgcolorName="gray";
		} 
		echo "";
	
	$res .= '
		<TR  bgcolor="#'.$bgcolor.'" id="td">
		<td ><FONT COLOR="#7c0965">
			'.$contact['Contact']['first'].'
		</FONT></td>
		<td ><FONT COLOR="#7c0965">
			'.$contact['Contact']['last'].'
		</FONT></td>
		<td ><FONT COLOR="#7c0965">
			'.$contact['Contact']['phone1'].'
		</FONT></td>
		<td ><FONT COLOR="#7c0965">
			'.$contact['Contact']['description_triage'].'
		</FONT></td>';

		$res .= '<td class="actions">';
$res .= '<a href="'.$this->webroot.'calls/edit/'.$contact['Contact']['id'].'">
<img src="'.$this->webroot.'img/icons/pencil.png" title="edit" alt="" /></a>';
$res .= '<a href="'.$this->webroot.'calls/view/'.$contact['Contact']['id'].'">
<img src="'.$this->webroot.'img/icons/magglass.png" title="view" alt="" /></a>';
$res .= '<a href="'.$this->webroot.'calls/unpend/'.$contact['Contact']['id'].'">
<img src="'.$this->webroot.'img/icons/redcirclecrossedout.png" title="unpend" alt="" /></a>';
$res .= '<a href="'.$this->webroot.'calls/delete/'.$contact['Contact']['id'].'" onclick="return confirm(&#039;Are you sure you want to delete # '.$contact['Contact']['id'].
'?&#039;);"><img src="'.$this->webroot.'img/icons/redx.png" title="Delete" alt="" /></a>	';	
$res .= '<a href="'.$this->webroot.'calls/directions/'.$contact['Contact']['id'].'" target="_blank">|Directions</a>';
$res .= '<a href="'.$this->webroot.'calls/directionsmap/'.$contact['Contact']['id'].'" target="_blank">|Directions Map</a>';
$res .= '<a href="'.$this->webroot.'calls/detailsmap/'.$contact['Contact']['id'].'" target="_blank">|Details Map</a>';
$res .= '<a href="'.$this->webroot.'calls/removefromcalls/'.$contact['Contact']['id'].'" >|remove from calls</a>';
$res .= '<a href="'.$this->webroot.'calls/repend/'.$contact['Contact']['id'].'" >|repend</a>';
$res .= '<a href="http://maps.google.com/?q='.
urlencode($contact['Contact']['street1']).
urlencode($contact['Contact']['city']).
urlencode($contact['Contact']['state']).
urlencode($contact['Contact']['zip']).
'" class="button" target="_blank">|MAP</a>';


	$res .='	</td>	</tr>';
		endforeach;
	$res .='</table>';
	return $res;
	}
function calendar($json )
	{
$res ="<style type='text/css'>


	#calendar {
		width: 900px;
		margin: 0 auto;
		}


</style>


<script type='text/javascript'>

$(document).ready(function() {

$('#calendar').fullCalendar({

	header: {
		left: 'prev,next today',
		center: 'title',
		right: 'month,agendaWeek,agendaDay'
		},
	events: ".$json." // this is where we call the php variable

});
});
</script>

<div id='calendar' style='width: 900px; margin: 0 auto;'></div>
";
		return $res;
	}
}
?>
