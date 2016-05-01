<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" media="all">

<?php include_once "header.php"; ?>
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
				var items = [];
				$.each( data.poll_options, function( key, val ) {
					items.push( '<div class="col-md-4 ">'+
						'<a href="'+val.product_url+'" target="_blank" class="poll-item-link">'+
					    	'<div class="poll-item hvr-grow poll_'+val.poll_id+'_'+val.poll_option_id+'" data-votes="'+val.votes+'">'+
								'<div class="col-md-12 opacity-holder">'+
									'<div class="col-md-12 poll-item-inner">'+
										'<div class="col-md-12"><img class="img-responsive poll-item-image" src="'+val.img_src+'"/></div>'+
										'<div class="col-md-12 no-left-right-padding poll-item-content">'+
											'<div class="col-md-12 no-left-right-padding poll-item-title"><h4>'+val.img_desc+'</h4></div>'+
											//'<div class="col-md-12 no-left-right-padding poll-item-description">This is a red dress. Pair it with Beige pumps for a casual evening.</div>'+
											'<div class="col-md-12 no-left-right-padding poll-item-cost">'+val.cost+'</div>'+
										'</div>'+
									'</div>'+
									'<div class="opacity-div"></div>'+
								'</div>'+
							'</div></a>'+
						'<div class="vote-on-poll poll_option_'+val.poll_option_id+'" data-pollOptionId="'+val.poll_option_id+'"><i class="hvr-icon-bounce"></i></div></div>');
				});
				$('.vote-poll-title').html(data.poll_info.poll_title);
				$('.vote-poll').html(items.join(""));
				//$('.fb-share-button').attr("data-href", "http://juxtachoose.appspot.com:8081/vote.php?poll_id="+getUrlParameter('poll_id'));
				if(data.status === "voted"){
					showLoader("You have already voted on this poll.", true);
				}
				else{
					hideLoader();
				}	
			});
	}

	$(document).ready(function(){
		showLoader();
		getPollById();

		$('.vote-poll').delegate('.vote-on-poll', 'click', function(){
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
					if(data.status === "voted"){
						showLoader("You have already voted on this poll.", true);
					}
					else{
						hideLoader();
					}
				}
			);
		});
	});
</script>
<div class="container">
	<div class="row">
		<div class="col-md-12 vote-poll-title-wrapper">
			<h2 class="col-md-12 vote-poll-title"></h2>
			<!-- <div class="col-md-6 fb-share-button-wrapper">
				<div class="fb-share-button" data-layout="button"></div>
			</div> -->
		</div>
		<div class="col-md-12 vote-poll">
			
		</div>
	</div>
</div>
<?php include_once "footer.php"; ?>