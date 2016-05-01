            </div>
            <footer class="footer">
				<div class="col-md-6 about-juxtachoose">About</div>
				<div class="col-md-6">&copy; 2015, Siya Kakodkar</div>
			</footer>
		</div>
		<div class="loader">
			<script type="text/javascript">
				$(document).ready(function(){
					$('.close-loader').on('click', function(){
						hideLoader();
					});
				});
			</script>
			<div class="loader-film"></div>
			<div class="loader-content">
				<div class="loader-msg">Loading&hellip;</div>
				<div>
					<img class="juxtachoose-loader" src="./images/juxtachoose_loader.gif">
				</div>
				<div class="glyphicon glyphicon-remove close-loader"></div>
			</div>
		</div>
		<script type="text/javascript">
			$(document).ready(function(){
				$('.about-juxtachoose').on('click', function(){
					window.location.assign("about.php");
				});
			});
		</script>
		<script id="_webengage_script_tag" type="text/javascript">
			var _weq = _weq || {};
			_weq['webengage.licenseCode'] = '~47b667d2';
			_weq['webengage.widgetVersion'] = "4.0";

			(function(d){
			var _we = d.createElement('script');
			_we.type = 'text/javascript';
			_we.async = true;
			_we.src = (d.location.protocol == 'https:' ? "https://ssl.widgets.webengage.com" : "http://cdn.widgets.webengage.com") + "/js/widget/webengage-min-v-4.0.js";
			var _sNode = d.getElementById('_webengage_script_tag');
			_sNode.parentNode.insertBefore(_we, _sNode);
			})(document);
		</script>
	</body>
</html>