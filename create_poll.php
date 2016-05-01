<?php include_once "header.php"; ?>
<script type="text/javascript">

	// Accepts a url and a callback function to run.
	var requestCrossDomain = function( site, callback ) {
     
	    // If no url was passed, exit.
	    if ( !site ) {
	        alert('No site was passed.');
	        return false;
	    }
	     
	    var yql = 'http://query.yahooapis.com/v1/public/yql?q=' + encodeURIComponent('select * from html where url="' + site + '"') + '&format=xml&callback=';
	    
	    $.ajax({
	        type: "GET",
			url: yql,
			dataType: "xml",
			success: function(data) {
			    if ( data.getElementsByTagName("results") ) {
			        if ( typeof callback === 'function') {
			            callback(data);
			        }
			    }
			    else throw new Error('Nothing returned from getJSON.');
			}
		});
	}

	var fetchDataByUrl = function(){
		showLoader("Fetching data&hellip;");
		var url = $('.fetch-data-url').val();
		var site = "";

		if(url.indexOf("snapdeal") > -1){
			site = 'snapdeal';
		}
		// else if(url.indexOf("flipkart") > -1){
		// 	site = 'flipkart';
		// }
		else if(url.indexOf("myntra") > -1){
			site = 'myntra';
		}
		else{
			showLoader("The items from this site are not yet supported.", true);
			$('.fetch-data-url').val("");
			return;
		}

		requestCrossDomain(url, function(data){
			var $data = $(data);
			switch(site){
				case 'snapdeal':
					productImgSrc = $data.find('img.zoomPad').attr('src');
					productTitle = $data.find('.productTitle h1').text();
					productCost = "Rs. "+$data.find('#selling-price-id').text();
					break;
				// case 'flipkart':
				// 	productImgSrc = $data.find('.productImages .productImage.current').attr('data-imageid');
				// 	console.log(productImgSrc);
				// 	productTitle = $data.find('.product-details .title-wrap h1').text();
				// 	productCost = $data.find('.prices .selling-price').text();
				// 	break;
				case 'myntra':
					productImgSrc = $data.find('.summary .blowup img').attr('src');
					productTitle = $data.find('.info h1').text();
					$data.find('.info .price span').remove();
					productCost = $data.find('.info .price').text();
					break;
				case 'default':
					break;
			}

			var pollItem = '<a href="'+url+'" target="_blank" class="poll-item-link">'+
						    	'<div class="col-md-4 poll-item hvr-grow">'+
									'<div class="col-md-12 opacity-holder">'+
										'<div class="col-md-12 poll-item-inner">'+
											'<div class="col-md-12"><img class="img-responsive poll-item-image" src="'+productImgSrc+'"/></div>'+
											'<div class="col-md-12 no-left-right-padding poll-item-content">'+
												'<div class="col-md-12 no-left-right-padding poll-item-title"><h4>'+productTitle+'</h4></div>'+
												//'<div class="col-md-12 no-left-right-padding poll-item-description">This is a red dress. Pair it with Beige pumps for a casual evening.</div>'+
												'<div class="col-md-12 no-left-right-padding poll-item-cost">'+productCost+'</div>'+
											'</div>'+
										'</div>'+
										'<div class="opacity-div"></div>'+
									'</div>'+
								'</div></a>'
			$(pollItem).insertBefore('.poll-item.add-poll-item');

			poll[pollItemCount] = {"productImgSrc":productImgSrc, "productTitle":productTitle, "productCost":productCost, "productUrl":url};
			pollItemCount++;
			if(pollItemCount > 1){
				$('.create-poll-final-step, .create-or-more-txt').show();
			}
			$('.fetch-data-url').val("");
			hideLoader();
		});
    }

    var postPoll = function()
    {
    	showLoader("Your poll is being created. Don't forget to share it!");
		$.post('service/addPoll.php', 
			{
				"poll_options": poll,
				"poll_title": $('.poll-title').val(),
				"fb_user_id": localStorage.getItem("fb_user_id"),
				"fb_user_name": localStorage.getItem("fb_user_name"),
				"fb_user_email": localStorage.getItem("fb_user_email"),
				"fb_user_link": localStorage.getItem("fb_user_link")
			}, 
			function(data, status){
				$('.fetch-data-url').val("");
				hideLoader();
				window.location.assign("view_poll.php?poll_id="+data.poll_id);
			}
		);
	}

	var poll = [], pollItemCount = 0;

	$(document).ready(function(){
		$('.fetch-data').on('click', fetchDataByUrl);
		$('.create-poll-btn').on('click', postPoll);
	});
</script>
<div class="container">
	<div class="row">
		<div class="col-md-12 creat-poll">

			<div class="col-md-4 poll-item add-poll-item hvr-grow">
				<div class="col-md-12 opacity-holder">
					<div class="col-md-12 poll-item-inner">
						<div class="col-md-12 no-left-right-padding create-poll-final-step">
							<input type="text" class="poll-title" placeholder="eg. Shopping for new year's party. Just can't seem to decide!" maxlength="255">
							<button class="btn lg-btn btn-success create-poll-btn">Create!</button>
						</div>
						<div class="col-md-12 create-or-more-txt">
							OR
						</div>
						<div class="col-md-12 no-left-right-padding poll-item-search-by-url">
							<input type="text" name="fetch-data-url" class="fetch-data-url" placeholder="http://www.snapdeal.com/product/guess-white-passion-watch/1247217">
							<button class="btn sm-btn btn-primary fetch-data">Find!</button>
						</div>
						<div class="col-md-12 no-left-right-padding">
							<div class="fetch-data-note">* We currently support Snapdeal and Myntra</div>
							<div class="fetch-data-note">Enter product url in field and search.</div>
						</div>
					</div>
					<div class="opacity-div"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include_once "footer.php"; ?>