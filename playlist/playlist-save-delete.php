<?php
require_once('connection.php');

if(isset($_POST['watchcurrplayid']))  // for watch later
{ 
	$watchcurrplayid = $_POST['watchcurrplayid'];
	$watchvideotitl = $_POST['watchvideotitl'];
	$loginidis = $_SESSION['userloginid'];
	$q = $con->prepare("SELECT watchtoen,watchby FROM watchlater WHERE watchtoen=? and watchby='$loginidis'");
	$q->execute([$watchcurrplayid]);

	if($res = $q->fetch())
	{
		echo 'already exist in watch later';
	}
	else
	{
		$r=$con->prepare('INSERT INTO watchlater(watchtoen,watchtitle,watchby)VALUES(?,?,?)');
		$r->execute([$watchcurrplayid,$watchvideotitl,$loginidis]);

		if($r)
		{
			echo 'Added as watch later';
		}
	}
}

if(isset($_POST['playslitnameinput'])) //for playlist
{
	$playslitnameinput = $_POST['playslitnameinput'];
	$userlogin = $_SESSION['userloginid'];
	$q = $con->prepare('SELECT playlistname,createdby FROM playlist WHERE playlistname=? and createdby=?');
	$q->execute([$playslitnameinput,$userlogin]);

	if($res = $q->fetch())
	{
		echo 'already exist';
	}
	else
	{
		$r=$con->prepare('INSERT INTO playlist(playlistname,createdby)VALUES(?,?)');
		$r->execute([$playslitnameinput,$userlogin]);

		if($r)
		{
			echo 'Playlist Created';
		}
	}
}
 

if(isset($_POST['currplayid'])) //for videos
{
	$currplyid = $_POST['currplayid'];
	$currntlistnam = $_POST['currntlistnam'];
	$videotitl = $_POST['videotitl'];
	$q = $con->prepare('SELECT videotoken, savetoplaylist FROM playlistvideos WHERE videotoken=? and savetoplaylist=?');
	$q->execute([$currplyid, $currntlistnam]);

	if($res = $q->fetch())
	{
		echo 'already exist';
	}
	else
	{
		$r=$con->prepare('INSERT INTO playlistvideos(videotoken, savetoplaylist, videonam)VALUES(?,?,?)');
		$r->execute([$currplyid, $currntlistnam, $videotitl]);

		if($r)
		{
			echo 'Video added To Playlist';
		}
	}
}

if(isset($_POST['updateplayslitnameinput']))
{
	$updateplayslitnameinput = $_POST['updateplayslitnameinput'];
	$updatplaylisedit = $_POST['updatplaylisedit'];
	$userlogin = $_SESSION['userloginid'];
	$z = $con->prepare('UPDATE playlist SET playlistname=? WHERE playlistid=? and createdby=?');
	$z->execute([$updateplayslitnameinput,$updatplaylisedit,$userlogin]);

	if($z)
	{
		echo 'Playlist Updated';
	}
	
}
if(isset($_POST['deletlistidselect']))
{
	$deletlistidselect = $_POST['deletlistidselect'];
	$userlogin = $_SESSION['userloginid'];
	$q = $con->prepare('DELETE from playlist WHERE playlistid=? and createdby=?');
	$q->execute([$deletlistidselect,$userlogin]);

	if($q)
	{
		echo 'Playlist Deleted';
	}
}
if(isset($_POST['deltidis']))
{
	$deleid = $_POST['deltidis'];
	$q = $con->prepare('DELETE from playlistvideos WHERE videoid=?');
	$q->execute([$deleid]);

	if($q)
	{
		echo 'Deleted';
	}
}

if(isset($_POST['viewrelateplaylisid']))
{
	$viewrelid = $_POST['viewrelateplaylisid'];
	$userlogin = $_SESSION['userloginid'];
	$v = $con->query("SELECT playlistname,playlistid,createdby from playlist where playlistid ='$viewrelid' and createdby='$userlogin'");
	if($z = $v->fetch())
	{
		$q = $con->query("SELECT videoid, videotoken, videonam, savetoplaylist FROM playlistvideos 	where savetoplaylist='$z[0]'");
		
		echo '<input type="button" style="padding:2%" value="back To Playlist" onclick=$(".actualviewlistofvido").hide();$(".playlistdiv").find("table").show() />';
		while($p = $q->fetch())
		{
			echo '
			<table style="width:100%;" cellpadding="10" cellspacing="10">
			<tr>
			<td width="80%">
			<iframe width="60%" src="https://www.youtube.com/embed/'.$p[1].'?controls=0" frameborder="1" allowfullscreen >  </iframe>
			<p style="color: #d85d5d; font-size: 15px;" data-viewvideoid="'.$p[0].'" class="viewlistvideos">'.$p[2].'</p>
			</td>
			<td>
			<span onclick="deletethisfromplaylist($(this))" data-iddelete = "'.$p[0].'" style="cursor:pointer; color:blue">Delete</span>
			</td>
			</tr>
			</table>
			
			';
		}
		 
	}
}	
?>