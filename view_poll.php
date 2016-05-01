<?php include_once "header.php"; ?>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" media="all">
<script type="text/javascript">
	var getUrlParameter = function(sParam)
	{
	    var sPageURL = window.location.search.substring(1);
	    var sURLVariables = sPageURL.split('&');
	    for (var i = 0; i < sURLVariables.length; i++) 
	    {
	        var sParameterName = sURLVariables[i].split('=');
	        if (sParameterName[0] == sParam) 
	        {
	            return sParameterName[1];
	        }
	    }
	}

	var getPollById = function()
	{
			$.getJSON( "service/getPoll.php?poll_id="+getUrlParameter('poll_id'), function(data) {
				var items = [], item_html = "";
				$.each( data.poll_options, function( key, val ) {
					if(val.voters.length > 0){
						var voters = '';
						for(var j=0; j<val.voters.length; j++){
							if(val.voters[j]["fb_user_profile_link"]){
								voters += '<a class="voter-link" href="'+val.voters[j]["fb_user_link"]+'">'+val.voters[j]["name"]+'</a>';
							}
							else{
								voters += '<a class="voter-link" href="">'+val.voters[j]["name"]+'</a>';
							}
						}
					}
					item_html = '<div class="col-md-4 poll-item hvr-grow">'+
							'<div class="col-md-12 opacity-holder">'+
								'<div class="col-md-12 poll-item-inner">'+
									'<div class="col-md-12"><img class="img-responsive poll-item-image" src="'+val.img_src+'"/></div>'+
									'<div class="col-md-12 no-left-right-padding poll-item-content">'+
										'<a href="'+val.product_url+'" target="_blank" class="poll-item-link"><div class="col-md-12 no-left-right-padding poll-item-title"><h4>'+val.img_desc+'</h4></div></a>'+
										//'<div class="col-md-12 no-left-right-padding poll-item-description">This is a red dress. Pair it with Beige pumps for a casual evening.</div>'+
										'<div class="col-md-12 no-left-right-padding poll-item-cost">'+val.cost+'</div>';
					if(voters){
						item_html = item_html + '<div class="col-md-12 no-left-right-padding poll-item-item-voters">' + voters + '</div>';
					}
					item_html = item_html + '</div>'+
								'</div>'+
								'<div class="opacity-div"></div>'+
							'</div>';
					if(data.status === "new"){
						item_html = item_html + '<div class="vote-on-poll poll_option_'+val.poll_option_id+'" data-pollOptionId="'+val.poll_option_id+'"><i class="hvr-icon-bounce"></i></div>';
					}
					item_html = item_html +	'</div>';
				    items.push(item_html);
				});
				$('.view-poll-title').html(data.poll_info.poll_title);
				$('.view-poll').html(items.join(""));
				$('.fb-share-button').attr("data-href", 'http://juxtachoose.appspot.com/vote.php?poll_id="'+getUrlParameter('poll_id'));
				if(data.status === "voted"){
					showLoader("You have already voted on this poll.", true);
				}
				else{
					hideLoader();
				}	
			});
	}

	$(document).ready(function(){
		showLoader("The poll you have requested is being loaded.");
		getPollById();

		$('.view-poll').delegate('.vote-on-poll', 'click', function(){
			showLoader("Thanks for voting!");
			$.post('service/vote.php', 
				{
					"poll_id": getUrlParameter('poll_id'),
					"poll_option_id": $(this).attr('data-pollOptionId'),
					"fb_user_id": localStorage.getItem("fb_user_id"),
					"fb_user_name": localStorage.getItem("fb_user_name"),
					"fb_user_email": localStorage.getItem("fb_user_email"),
					"fb_user_link": localStorage.getItem("fb_user_link")
				}, 
				function(data, status){
					if(data){
						hideLoader();
						window.location.assign("view_poll.php?poll_id="+data.poll_id);
					}
					else{
						showLoader("You have already voted on this poll.", true);
					}
				}
			);
		});
	});
</script>
<div class="container">
	<div class="row">
		<div class="col-md-12 view-poll-title-wrapper">
			<h2 class="col-md-12 view-poll-title"></h2>
			<div class="col-md-12 fb-share-button-wrapper">
				<div class="fb-share-button" data-layout="button"></div>
			</div>
		</div>
		<div class="col-md-12 view-poll">
			
		</div>
	</div>
</div>
<?php include_once "footer.php"; ?>