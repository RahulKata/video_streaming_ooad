<?php
require_once('connection.php');

if(isset($_POST['viewupdtvideoid']))
{
	$loginm = $_SESSION['loginnameis'];
	
	$tempid = '';
	$tempvisiblfor = '';
	 
	$viewupdtvideoid = $_POST['viewupdtvideoid'];
	$refrencmcqid = $_POST['refrencmcqid'];
	 
	$a = $con->prepare("SELECT testid, avaiblesubject, avaibletest, createdby, visiblefor, stats from availblexam where createdby=? and stats=?");
	$a->execute([$loginm,'active']);
	while($d = $a->fetch())
	{
		if($d[0] == $refrencmcqid)
		{
			$tempid .='<option value="'.$d[0].'" selected>'.$d[1].' - '.$d[2].'</option>';
		}
		else
		{
			$tempid .='<option value="'.$d[0].'">'.$d[1].' - '.$d[2].'</option>';
		}
	}
	
	$visibl = '';
	$ststemp = '';
	$b = $con->prepare("SELECT id, createdby, visiblefor, status from video where createdby=? and id=?");
	$b->execute([$loginm,$viewupdtvideoid]);
	while($t = $b->fetch())
	{
		if($t[2] == 'For All') {
			$visibl .='<option selected>'.$t[2].'</option>';
		}
		else {
			$visibl .='<option>For All</option>';
		}
		if($t[2] == 'Only Join Student') {
			$visibl .='<option selected>'.$t[2].'</option>';
		}
		else {
			$visibl .='<option>Only Join Student</option>';
		}
		if($t[2] == 'IP based') {
			$visibl .='<option selected>'.$t[2].'</option>';
		}
		else {
			$visibl .='<option>IP based</option>';
		}
		if($t[2] == 'None')	{
			$visibl .='<option selected>'.$t[2].'</option>';
		}
		else { 
			$visibl .='<option>None</option>';
		}
		
		if($t[3] == 'active')
		{
			$ststemp .='<option selected>active</option>';
		}
		else if($t[3] == 'pending')
		{
			$ststemp .='<option selected>pending</option>';
		}
	}
	
	 
	$q1 = $con->prepare("SELECT id, nameofvideo, description, visiblefor, videodate, videolocation, mcqid, timewhenshowmcq, time2mcqshow, time3mcqshow, filename, crackmark, status, thumbnail, createdby, mcqshowintime1, mcqshowintime2, mcqshowintime3 FROM video WHERE createdby=? and id=?");
	$q1->execute([$loginm,$viewupdtvideoid]);
	
	if($r = $q1->fetch())
	{
		echo '<br/><form action="update-delete-video.php" method="post" enctype="multipart/form-data">
		<table width="100%" cellpadding="10" cellspacing="5" border="1" bordercolor="#dedede" style="border-collapse:collapse" class="sometablepadding">
		<tr>
		<td width="30%">Video</td>
		<td width="70%"><video poster="'.$r[14].'" controls id="myVid" style="width:150px;">
		<source src="video/'.$r[10].'" type="video/mp4">
		</video>
		Change File <input type="file" onchange= $(this).closest("td").find("video").attr("src",window.URL.createObjectURL(this.files[0])) name="viewvideofile" />
		</td>
		</tr>
		<tr>
		<td width="30%"><input type="hidden" value="'.$viewupdtvideoid.'"  name="refrenviewvideoid" />Title Name</td>
		<td width="70%"><input type="text" name="viewvideoname" value="'.$r[1].'" /></td>
		</tr>
		<tr>
		<td width="30%">Description</td>
		<td width="70%"><input type="text" name="viewvideodescription" value="'.$r[2].'" /></td>
		</tr>
		<tr>
		<td width="30%">Visible For</td>
		<td width="70%"><select name="viewvideovisiblefor">'.$visibl.'</select></td>
		</tr>
		<tr>
		<td width="30%">Video Date</td>
		<td width="70%"><input type="text" name="viewvideodate" value="'.$r[4].'" /></td>
		</tr>
		<tr>
		<td width="30%">Video Location</td>
		<td width="70%"><input type="text" name="viewvideolocation" value="'.$r[5].'" /></td>
		</tr>
		<tr>
		<td width="30%">Change MCQ</td>
		<td width="70%"><select name="viewvideomcqid"><option>none</option>'.$tempid.'</select></td>
		</tr>
		<tr>
		<td width="30%">First Time OF MCQ(hour:min:second)</td>
		<td width="70%"><input type="text" value="'.$r[7].'" name="viewmcqfirsttime" /></td>
		</tr>
		<tr>
		<td width="30%">No of Question First Time</td>
		<td width="70%"><input type="text" value="'.$r[15].'" name="viewmcqnoquestinfirst" /></td>
		</tr>
		<tr>
		<td width="30%">Second Time OF MCQ(hour:min:second)</td>
		<td width="70%"><input type="text" value="'.$r[8].'" name="viewmcqsecondtime" /></td>
		</tr>
		<tr>
		<td width="30%">No of Question Second Time</td>
		<td width="70%"><input type="text" value="'.$r[16].'" name="viewmcqnoquestinsecond" /></td>
		</tr>
		<tr>
		<td width="30%">Third Time OF MCQ(hour:min:second)</td>
		<td width="70%"><input type="text" value="'.$r[9].'" name="viewmcqthirdtime" /></td>
		</tr>
		<tr>
		<td width="30%">No of Question Third Time</td>
		<td width="70%"><input type="text" value="'.$r[17].'" name="viewmcqnoquestinthird" /></td>
		</tr>
		<tr>
		<td width="30%">Minimum Mark</td>
		<td width="70%"><input type="text" value="'.$r[11].'" name="viewmcqminimmark" /></td>
		</tr>
		<tr>
		<td width="30%">Status</td>
		<td width="70%"><select name="viewvideostatus">'.$ststemp.'</select></td>
		</tr>
		<tr>
		<td width="30%">Thumbnail/Poster Photo</td>
		<td width="70%">
		<img src="video/'.$r[13].'" style="width:100px" onerror="errorimag($(this))" class="videophotview"/>
		<input type="file" name="viewphotoofvideo" onchange= $(".videophotview").attr("src",window.URL.createObjectURL(this.files[0])) />
		</td>
		<tr>
		<td width="30%"><input type="submit" value="Update" /></td>
		<td width="70%"></td>
		</tr>
		</table></form><br/>'; 
	}
}
?>

