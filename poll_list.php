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

	var datapoints = [];

	var getUserPolls = function()
	{
		$.post('service/getUserPolls.php', 
			{
				"fb_user_id": localStorage.getItem("fb_user_id"),
				"fb_user_name": localStorage.getItem("fb_user_name"),
				"fb_user_email": localStorage.getItem("fb_user_email"),
				"fb_user_link": localStorage.getItem("fb_user_link")
			}, 
			function(result, status){
				var items = [], html, item_html="", datapt = {}, all_datapt = [];
				if(result.length != 0){
					$.each( result, function( index, data ) {
						item_html = '<div class="col-md-4 poll-item hvr-grow poll_'+data.poll_id+'">'+
										'<div class="col-md-12 opacity-holder">'+
											'<div class="col-md-12 poll-item-inner">'+
												'<div class="col-md-12 poll-title"><a href="view_poll.php?poll_id='+data.poll_id+'" target="_blank" class="view-poll-link"><h3>'+data.poll_info.poll_title+'</h3></a></div>'+
												'<div class="col-md-12"><div class="poll-pie-chart"><div class="poll-pie-chart-inner"></div></div></div>';
						$.each( data.poll_options, function( key, val ) {
							datapt = {
								"poll_id": data.poll_id, 
								"votes": {
									"poll_option_id": val.poll_option_id,
									"votes": val.votes,
									"color": Colors.random()
								}
							};
							if(val.voters.length > 0){
								var voters = '', name;
								for(var j=0; j<val.voters.length; j++){
									if(j==0){
										name = val.voters[j]["name"];
									}
									else{
										name = ', '+val.voters[j]["name"];
									}
									if(val.voters[j]["fb_user_profile_link"]){
										voters += '<a class="voter-link" href="'+val.voters[j]["fb_user_link"]+'">'+name+'</a>';
									}
									else{
										voters += '<a class="voter-link" href="">'+name+'</a>';
									}
								}
							}
							all_datapt.push(datapt);
							item_html = item_html + ''+
										'<div class="col-md-12 no-left-right-padding poll-item-item" style="border-left-color:'+datapt['votes']['color']+';">'+
											'<div class="col-md-3 no-left-padding poll-item-item-image-wrapper">'+
												'<img class="img-responsive poll-item-item-image" src="'+val.img_src+'"/>'+
											'</div>'+
											'<div class="col-md-9 no-left-padding">'+
												'<a href="'+val.product_url+'" target="_blank" class="poll-item-link"><div class="col-md-12 no-left-right-padding poll-item-item-title"><h4>'+val.img_desc+'</h4></div></a>'+
												'<div class="col-md-12 no-left-right-padding poll-item-item-cost">'+val.cost+'</div>';
							if(voters){
								item_html = item_html + '<div class="col-md-12 no-left-right-padding poll-item-item-voters">' + voters + '</div>';
							}
							item_html = item_html + '</div>'+
											'</div>';
						});
						item_html = item_html +'</div>'+
									'<div class="opacity-div"></div>'+
								'</div>'+
							'</div>'
						items.push(item_html);
						datapoints.push(all_datapt);
						all_datapt = [];
					});
					$('.view-user-poll').append(items.join(""));
					for(var k=0; k<datapoints.length; k++){
						setPieChart(datapoints[k]);
					}
				}
				else{
					$('<div class="col-md-12 welcome-msg">'+
						'<h3>You donnot have any polls registered.</h3>'+
						'<h4>Get a little help from your friends &hellip;</h4>'+
						'<a href="create_poll.php" class="btn sm-btn btn-primary create-first-poll">Create Poll!</a>'+
					'</div>').insertBefore('.view-user-poll');
					$('.view-user-poll').remove();
				}
				hideLoader();
				//$('.fb-share-button').attr("data-href", "http://juxtachoose.appspot.com:8081/vote.php?poll_id="+getUrlParameter('poll_id'));
			}
		);
	}

	$(document).ready(function(){
		showLoader("Your polls are being loaded&hellip;");
		getUserPolls();
	});
</script>
<div class="container">
	<div class="row">
		<div class="col-md-12 view-user-poll">

		</div>
	</div>
</div>

<?php include_once "footer.php"; ?>