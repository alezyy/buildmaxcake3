<?php if($this->Session->check('Auth.User.group_id')):		// admin user not counted in google analytics
	$show = $this->Session->read('Auth.User.group_id');
elseif($_SERVER['REMOTE_ADDR'] === '24.37.139.134'):		// office ip not counted in google analytics
	$show = '0';
else:
	$show = '5';	// insert google analytic code to logout user and login level 5 users (other levels are admins)
endif;?>
<?php if($show == 5) : ?>
<script type="text/javascript">
	/* <![CDATA[ */
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-1887224-2', 'topmenu.com');
  ga('require', 'displayfeatures');
  ga('send', 'pageview');
  <?php if($this->action === 'search'): ?>
  ga('send', 'pageview', {
    'page': '/<?php echo $langSuffix ?>/recherche?q=<?php echo strtoupper($gaGetParam) ?>',
    'title': 'Recherche'
  });
  <?php else: ?>
  ga('send', 'pageview');
  <?php endif; ?>

//<![CDATA[try{(function(a){var b="http://",c="www.topmenu.com",d="/cdn-cgi/cl/",e="img.gif",f=new a;f.src=[b,c,d,e].join("")})(Image)}catch(e){}//]]

//	(function(b) {
//		(function(a) {
//			"__CF"in b && "DJS"in b.__CF ? b.__CF.DJS.push(a) : "addEventListener"in b ? b.addEventListener("load", a, !1) : b.attachEvent("onload", a)
//		})(function() {
//			"FB"in b && "Event"in FB && "subscribe"in FB.Event && (FB.Event.subscribe("edge.create", function(a) {
//				_gaq.push(["_trackSocial", "facebook", "like", a])
//			}), FB.Event.subscribe("edge.remove", function(a) {
//				_gaq.push(["_trackSocial", "facebook", "unlike", a])
//			}), FB.Event.subscribe("message.send", function(a) {
//				_gaq.push(["_trackSocial", "facebook", "send", a])
//			}));
//			"twttr"in b && "events"in twttr && "bind"in twttr.events && twttr.events.bind("tweet", function(a) {
//				if (a) {
//					var b;
//					if (a.target && a.target.nodeName == "IFRAME")
//						a:{
//							if (a = a.target.src) {
//								a = a.split("#")[0].match(/[^?=&]+=([^&]*)?/g);
//								b = 0;
//								for (var c; c = a[b]; ++b)
//									if (c.indexOf("url") === 0) {
//										b = unescape(c.split("=")[1]);
//										break a
//									}
//							}
//							b = void 0
//						}
//					_gaq.push(["_trackSocial", "twitter", "tweet", b])
//				}
//			})
//		})
//	})(window);
	/* ]]> */
</script>
<?php endif;