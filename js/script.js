// (function(){
	Colors = {};
	Colors.names = {
	    aqua: "#00ffff",
	    azure: "#f0ffff",
	    beige: "#f5f5dc",
	    black: "#000000",
	    blue: "#0000ff",
	    brown: "#a52a2a",
	    cyan: "#00ffff",
	    darkblue: "#00008b",
	    darkcyan: "#008b8b",
	    darkgrey: "#a9a9a9",
	    darkgreen: "#006400",
	    darkkhaki: "#bdb76b",
	    darkmagenta: "#8b008b",
	    darkolivegreen: "#556b2f",
	    darkorange: "#ff8c00",
	    darkorchid: "#9932cc",
	    darkred: "#8b0000",
	    darksalmon: "#e9967a",
	    darkviolet: "#9400d3",
	    fuchsia: "#ff00ff",
	    gold: "#ffd700",
	    green: "#008000",
	    indigo: "#4b0082",
	    khaki: "#f0e68c",
	    lightblue: "#add8e6",
	    lightcyan: "#e0ffff",
	    lightgreen: "#90ee90",
	    lightgrey: "#d3d3d3",
	    lightpink: "#ffb6c1",
	    lightyellow: "#ffffe0",
	    lime: "#00ff00",
	    magenta: "#ff00ff",
	    maroon: "#800000",
	    navy: "#000080",
	    olive: "#808000",
	    orange: "#ffa500",
	    pink: "#ffc0cb",
	    purple: "#800080",
	    violet: "#800080",
	    red: "#ff0000",
	    silver: "#c0c0c0",
	    // white: "#ffffff",
	    yellow: "#ffff00"
	};

	Colors.random = function() {
	    var result;
	    var count = 0;
	    for (var prop in this.names)
	        if (Math.random() < 1/++count)
	           result = prop;
	    return result;
	};

	var getRandomColor = function() {
	    var letters = '0123456789ABCDEF'.split('');
	    var color = '#';
	    for (var i = 0; i < 6; i++ ) {
	        color += letters[Math.floor(Math.random() * 16)];
	    }
	    return color;
	}

	$.style={
		insertRule:function(selector,rules,contxt)
		{
			var context=contxt||document,stylesheet;

			if(typeof context.styleSheets=='object')
			{
				if(context.styleSheets.length)
				{
					stylesheet=context.styleSheets[context.styleSheets.length-1];
				}
				if(context.styleSheets.length)
				{
					if(context.createStyleSheet)
					{
						stylesheet=context.createStyleSheet();
					}
					else
					{
						context.getElementsByTagName('head')[0].appendChild(context.createElement('style'));
						stylesheet=context.styleSheets[context.styleSheets.length-1];
					}
				}
				if(stylesheet.addRule)
				{
					for(var i=0;i<selector.length;++i)
					{
						stylesheet.addRule(selector[i],rules);
					}
				}
				else
				{
					stylesheet.insertRule(selector.join(',') + '{' + rules + '}', stylesheet.cssRules.length);  
				}
			}
		}
	};
	// $.style.insertRule(['p','h1'], 'color:red;');
	// $.style.insertRule(['p'],      'text-decoration:line-through;');
	// $.style.insertRule(['div p'],  'text-decoration:none;color:blue');

	var setPieChart = function(datapoints){
		var html = "";
		var i, l = datapoints.length, totalVotes = 0, degree = 0, startVal = 0, endValue = 0, dataValue = 0;
		// datapoints.push({
		// 	"poll_id": data.poll_id, 
		// 	"votes": {
		// 		"poll_option_id": val.poll_option_id,
		// 		"votes": val.votes,
		// 		"color": Colors.random()
		// 	}
		// });
		var n = 0;
		var selector = ".poll_";

		$.each( datapoints, function( key, data ) {
			totalVotes += data['votes']['votes'];
			selector = ".poll_"+datapoints[0]['poll_id'];
			if(data['votes']['votes'] == 0){
				$.style.insertRule([selector + ' .pie:nth-of-type('+(n+1)+'):BEFORE, ' + selector + ' .pie:nth-of-type('+(n+1)+'):AFTER'], 'background-color:transparent;');
			}
			if(data['votes']['votes'] != 0){
				$.style.insertRule([selector + ' .pie:nth-of-type('+(n+1)+'):BEFORE, ' + selector + ' .pie:nth-of-type('+(n+1)+'):AFTER'], 'background-color:'+ data['votes']['color'] +';');
			}
			n++;
		});
		if(totalVotes == 0){
			$('.poll-pie-chart-inner', selector).html("No votes.");
			$('.poll-pie-chart', selector).addClass('no-votes');
			return
		}
		var m = 0;
		selector = ".poll_"+datapoints[0]['poll_id'];
		$.each( datapoints, function( key, data ) {
			if(data['votes']['votes'] != 0){
				degree = Math.floor((data['votes']['votes'] * 360) / totalVotes);

				html = "";
				startVal = endValue;
				endValue = degree + startVal;
				dataValue = degree;

				if(m != 0){
					$.style.insertRule([selector + ' .pie[data-start="'+startVal+'"]'], '-moz-transform: rotate('+startVal+'deg); -ms-transform: rotate('+startVal+'deg); -webkit-transform: rotate('+startVal+'deg); -o-transform: rotate('+startVal+'deg); transform:rotate('+startVal+'deg);');
				}
				if((m == (l-1)) && ((startVal + dataValue) !=360)) {
					dataValue = (360 - startVal);
				}
				if(degree > 90){
					if((totalVotes == 2) && (degree == 180) && (m == (l-1))){
						html = '<div class="pie equally-big" data-start="'+ startVal +'" data-value="'+ dataValue +'"></div>';
					}
					else
					{
						html = '<div class="pie big" data-start="'+ startVal +'" data-value="'+ dataValue +'"></div>';
						$('.poll-pie-chart-inner .big', selector).removeClass('big');
					}
				}
				else{
					html = '<div class="pie" data-start="'+ startVal +'" data-value="'+ dataValue +'"></div>';
				}
				if((m == (l-1)) && ((startVal + dataValue) ==360)) {
					$.style.insertRule([selector + ' .pie[data-value="'+dataValue+'"]:BEFORE'], '-moz-transform: rotate('+(dataValue)+'deg); -ms-transform: rotate('+(dataValue)+'deg); -webkit-transform: rotate('+(dataValue)+'deg); -o-transform: rotate('+(dataValue)+'deg); transform:rotate('+(dataValue)+'deg);');
				}
				else{
					$.style.insertRule([selector + '.pie[data-value="'+dataValue+'"]:BEFORE'], '-moz-transform: rotate('+(dataValue+1)+'deg); -ms-transform: rotate('+(dataValue+1)+'deg); -webkit-transform: rotate('+(dataValue+1)+'deg); -o-transform: rotate('+(dataValue+1)+'deg); transform:rotate('+(dataValue+1)+'deg);');
				}
				$('.poll-pie-chart-inner', selector).append(html);
			}	
			else{
				degree = 00;
				startVal = 00;
				endValue = 00;
				dataValue = 00;

				$.style.insertRule([selector + ' .pie[data-start="'+startVal+'"]'], '-moz-transform: rotate('+startVal+'deg); -ms-transform: rotate('+startVal+'deg); -webkit-transform: rotate('+startVal+'deg); -o-transform: rotate('+startVal+'deg); transform:rotate('+startVal+'deg);');
				
				html = '<div class="pie pie-none" data-start="'+ startVal +'" data-value="'+ dataValue +'"></div>';
				$.style.insertRule([selector + ' .pie[data-value="'+dataValue+'"]:BEFORE'], '-moz-transform: rotate('+(dataValue)+'deg); -ms-transform: rotate('+(dataValue)+'deg); -webkit-transform: rotate('+(dataValue)+'deg); -o-transform: rotate('+(dataValue)+'deg); transform:rotate('+(dataValue)+'deg);');
			
				$('.poll-pie-chart-inner', selector).append(html);
			}
			m++;
		});
	}

	var showLoader = function(msg, isError){
		if(!msg){
			msg = "Loading&hellip;"
		}
		$('.loader-msg').html(msg);
		$('.loader').show();
		if(isError){
			$('.close-loader').show();
			$('.juxtachoose-loader').hide();
		}
	}

	var hideLoader = function(){
		$('.loader').hide();
		$('.close-loader').hide();
	}

	$(document).ready(function(){
		$('.fb-login-button').on('click', function(){
			window.location.assign("welcome.php");
		});
	});
// })();