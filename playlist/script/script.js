$(document).ready(function()
{
	 	
	//label animation
	$('input[type="text"],input[type="password"],input[type="email"],input[type="file"],select,textarea').each(function(){
		if($(this).val() !='')
		{
			$(this).parent().find('label').addClass('active');
		}
	});
	$('input[type="text"],input[type="password"],input[type="email"],input[type="file"],select,textarea').on('focusin', function() {
	  $(this).parent().find('label').addClass('active');
	});
	 
	$('input[type="text"],input[type="password"],input[type="email"],input[type="file"],select,textarea').on('focusout', function() {
	  if (!this.value) {
		$(this).parent().find('label').removeClass('active');
	  }
	});
	$('.inputelement div label').click(function()
	{
		$(this).addClass('active');
		$(this).next().focus();
	});
	//end label animation
	
	$('#listvideos video').click(function(){
		//alert($(this).find('source').attr('src'));
		$('.mainvideoplay source').attr('src',$(this).find('source').attr('src'));
		$('.mainvideoplay')[0].load();
		window.history.replaceState(null, null, window.location.pathname);
		$('.mainvideoplay').css('display','block');
		$('.addtoplylis').css('display','block');
	});
	$('.searchpost').on('keyup',function(e) {
		if(e.which == 13) {
			searchin();
		}
	});
});

function updateplaylistnam()
{
	var updateplayslitnameinput = $('.updateplaylistinput').val();
	var updatplaylisedit = $('.selectplaylistidtoedit').val();
	
	$.post('playlist-save-delete.php', {
		updateplayslitnameinput:updateplayslitnameinput,updatplaylisedit:updatplaylisedit
		}, function(data) {
			 alert(data);
			 location.href='view-playlist.htm';
	});
	
}
function deleteplaylistnam()
{
	var deletlistidselect = $('.selectplaylistidtoedit').val();
	$.post('playlist-save-delete.php', {
		deletlistidselect:deletlistidselect
		}, function(data) {
			 alert(data);
			 location.href='view-playlist.htm';
	});
	
}
function savenewplaylist()
{
	var playslitnameinput = $('#playslitnameinput').val();
	$.post('playlist-save-delete.php', {
		playslitnameinput:playslitnameinput
		}, function(data) {
			 alert(data);
			 		 
			 $.post('playlist-save-delete.php', {
				currplayid:currplayid,currntlistnam:playslitnameinput,videotitl:videotitl
				}, function(data) {
					$('.frontdiv').hide();
					alert(data);
			 });
				 
			 location.href='hello.htm';
			 
			 
			 
	});
	
}

function viewrelatedvideo(relatvido)
{
	var viewrelateplaylisid = $(relatvido).attr('data-playlistid');
	$.post('playlist-save-delete.php', {
		viewrelateplaylisid:viewrelateplaylisid
		}, function(data) {
			$(relatvido).closest('table').hide();
			$('.actualviewlistofvido').html(data);
			$('.actualviewlistofvido').show();	
	});
}

function deletethisfromplaylist(deletid)
{
	
	var deltidis = $(deletid).attr('data-iddelete');
	
	$.post('playlist-save-delete.php', {
		deltidis:deltidis
		}, function(data) {
			alert(data);
			window.location.reload();
	});
}
function myfunction(iconthi)
{
	if($(iconthi).next('.notificationbox-content').is(':hidden'))
    {
		$('.notificationbox-content').hide();
		$(iconthi).next('.notificationbox-content').show();
		$('.dropbtn').removeClass('someiconclickeffect');
		$(iconthi).addClass('someiconclickeffect');
	}
	else if($(iconthi).next('.notificationbox-content').is(':visible'))
	{
		$(iconthi).next('.notificationbox-content').hide();
		$('.dropbtn').removeClass('someiconclickeffect');
	}
}
function logooutme()
{
	var logoutvar = 'logoutva';
	
	$.post('loginbk.php', {
		logoutvar:logoutvar
		}, function(data) {
			window.location.reload();
	});
}
 
 function searchin()
{
	var searchpost = $('.searchpost').val().toLowerCase();
	//location.href= 'index.htm?que='+searchpost;	
	$('.mainvideoplay').css('display','none');
	$('.addtoplylis').css('display','none');
	$('.videotitle').each(function(){
		
		if($(this).text().toLowerCase().indexOf(searchpost) != -1)
		{
			$(this).closest('div').show();
		}
		else
		{
			$(this).closest('div').hide();
		}
	});
	if($('.videotitle:visible').length < 1)
	{
		alert('No Result Found');
	}


	/*if(location.href.match('/discussion/')) {
		location.href= pathrefrencuse+'search?que='+searchpost;	
	}
	else if(location.href.match('/question') || location.href.match('/search')) {
		location.href='search?que='+searchpost;	
	}*/
}