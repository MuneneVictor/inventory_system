<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
  <meta name="description" content="Family Tech - Premium IT products: laptops, desktops, monitors, printers, UPS, and all computer accessories. Best deals on tech for home, office, and gaming.">
  <meta name="keywords" content="laptops, desktops, all-in-ones, mini PCs, workstations, monitors, printers, smartboards, UPS, computer accessories, Family Tech">
  <meta name="author" content="Family Tech">
  <meta name="robots" content="index, follow">
  <title>Family Tech | Premium IT Shop – Laptops, Desktops & Accessories</title>
  <!-- Google Fonts & Font Awesome -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: #f8fafc;
      color: #0a1e2f;
      scroll-behavior: smooth;
    }

    /* modern glassmorphism & gradients */
    :root {
      --primary: #3b3bdb;
      --primary-dark: #2a2ab0;
      --secondary: #f97316;
      --accent: #10b981;
      --dark: #0f172a;
      --light: #ffffff;
      --gray-bg: #f1f5f9;
      --card-shadow: 0 25px 45px -12px rgba(0, 0, 0, 0.15);
    }

    /* container */
    .container {
      max-width: 1400px;
      margin: 0 auto;
      padding: 0 30px;
    }

    /* header */
    .header {
      background: rgba(255,255,255,0.96);
      backdrop-filter: blur(8px);
      box-shadow: 0 4px 30px rgba(0,0,0,0.03);
      position: sticky;
      top: 0;
      z-index: 100;
      border-bottom: 1px solid rgba(59,59,219,0.1);
    }

    .nav {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      padding: 18px 0;
    }

    .logo h1 {
      font-size: 1.9rem;
      font-weight: 800;
      background: linear-gradient(135deg, #3b3bdb, #f97316);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      letter-spacing: -0.5px;
    }
    .logo span {
      font-size: 0.9rem;
      font-weight: 500;
      color: #4b5563;
      display: block;
    }

    .nav-links {
      display: flex;
      gap: 2rem;
      align-items: center;
    }
    .nav-links a {
      text-decoration: none;
      font-weight: 600;
      color: #1e293b;
      transition: 0.2s;
    }
    .nav-links a:hover, .nav-links a.active {
      color: var(--primary);
    }
    .cart-icon {
      position: relative;
      font-size: 1.5rem;
      cursor: pointer;
    }
    .cart-count {
      position: absolute;
      top: -8px;
      right: -12px;
      background: var(--secondary);
      color: white;
      font-size: 0.7rem;
      font-weight: bold;
      border-radius: 30px;
      padding: 2px 6px;
    }

    /* hero section */
    .hero {
      background: linear-gradient(120deg, #eef2ff 0%, #ffffff 100%);
      padding: 70px 0;
      border-radius: 0 0 50px 50px;
      margin-bottom: 40px;
    }
    .hero-grid {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
      gap: 40px;
    }
    .hero-text h2 {
      font-size: 3.2rem;
      font-weight: 800;
      line-height: 1.2;
      background: linear-gradient(to right, #0f172a, #3b3bdb);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }
    .hero-text p {
      font-size: 1.2rem;
      margin: 20px 0;
      color: #334155;
    }
    .btn {
      display: inline-block;
      background: var(--primary);
      color: white;
      padding: 12px 32px;
      border-radius: 40px;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.2s ease;
      border: none;
      cursor: pointer;
      box-shadow: 0 8px 14px rgba(59,59,219,0.2);
    }
    .btn:hover {
      background: var(--primary-dark);
      transform: translateY(-2px);
    }
    .btn-outline {
      background: transparent;
      border: 2px solid var(--primary);
      color: var(--primary);
      box-shadow: none;
    }
    .hero-stats {
      display: flex;
      gap: 30px;
      margin-top: 30px;
    }

    /* categories / product grid */
    .section-title {
      font-size: 2rem;
      font-weight: 700;
      margin: 50px 0 25px 0;
      border-left: 5px solid var(--secondary);
      padding-left: 20px;
    }
    .products-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 30px;
      margin-bottom: 60px;
    }
    .product-card {
      background: white;
      border-radius: 28px;
      overflow: hidden;
      transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
      box-shadow: 0 8px 20px rgba(0,0,0,0.05);
      cursor: pointer;
      position: relative;
    }
    .product-card:hover {
      transform: translateY(-8px);
      box-shadow: var(--card-shadow);
    }
    .product-img {
      background: linear-gradient(145deg, #f1f5f9, #e6edf4);
      height: 220px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 4rem;
      color: var(--primary);
    }
    .product-info {
      padding: 1.5rem;
    }
    .product-category {
      font-size: 0.75rem;
      text-transform: uppercase;
      font-weight: 700;
      color: var(--secondary);
      letter-spacing: 1px;
    }
    .product-title {
      font-size: 1.25rem;
      font-weight: 700;
      margin: 8px 0;
    }
    .product-price {
      font-size: 1.5rem;
      font-weight: 800;
      color: var(--primary-dark);
      margin: 12px 0;
    }
    .add-to-cart {
      background: #0f172a;
      width: 100%;
      border: none;
      padding: 12px;
      border-radius: 40px;
      color: white;
      font-weight: 600;
      transition: 0.2s;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }
    .add-to-cart:hover {
      background: var(--primary);
    }

    /* cart sidebar */
    .cart-overlay {
      position: fixed;
      top: 0;
      right: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.4);
      backdrop-filter: blur(5px);
      z-index: 1000;
      visibility: hidden;
      opacity: 0;
      transition: 0.2s;
    }
    .cart-sidebar {
      position: fixed;
      top: 0;
      right: -450px;
      width: 400px;
      max-width: 90vw;
      height: 100%;
      background: white;
      box-shadow: -10px 0 30px rgba(0,0,0,0.1);
      z-index: 1001;
      transition: 0.3s ease;
      display: flex;
      flex-direction: column;
      padding: 25px;
    }
    .cart-sidebar.open {
      right: 0;
    }
    .cart-overlay.open {
      visibility: visible;
      opacity: 1;
    }
    .cart-header {
      display: flex;
      justify-content: space-between;
      font-weight: 800;
      font-size: 1.5rem;
      border-bottom: 2px solid #eef2ff;
      padding-bottom: 15px;
    }
    .cart-items {
      flex: 1;
      overflow-y: auto;
      margin: 20px 0;
    }
    .cart-item {
      display: flex;
      justify-content: space-between;
      margin-bottom: 15px;
      padding: 10px 0;
      border-bottom: 1px solid #e2e8f0;
    }
    .cart-total {
      font-weight: 800;
      font-size: 1.3rem;
      padding: 15px 0;
      border-top: 2px dashed #cbd5e1;
    }
    .checkout-btn {
      background: var(--accent);
      width: 100%;
      padding: 14px;
      border: none;
      border-radius: 40px;
      font-weight: bold;
      color: white;
      font-size: 1rem;
    }

    /* footer */
    .footer {
      background: #0a1e2f;
      color: #cbd5e6;
      padding: 50px 0 30px;
      margin-top: 70px;
    }
    .footer-grid {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      gap: 30px;
    }
    .footer-col h4 {
      color: white;
      margin-bottom: 20px;
    }
    .footer-col p, .footer-col a {
      color: #94a3b8;
      text-decoration: none;
    }
    .social i {
      font-size: 1.5rem;
      margin-right: 15px;
      transition: 0.2s;
      color: #cbd5e6;
    }
    .copyright {
      text-align: center;
      padding-top: 40px;
      font-size: 0.8rem;
    }

    @media (max-width: 780px) {
      .nav {
        flex-direction: column;
        gap: 12px;
      }
      .hero-text h2 {
        font-size: 2.3rem;
      }
    }
  </style>
</head>
<body>

<div class="header">
  <div class="container">
    <div class="nav">
      <div class="logo">
        <h1>Family Tech</h1>
        <span>⚡ Power your digital life</span>
      </div>
      <div class="nav-links">
        <a href="#" class="active">Home</a>
        <a href="#">Shop</a>
        <a href="#">Deals</a>
        <a href="#">Support</a>
        <div class="cart-icon" id="cartIcon">
          <i class="fas fa-shopping-cart"></i>
          <span class="cart-count" id="cartCount">0</span>
        </div>
      </div>
    </div>
  </div>
</div>

<section class="hero">
  <div class="container hero-grid">
    <div class="hero-text">
      <h2>Next-Gen IT Gear<br>for Home & Business</h2>
      <p>Laptops · Desktops · Workstations · Monitors · Printers · Smartboards · UPS & Accessories</p>
      <a href="#products" class="btn">Shop Now →</a>
      <div class="hero-stats">
        <div><strong>⭐ 4.9/5</strong><br>Trusted reviews</div>
        <div><strong>🚚 Free shipping</strong><br>on orders $500+</div>
        <div><strong>💎 2Y warranty</strong><br>on premium gear</div>
      </div>
    </div>
    <div class="hero-img">
      <i class="fas fa-laptop-code" style="font-size: 10rem; color: #3b3bdb80;"></i>
    </div>
  </div>
</section>

<div class="container" id="products">
  <div class="section-title">🔥 Bestsellers & New Arrivals</div>
  <div class="products-grid" id="productsGrid"></div>
</div>

<!-- Cart Sidebar -->
<div class="cart-overlay" id="cartOverlay"></div>
<div class="cart-sidebar" id="cartSidebar">
  <div class="cart-header">
    <span>🛒 Your Cart</span>
    <i class="fas fa-times" id="closeCart" style="cursor:pointer;"></i>
  </div>
  <div class="cart-items" id="cartItemsList">
    <p style="color:#94a3b8;">Your cart is empty</p>
  </div>
  <div class="cart-total" id="cartTotal">Total: $0</div>
  <button class="checkout-btn" id="checkoutBtn">Proceed to Checkout 🚀</button>
</div>

<footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-col">
        <h4>Family Tech</h4>
        <p>Your trusted IT partner since 2024. Premium computers, monitors, UPS, accessories & expert support.</p>
      </div>
      <div class="footer-col">
        <h4>Quick links</h4>
        <p><a href="#">Laptops</a></p>
        <p><a href="#">Desktops & Workstations</a></p>
        <p><a href="#">Monitors & Smartboards</a></p>
        <p><a href="#">Printers & UPS</a></p>
      </div>
      <div class="footer-col">
        <h4>Contact</h4>
        <p><i class="fas fa-envelope"></i> hello@familytech.com</p>
        <p><i class="fas fa-phone-alt"></i> +1 (800) 234-9876</p>
        <div class="social">
          <i class="fab fa-instagram"></i>
          <i class="fab fa-facebook"></i>
          <i class="fab fa-x-twitter"></i>
        </div>
<!DOCTYPE html>
<html dir="ltr" lang="en" prefix="og: https://ogp.me/ns#">
<head>
	<meta charset="UTF-8">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="pingback" href="https://www.mombasacomputers.com/xmlrpc.php">

	<title>Mombasa Computers LTD - Mombasa Computers</title>
	<script type="text/javascript" src="https://gc.kis.v2.scr.kaspersky-labs.com/FD126C42-EBFA-4E12-B309-BB3FDD723AC1/main.js?attr=xBAfvOaqO1jVJZE22Goc5IwPiDLTlLegelxc4K-7z5zIUZS-3C24n4Y0WJJYmX2K_ZXz6FjxsPjDW5OAvYQTXA" charset="UTF-8"></script><style>img:is([sizes="auto" i], [sizes^="auto," i]) { contain-intrinsic-size: 3000px 1500px }</style>
	
		<!-- All in One SEO Pro 4.9.6.2 - aioseo.com -->
	<meta name="description" content="We are the leading online computer shop in Nairobi, Kenya. Our laptops, desktops, printers and accessories are of the best quality and very budget friendly." />
	<meta name="robots" content="max-image-preview:large" />
	<meta name="google-site-verification" content="gu0iPZ9H7Z4ZWT3sNezDsinl3FS1BnpKQKIMsuqUTuA" />
	<link rel="canonical" href="https://www.mombasacomputers.com/" />
	<meta name="generator" content="All in One SEO Pro (AIOSEO) 4.9.6.2" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:site_name" content="Mombasa Computers - Mombasa computers | Laptops in Kenya, Computers in Kenya, Refurbished Laptops in Kenya, Ex UK Laptops in Kenya" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="Mombasa Computers LTD - Mombasa Computers" />
		<meta property="og:description" content="We are the leading online computer shop in Nairobi, Kenya. Our laptops, desktops, printers and accessories are of the best quality and very budget friendly." />
		<meta property="og:url" content="https://www.mombasacomputers.com/" />
		<meta property="article:published_time" content="2017-11-29T08:00:02+00:00" />
		<meta property="article:modified_time" content="2026-05-21T13:46:17+00:00" />
		<meta name="twitter:card" content="summary" />
		<meta name="twitter:title" content="Mombasa Computers LTD - Mombasa Computers" />
		<meta name="twitter:description" content="We are the leading online computer shop in Nairobi, Kenya. Our laptops, desktops, printers and accessories are of the best quality and very budget friendly." />
		<script type="application/ld+json" class="aioseo-schema">
			{"@context":"https:\/\/schema.org","@graph":[{"@type":"BreadcrumbList","@id":"https:\/\/www.mombasacomputers.com\/#breadcrumblist","itemListElement":[{"@type":"ListItem","@id":"https:\/\/www.mombasacomputers.com#listItem","position":1,"name":"Home"}]},{"@type":"Organization","@id":"https:\/\/www.mombasacomputers.com\/#organization","name":"Mombasa Computers","description":"Mombasa computers | Laptops in Kenya, Computers in Kenya, Refurbished Laptops in Kenya, Ex UK Laptops in Kenya","url":"https:\/\/www.mombasacomputers.com\/"},{"@type":"WebPage","@id":"https:\/\/www.mombasacomputers.com\/#webpage","url":"https:\/\/www.mombasacomputers.com\/","name":"Mombasa Computers LTD - Mombasa Computers","description":"We are the leading online computer shop in Nairobi, Kenya. Our laptops, desktops, printers and accessories are of the best quality and very budget friendly.","inLanguage":"en","isPartOf":{"@id":"https:\/\/www.mombasacomputers.com\/#website"},"breadcrumb":{"@id":"https:\/\/www.mombasacomputers.com\/#breadcrumblist"},"datePublished":"2017-11-29T08:00:02+00:00","dateModified":"2026-05-21T13:46:17+00:00"},{"@type":"WebSite","@id":"https:\/\/www.mombasacomputers.com\/#website","url":"https:\/\/www.mombasacomputers.com\/","name":"Mombasa Computers","description":"Mombasa computers | Laptops in Kenya, Computers in Kenya, Refurbished Laptops in Kenya, Ex UK Laptops in Kenya","inLanguage":"en","publisher":{"@id":"https:\/\/www.mombasacomputers.com\/#organization"}}]}
		</script>
		<!-- All in One SEO Pro -->

<link rel='dns-prefetch' href='//fonts.googleapis.com' />
<link rel="alternate" type="application/rss+xml" title="Mombasa Computers &raquo; Feed" href="https://www.mombasacomputers.com/feed/" />
<link rel="alternate" type="application/rss+xml" title="Mombasa Computers &raquo; Comments Feed" href="https://www.mombasacomputers.com/comments/feed/" />
		<!-- This site uses the Google Analytics by MonsterInsights plugin v10.1.3 - Using Analytics tracking - https://www.monsterinsights.com/ -->
							<script src="//www.googletagmanager.com/gtag/js?id=G-DDS5WX5KYJ"  data-cfasync="false" data-wpfc-render="false" type="text/javascript" async></script>
			<script data-cfasync="false" data-wpfc-render="false" type="text/javascript">
				var mi_version = '10.1.3';
				var mi_track_user = true;
				var mi_no_track_reason = '';
								var MonsterInsightsDefaultLocations = {"page_location":"https:\/\/www.mombasacomputers.com\/"};
								if ( typeof MonsterInsightsPrivacyGuardFilter === 'function' ) {
					var MonsterInsightsLocations = (typeof MonsterInsightsExcludeQuery === 'object') ? MonsterInsightsPrivacyGuardFilter( MonsterInsightsExcludeQuery ) : MonsterInsightsPrivacyGuardFilter( MonsterInsightsDefaultLocations );
				} else {
					var MonsterInsightsLocations = (typeof MonsterInsightsExcludeQuery === 'object') ? MonsterInsightsExcludeQuery : MonsterInsightsDefaultLocations;
				}

								var disableStrs = [
										'ga-disable-G-DDS5WX5KYJ',
									];

				/* Function to detect opted out users */
				function __gtagTrackerIsOptedOut() {
					for (var index = 0; index < disableStrs.length; index++) {
						if (document.cookie.indexOf(disableStrs[index] + '=true') > -1) {
							return true;
						}
					}

					return false;
				}

				/* Disable tracking if the opt-out cookie exists. */
				if (__gtagTrackerIsOptedOut()) {
					for (var index = 0; index < disableStrs.length; index++) {
						window[disableStrs[index]] = true;
					}
				}

				/* Opt-out function */
				function __gtagTrackerOptout() {
					for (var index = 0; index < disableStrs.length; index++) {
						document.cookie = disableStrs[index] + '=true; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/';
						window[disableStrs[index]] = true;
					}
				}

				if ('undefined' === typeof gaOptout) {
					function gaOptout() {
						__gtagTrackerOptout();
					}
				}
								window.dataLayer = window.dataLayer || [];

				window.MonsterInsightsDualTracker = {
					helpers: {},
					trackers: {},
				};
				if (mi_track_user) {
					function __gtagDataLayer() {
						dataLayer.push(arguments);
					}

					function __gtagTracker(type, name, parameters) {
						if (!parameters) {
							parameters = {};
						}

						if (parameters.send_to) {
							__gtagDataLayer.apply(null, arguments);
							return;
						}

						if (type === 'event') {
														parameters.send_to = monsterinsights_frontend.v4_id;
							var hookName = name;
							if (typeof parameters['event_category'] !== 'undefined') {
								hookName = parameters['event_category'] + ':' + name;
							}

							if (typeof MonsterInsightsDualTracker.trackers[hookName] !== 'undefined') {
								MonsterInsightsDualTracker.trackers[hookName](parameters);
							} else {
								__gtagDataLayer('event', name, parameters);
							}
							
						} else {
							__gtagDataLayer.apply(null, arguments);
						}
					}

					__gtagTracker('js', new Date());
					__gtagTracker('set', {
						'developer_id.dZGIzZG': true,
											});
					if ( MonsterInsightsLocations.page_location ) {
						__gtagTracker('set', MonsterInsightsLocations);
					}
										__gtagTracker('config', 'G-DDS5WX5KYJ', {"forceSSL":"true","link_attribution":"true"} );
										window.gtag = __gtagTracker;										(function () {
						/* https://developers.google.com/analytics/devguides/collection/analyticsjs/ */
						/* ga and __gaTracker compatibility shim. */
						var noopfn = function () {
							return null;
						};
						var newtracker = function () {
							return new Tracker();
						};
						var Tracker = function () {
							return null;
						};
						var p = Tracker.prototype;
						p.get = noopfn;
						p.set = noopfn;
						p.send = function () {
							var args = Array.prototype.slice.call(arguments);
							args.unshift('send');
							__gaTracker.apply(null, args);
						};
						var __gaTracker = function () {
							var len = arguments.length;
							if (len === 0) {
								return;
							}
							var f = arguments[len - 1];
							if (typeof f !== 'object' || f === null || typeof f.hitCallback !== 'function') {
								if ('send' === arguments[0]) {
									var hitConverted, hitObject = false, action;
									if ('event' === arguments[1]) {
										if ('undefined' !== typeof arguments[3]) {
											hitObject = {
												'eventAction': arguments[3],
												'eventCategory': arguments[2],
												'eventLabel': arguments[4],
												'value': arguments[5] ? arguments[5] : 1,
											}
										}
									}
									if ('pageview' === arguments[1]) {
										if ('undefined' !== typeof arguments[2]) {
											hitObject = {
												'eventAction': 'page_view',
												'page_path': arguments[2],
											}
										}
									}
									if (typeof arguments[2] === 'object') {
										hitObject = arguments[2];
									}
									if (typeof arguments[5] === 'object') {
										Object.assign(hitObject, arguments[5]);
									}
									if ('undefined' !== typeof arguments[1].hitType) {
										hitObject = arguments[1];
										if ('pageview' === hitObject.hitType) {
											hitObject.eventAction = 'page_view';
										}
									}
									if (hitObject) {
										action = 'timing' === arguments[1].hitType ? 'timing_complete' : hitObject.eventAction;
										hitConverted = mapArgs(hitObject);
										__gtagTracker('event', action, hitConverted);
									}
								}
								return;
							}

							function mapArgs(args) {
								var arg, hit = {};
								var gaMap = {
									'eventCategory': 'event_category',
									'eventAction': 'event_action',
									'eventLabel': 'event_label',
									'eventValue': 'event_value',
									'nonInteraction': 'non_interaction',
									'timingCategory': 'event_category',
									'timingVar': 'name',
									'timingValue': 'value',
									'timingLabel': 'event_label',
									'page': 'page_path',
									'location': 'page_location',
									'title': 'page_title',
									'referrer' : 'page_referrer',
								};
								for (arg in args) {
																		if (!(!args.hasOwnProperty(arg) || !gaMap.hasOwnProperty(arg))) {
										hit[gaMap[arg]] = args[arg];
									} else {
										hit[arg] = args[arg];
									}
								}
								return hit;
							}

							try {
								f.hitCallback();
							} catch (ex) {
							}
						};
						__gaTracker.create = newtracker;
						__gaTracker.getByName = newtracker;
						__gaTracker.getAll = function () {
							return [];
						};
						__gaTracker.remove = noopfn;
						__gaTracker.loaded = true;
						window['__gaTracker'] = __gaTracker;
					})();
									} else {
										console.log("");
					(function () {
						function __gtagTracker() {
							return null;
						}

						window['__gtagTracker'] = __gtagTracker;
						window['gtag'] = __gtagTracker;
					})();
									}
			</script>
							<!-- / Google Analytics by MonsterInsights -->
		<link rel='stylesheet' id='wp-block-library-css' href='https://www.mombasacomputers.com/wp-includes/css/dist/block-library/style.min.css?ver=a11bf4c3c9a1f863a745f8cd9b8b30d6' type='text/css' media='all' />
<link rel='stylesheet' id='aioseo/css/src/vue/standalone/blocks/table-of-contents/global.scss-css' href='https://www.mombasacomputers.com/wp-content/plugins/all-in-one-seo-pack-pro/dist/Pro/assets/css/table-of-contents/global.e90f6d47.css?ver=4.9.6.2' type='text/css' media='all' />
<link rel='stylesheet' id='aioseo/css/src/vue/standalone/blocks/pro/recipe/global.scss-css' href='https://www.mombasacomputers.com/wp-content/plugins/all-in-one-seo-pack-pro/dist/Pro/assets/css/recipe/global.d86a4aa4.css?ver=4.9.6.2' type='text/css' media='all' />
<link rel='stylesheet' id='aioseo/css/src/vue/standalone/blocks/pro/product/global.scss-css' href='https://www.mombasacomputers.com/wp-content/plugins/all-in-one-seo-pack-pro/dist/Pro/assets/css/product/global.0f804f5f.css?ver=4.9.6.2' type='text/css' media='all' />
<link rel='stylesheet' id='metaslider-blocks-editor-css-css' href='https://www.mombasacomputers.com/wp-content/plugins/ml-slider/admin/assets/dist/css/editor-block.css?ver=3.109.0' type='text/css' media='all' property='stylesheet' />
<style id='global-styles-inline-css' type='text/css'>
:root{--wp--preset--aspect-ratio--square: 1;--wp--preset--aspect-ratio--4-3: 4/3;--wp--preset--aspect-ratio--3-4: 3/4;--wp--preset--aspect-ratio--3-2: 3/2;--wp--preset--aspect-ratio--2-3: 2/3;--wp--preset--aspect-ratio--16-9: 16/9;--wp--preset--aspect-ratio--9-16: 9/16;--wp--preset--color--black: #000000;--wp--preset--color--cyan-bluish-gray: #abb8c3;--wp--preset--color--white: #ffffff;--wp--preset--color--pale-pink: #f78da7;--wp--preset--color--vivid-red: #cf2e2e;--wp--preset--color--luminous-vivid-orange: #ff6900;--wp--preset--color--luminous-vivid-amber: #fcb900;--wp--preset--color--light-green-cyan: #7bdcb5;--wp--preset--color--vivid-green-cyan: #00d084;--wp--preset--color--pale-cyan-blue: #8ed1fc;--wp--preset--color--vivid-cyan-blue: #0693e3;--wp--preset--color--vivid-purple: #9b51e0;--wp--preset--gradient--vivid-cyan-blue-to-vivid-purple: linear-gradient(135deg,rgba(6,147,227,1) 0%,rgb(155,81,224) 100%);--wp--preset--gradient--light-green-cyan-to-vivid-green-cyan: linear-gradient(135deg,rgb(122,220,180) 0%,rgb(0,208,130) 100%);--wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange: linear-gradient(135deg,rgba(252,185,0,1) 0%,rgba(255,105,0,1) 100%);--wp--preset--gradient--luminous-vivid-orange-to-vivid-red: linear-gradient(135deg,rgba(255,105,0,1) 0%,rgb(207,46,46) 100%);--wp--preset--gradient--very-light-gray-to-cyan-bluish-gray: linear-gradient(135deg,rgb(238,238,238) 0%,rgb(169,184,195) 100%);--wp--preset--gradient--cool-to-warm-spectrum: linear-gradient(135deg,rgb(74,234,220) 0%,rgb(151,120,209) 20%,rgb(207,42,186) 40%,rgb(238,44,130) 60%,rgb(251,105,98) 80%,rgb(254,248,76) 100%);--wp--preset--gradient--blush-light-purple: linear-gradient(135deg,rgb(255,206,236) 0%,rgb(152,150,240) 100%);--wp--preset--gradient--blush-bordeaux: linear-gradient(135deg,rgb(254,205,165) 0%,rgb(254,45,45) 50%,rgb(107,0,62) 100%);--wp--preset--gradient--luminous-dusk: linear-gradient(135deg,rgb(255,203,112) 0%,rgb(199,81,192) 50%,rgb(65,88,208) 100%);--wp--preset--gradient--pale-ocean: linear-gradient(135deg,rgb(255,245,203) 0%,rgb(182,227,212) 50%,rgb(51,167,181) 100%);--wp--preset--gradient--electric-grass: linear-gradient(135deg,rgb(202,248,128) 0%,rgb(113,206,126) 100%);--wp--preset--gradient--midnight: linear-gradient(135deg,rgb(2,3,129) 0%,rgb(40,116,252) 100%);--wp--preset--font-size--small: 13px;--wp--preset--font-size--medium: 20px;--wp--preset--font-size--large: 36px;--wp--preset--font-size--x-large: 42px;--wp--preset--spacing--20: 0.44rem;--wp--preset--spacing--30: 0.67rem;--wp--preset--spacing--40: 1rem;--wp--preset--spacing--50: 1.5rem;--wp--preset--spacing--60: 2.25rem;--wp--preset--spacing--70: 3.38rem;--wp--preset--spacing--80: 5.06rem;--wp--preset--shadow--natural: 6px 6px 9px rgba(0, 0, 0, 0.2);--wp--preset--shadow--deep: 12px 12px 50px rgba(0, 0, 0, 0.4);--wp--preset--shadow--sharp: 6px 6px 0px rgba(0, 0, 0, 0.2);--wp--preset--shadow--outlined: 6px 6px 0px -3px rgba(255, 255, 255, 1), 6px 6px rgba(0, 0, 0, 1);--wp--preset--shadow--crisp: 6px 6px 0px rgba(0, 0, 0, 1);}:where(body) { margin: 0; }.wp-site-blocks > .alignleft { float: left; margin-right: 2em; }.wp-site-blocks > .alignright { float: right; margin-left: 2em; }.wp-site-blocks > .aligncenter { justify-content: center; margin-left: auto; margin-right: auto; }:where(.is-layout-flex){gap: 0.5em;}:where(.is-layout-grid){gap: 0.5em;}.is-layout-flow > .alignleft{float: left;margin-inline-start: 0;margin-inline-end: 2em;}.is-layout-flow > .alignright{float: right;margin-inline-start: 2em;margin-inline-end: 0;}.is-layout-flow > .aligncenter{margin-left: auto !important;margin-right: auto !important;}.is-layout-constrained > .alignleft{float: left;margin-inline-start: 0;margin-inline-end: 2em;}.is-layout-constrained > .alignright{float: right;margin-inline-start: 2em;margin-inline-end: 0;}.is-layout-constrained > .aligncenter{margin-left: auto !important;margin-right: auto !important;}.is-layout-constrained > :where(:not(.alignleft):not(.alignright):not(.alignfull)){margin-left: auto !important;margin-right: auto !important;}body .is-layout-flex{display: flex;}.is-layout-flex{flex-wrap: wrap;align-items: center;}.is-layout-flex > :is(*, div){margin: 0;}body .is-layout-grid{display: grid;}.is-layout-grid > :is(*, div){margin: 0;}body{padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;}a:where(:not(.wp-element-button)){text-decoration: none;}:root :where(.wp-element-button, .wp-block-button__link){background-color: #32373c;border-width: 0;color: #fff;font-family: inherit;font-size: inherit;line-height: inherit;padding: calc(0.667em + 2px) calc(1.333em + 2px);text-decoration: none;}.has-black-color{color: var(--wp--preset--color--black) !important;}.has-cyan-bluish-gray-color{color: var(--wp--preset--color--cyan-bluish-gray) !important;}.has-white-color{color: var(--wp--preset--color--white) !important;}.has-pale-pink-color{color: var(--wp--preset--color--pale-pink) !important;}.has-vivid-red-color{color: var(--wp--preset--color--vivid-red) !important;}.has-luminous-vivid-orange-color{color: var(--wp--preset--color--luminous-vivid-orange) !important;}.has-luminous-vivid-amber-color{color: var(--wp--preset--color--luminous-vivid-amber) !important;}.has-light-green-cyan-color{color: var(--wp--preset--color--light-green-cyan) !important;}.has-vivid-green-cyan-color{color: var(--wp--preset--color--vivid-green-cyan) !important;}.has-pale-cyan-blue-color{color: var(--wp--preset--color--pale-cyan-blue) !important;}.has-vivid-cyan-blue-color{color: var(--wp--preset--color--vivid-cyan-blue) !important;}.has-vivid-purple-color{color: var(--wp--preset--color--vivid-purple) !important;}.has-black-background-color{background-color: var(--wp--preset--color--black) !important;}.has-cyan-bluish-gray-background-color{background-color: var(--wp--preset--color--cyan-bluish-gray) !important;}.has-white-background-color{background-color: var(--wp--preset--color--white) !important;}.has-pale-pink-background-color{background-color: var(--wp--preset--color--pale-pink) !important;}.has-vivid-red-background-color{background-color: var(--wp--preset--color--vivid-red) !important;}.has-luminous-vivid-orange-background-color{background-color: var(--wp--preset--color--luminous-vivid-orange) !important;}.has-luminous-vivid-amber-background-color{background-color: var(--wp--preset--color--luminous-vivid-amber) !important;}.has-light-green-cyan-background-color{background-color: var(--wp--preset--color--light-green-cyan) !important;}.has-vivid-green-cyan-background-color{background-color: var(--wp--preset--color--vivid-green-cyan) !important;}.has-pale-cyan-blue-background-color{background-color: var(--wp--preset--color--pale-cyan-blue) !important;}.has-vivid-cyan-blue-background-color{background-color: var(--wp--preset--color--vivid-cyan-blue) !important;}.has-vivid-purple-background-color{background-color: var(--wp--preset--color--vivid-purple) !important;}.has-black-border-color{border-color: var(--wp--preset--color--black) !important;}.has-cyan-bluish-gray-border-color{border-color: var(--wp--preset--color--cyan-bluish-gray) !important;}.has-white-border-color{border-color: var(--wp--preset--color--white) !important;}.has-pale-pink-border-color{border-color: var(--wp--preset--color--pale-pink) !important;}.has-vivid-red-border-color{border-color: var(--wp--preset--color--vivid-red) !important;}.has-luminous-vivid-orange-border-color{border-color: var(--wp--preset--color--luminous-vivid-orange) !important;}.has-luminous-vivid-amber-border-color{border-color: var(--wp--preset--color--luminous-vivid-amber) !important;}.has-light-green-cyan-border-color{border-color: var(--wp--preset--color--light-green-cyan) !important;}.has-vivid-green-cyan-border-color{border-color: var(--wp--preset--color--vivid-green-cyan) !important;}.has-pale-cyan-blue-border-color{border-color: var(--wp--preset--color--pale-cyan-blue) !important;}.has-vivid-cyan-blue-border-color{border-color: var(--wp--preset--color--vivid-cyan-blue) !important;}.has-vivid-purple-border-color{border-color: var(--wp--preset--color--vivid-purple) !important;}.has-vivid-cyan-blue-to-vivid-purple-gradient-background{background: var(--wp--preset--gradient--vivid-cyan-blue-to-vivid-purple) !important;}.has-light-green-cyan-to-vivid-green-cyan-gradient-background{background: var(--wp--preset--gradient--light-green-cyan-to-vivid-green-cyan) !important;}.has-luminous-vivid-amber-to-luminous-vivid-orange-gradient-background{background: var(--wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange) !important;}.has-luminous-vivid-orange-to-vivid-red-gradient-background{background: var(--wp--preset--gradient--luminous-vivid-orange-to-vivid-red) !important;}.has-very-light-gray-to-cyan-bluish-gray-gradient-background{background: var(--wp--preset--gradient--very-light-gray-to-cyan-bluish-gray) !important;}.has-cool-to-warm-spectrum-gradient-background{background: var(--wp--preset--gradient--cool-to-warm-spectrum) !important;}.has-blush-light-purple-gradient-background{background: var(--wp--preset--gradient--blush-light-purple) !important;}.has-blush-bordeaux-gradient-background{background: var(--wp--preset--gradient--blush-bordeaux) !important;}.has-luminous-dusk-gradient-background{background: var(--wp--preset--gradient--luminous-dusk) !important;}.has-pale-ocean-gradient-background{background: var(--wp--preset--gradient--pale-ocean) !important;}.has-electric-grass-gradient-background{background: var(--wp--preset--gradient--electric-grass) !important;}.has-midnight-gradient-background{background: var(--wp--preset--gradient--midnight) !important;}.has-small-font-size{font-size: var(--wp--preset--font-size--small) !important;}.has-medium-font-size{font-size: var(--wp--preset--font-size--medium) !important;}.has-large-font-size{font-size: var(--wp--preset--font-size--large) !important;}.has-x-large-font-size{font-size: var(--wp--preset--font-size--x-large) !important;}
:where(.wp-block-post-template.is-layout-flex){gap: 1.25em;}:where(.wp-block-post-template.is-layout-grid){gap: 1.25em;}
:where(.wp-block-columns.is-layout-flex){gap: 2em;}:where(.wp-block-columns.is-layout-grid){gap: 2em;}
:root :where(.wp-block-pullquote){font-size: 1.5em;line-height: 1.6;}
</style>
<link rel='stylesheet' id='acoplw-style-css' href='https://www.mombasacomputers.com/wp-content/plugins/aco-product-labels-for-woocommerce/includes/../assets/css/frontend.css?ver=1.5.13' type='text/css' media='all' />
<style id='woocommerce-inline-inline-css' type='text/css'>
.woocommerce form .form-row .required { visibility: visible; }
</style>
<link rel='stylesheet' id='js_composer_front-css' href='https://www.mombasacomputers.com/wp-content/plugins/js_composer/assets/css/js_composer.min.css?ver=8.7.2' type='text/css' media='all' />
<link rel='stylesheet' id='wd-style-base-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/base.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-helpers-wpb-elem-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/helpers-wpb-elem.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-revolution-slider-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/int-rev-slider.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-wpbakery-base-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/int-wpb-base.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-wpbakery-base-deprecated-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/int-wpb-base-deprecated.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-int-wordfence-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/int-wordfence.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-notices-fixed-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/woo-opt-sticky-notices-old.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-woocommerce-base-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/woocommerce-base.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-mod-star-rating-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/mod-star-rating.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-woocommerce-block-notices-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/woo-mod-block-notices.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-wp-blocks-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/wp-blocks.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-header-base-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/header-base.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-mod-tools-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/mod-tools.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-header-elements-base-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/header-el-base.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-woo-mod-login-form-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/woo-mod-login-form.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-header-my-account-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/header-el-my-account.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-header-search-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/header-el-search.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-header-cart-side-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/header-el-cart-side.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-header-cart-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/header-el-cart.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-widget-shopping-cart-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/woo-widget-shopping-cart.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-widget-product-list-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/woo-widget-product-list.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-header-mobile-nav-dropdown-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/header-el-mobile-nav-dropdown.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-header-categories-nav-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/header-el-category-nav.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-mod-nav-vertical-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/mod-nav-vertical.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-mod-nav-vertical-design-default-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/mod-nav-vertical-design-default.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-section-title-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/el-section-title.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-mod-highlighted-text-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/mod-highlighted-text.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-button-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/el-button.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-product-loop-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/woo-product-loop.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-product-loop-tiled-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/woo-product-loop-tiled.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-woo-mod-swatches-base-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/woo-mod-swatches-base.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-bordered-product-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/woo-opt-bordered-product.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-swiper-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/lib-swiper.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-woo-opt-grid-gallery-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/woo-opt-grid-gallery.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-mfp-popup-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/lib-magnific-popup.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-swiper-arrows-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/lib-swiper-arrows.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-swiper-pagin-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/lib-swiper-pagin.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-woo-prod-loop-small-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/woo-prod-loop-small.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-banner-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/wpb-el-banner.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-banner-style-mask-and-shadow-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/el-banner-style-mask-and-shadow.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-banner-hover-zoom-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/el-banner-hover-zoom.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-woo-mod-product-labels-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/woo-mod-product-labels.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-woo-mod-product-labels-round-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/woo-mod-product-labels-round.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-product-loop-list-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/woo-product-loop-list.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-woo-mod-add-btn-replace-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/woo-mod-add-btn-replace.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-footer-base-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/footer-base.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-text-block-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/el-text-block.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-list-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/el-list.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-el-list-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/el-list-wpb-elem.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-scroll-top-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/opt-scrolltotop.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-header-search-fullscreen-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/header-el-search-fullscreen-general.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-header-search-fullscreen-1-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/header-el-search-fullscreen-1.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-wd-search-form-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/wd-search-form.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-wd-search-results-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/wd-search-results.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-wd-search-dropdown-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/wd-search-dropdown.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='wd-header-my-account-sidebar-css' href='https://www.mombasacomputers.com/wp-content/themes/woodmart/css/parts/header-el-my-account-sidebar.min.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='xts-style-header_931922-css' href='https://www.mombasacomputers.com/wp-content/uploads/2026/05/xts-header_931922-1779362809.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='xts-style-theme_settings_default-css' href='https://www.mombasacomputers.com/wp-content/uploads/2026/05/xts-theme_settings_default-1778065074.css?ver=8.2.7' type='text/css' media='all' />
<link rel='stylesheet' id='xts-google-fonts-css' href='https://fonts.googleapis.com/css?family=Lato%3A400%2C700&#038;ver=8.2.7' type='text/css' media='all' />
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/plugins/google-analytics-for-wordpress/assets/js/frontend-gtag.min.js?ver=10.1.3" id="monsterinsights-frontend-script-js" async="async" data-wp-strategy="async"></script>
<script data-cfasync="false" data-wpfc-render="false" type="text/javascript" id='monsterinsights-frontend-script-js-extra'>/* <![CDATA[ */
var monsterinsights_frontend = {"js_events_tracking":"true","download_extensions":"doc,pdf,ppt,zip,xls,docx,pptx,xlsx","inbound_paths":"[{\"path\":\"\\\/go\\\/\",\"label\":\"affiliate\"},{\"path\":\"\\\/recommend\\\/\",\"label\":\"affiliate\"}]","home_url":"https:\/\/www.mombasacomputers.com","hash_tracking":"false","v4_id":"G-DDS5WX5KYJ"};/* ]]> */
</script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-includes/js/jquery/jquery.min.js?ver=3.7.1" id="jquery-core-js"></script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-includes/js/jquery/jquery-migrate.min.js?ver=3.4.1" id="jquery-migrate-js"></script>
<script type="text/javascript" id="acoplw-script-js-extra">
/* <![CDATA[ */
var acoplw_frontend_object = {"classname":"","enablejquery":"0"};
/* ]]> */
</script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/plugins/aco-product-labels-for-woocommerce/includes/../assets/js/frontend.js?ver=1.5.13" id="acoplw-script-js"></script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/plugins/woocommerce/assets/js/jquery-blockui/jquery.blockUI.min.js?ver=2.7.0-wc.10.7.0" id="wc-jquery-blockui-js" data-wp-strategy="defer"></script>
<script type="text/javascript" id="wc-add-to-cart-js-extra">
/* <![CDATA[ */
var wc_add_to_cart_params = {"ajax_url":"\/wp-admin\/admin-ajax.php","wc_ajax_url":"\/?wc-ajax=%%endpoint%%","i18n_view_cart":"View cart","cart_url":"https:\/\/www.mombasacomputers.com\/cart\/","is_cart":"","cart_redirect_after_add":"no"};
/* ]]> */
</script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/plugins/woocommerce/assets/js/frontend/add-to-cart.min.js?ver=10.7.0" id="wc-add-to-cart-js" data-wp-strategy="defer"></script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/plugins/woocommerce/assets/js/js-cookie/js.cookie.min.js?ver=2.1.4-wc.10.7.0" id="wc-js-cookie-js" defer="defer" data-wp-strategy="defer"></script>
<script type="text/javascript" id="woocommerce-js-extra">
/* <![CDATA[ */
var woocommerce_params = {"ajax_url":"\/wp-admin\/admin-ajax.php","wc_ajax_url":"\/?wc-ajax=%%endpoint%%","i18n_password_show":"Show password","i18n_password_hide":"Hide password"};
/* ]]> */
</script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/plugins/woocommerce/assets/js/frontend/woocommerce.min.js?ver=10.7.0" id="woocommerce-js" defer="defer" data-wp-strategy="defer"></script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/plugins/js_composer/assets/js/vendors/woocommerce-add-to-cart.js?ver=8.7.2" id="vc_woocommerce-add-to-cart-js-js"></script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/themes/woodmart/js/libs/device.min.js?ver=8.2.7" id="wd-device-library-js"></script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/themes/woodmart/js/scripts/global/scrollBar.min.js?ver=8.2.7" id="wd-scrollbar-js"></script>
<script></script><link rel="https://api.w.org/" href="https://www.mombasacomputers.com/wp-json/" /><link rel="alternate" title="JSON" type="application/json" href="https://www.mombasacomputers.com/wp-json/wp/v2/pages/324" /><link rel="EditURI" type="application/rsd+xml" title="RSD" href="https://www.mombasacomputers.com/xmlrpc.php?rsd" />

<link rel='shortlink' href='https://www.mombasacomputers.com/' />
<link rel="alternate" title="oEmbed (JSON)" type="application/json+oembed" href="https://www.mombasacomputers.com/wp-json/oembed/1.0/embed?url=https%3A%2F%2Fwww.mombasacomputers.com%2F" />
<link rel="alternate" title="oEmbed (XML)" type="text/xml+oembed" href="https://www.mombasacomputers.com/wp-json/oembed/1.0/embed?url=https%3A%2F%2Fwww.mombasacomputers.com%2F&#038;format=xml" />
<!-- Google site verification - Google for WooCommerce -->
<meta name="google-site-verification" content="o4ABMJcdFPLYlB0NH-eL2RjOUViqzmbFYm2XGTR3i1A" />
<meta name="theme-color" content="rgb(56,72,77)">					<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
										<noscript><style>.woocommerce-product-gallery{ opacity: 1 !important; }</style></noscript>
	<style type="text/css">.recentcomments a{display:inline !important;padding:0 !important;margin:0 !important;}</style><meta name="generator" content="Powered by WPBakery Page Builder - drag and drop page builder for WordPress."/>
<style data-type="vc_custom-css">.price .amount {
    font-size: inherit;
    color: #3c3cf4;
    font-weight: 700;
}
.woocommerce-price-suffix {
    color: red;
    font-weight: 700;
    font-size: 15px;
}
.vc_separator.vc_separator_align_left h4 {
    padding: 0 0.8em 0 0;
    font-size: 30px;
}</style><meta name="generator" content="Powered by Slider Revolution 6.7.40 - responsive, Mobile-Friendly Slider Plugin for WordPress with comfortable drag and drop interface." />
<link rel="icon" href="https://www.mombasacomputers.com/wp-content/uploads/2020/08/cropped-fav-1-32x32.png" sizes="32x32" />
<link rel="icon" href="https://www.mombasacomputers.com/wp-content/uploads/2020/08/cropped-fav-1-192x192.png" sizes="192x192" />
<link rel="apple-touch-icon" href="https://www.mombasacomputers.com/wp-content/uploads/2020/08/cropped-fav-1-180x180.png" />
<meta name="msapplication-TileImage" content="https://www.mombasacomputers.com/wp-content/uploads/2020/08/cropped-fav-1-270x270.png" />
<script>function setREVStartSize(e){
			//window.requestAnimationFrame(function() {
				window.RSIW = window.RSIW===undefined ? window.innerWidth : window.RSIW;
				window.RSIH = window.RSIH===undefined ? window.innerHeight : window.RSIH;
				try {
					var pw = document.getElementById(e.c).parentNode.offsetWidth,
						newh;
					pw = pw===0 || isNaN(pw) || (e.l=="fullwidth" || e.layout=="fullwidth") ? window.RSIW : pw;
					e.tabw = e.tabw===undefined ? 0 : parseInt(e.tabw);
					e.thumbw = e.thumbw===undefined ? 0 : parseInt(e.thumbw);
					e.tabh = e.tabh===undefined ? 0 : parseInt(e.tabh);
					e.thumbh = e.thumbh===undefined ? 0 : parseInt(e.thumbh);
					e.tabhide = e.tabhide===undefined ? 0 : parseInt(e.tabhide);
					e.thumbhide = e.thumbhide===undefined ? 0 : parseInt(e.thumbhide);
					e.mh = e.mh===undefined || e.mh=="" || e.mh==="auto" ? 0 : parseInt(e.mh,0);
					if(e.layout==="fullscreen" || e.l==="fullscreen")
						newh = Math.max(e.mh,window.RSIH);
					else{
						e.gw = Array.isArray(e.gw) ? e.gw : [e.gw];
						for (var i in e.rl) if (e.gw[i]===undefined || e.gw[i]===0) e.gw[i] = e.gw[i-1];
						e.gh = e.el===undefined || e.el==="" || (Array.isArray(e.el) && e.el.length==0)? e.gh : e.el;
						e.gh = Array.isArray(e.gh) ? e.gh : [e.gh];
						for (var i in e.rl) if (e.gh[i]===undefined || e.gh[i]===0) e.gh[i] = e.gh[i-1];
											
						var nl = new Array(e.rl.length),
							ix = 0,
							sl;
						e.tabw = e.tabhide>=pw ? 0 : e.tabw;
						e.thumbw = e.thumbhide>=pw ? 0 : e.thumbw;
						e.tabh = e.tabhide>=pw ? 0 : e.tabh;
						e.thumbh = e.thumbhide>=pw ? 0 : e.thumbh;
						for (var i in e.rl) nl[i] = e.rl[i]<window.RSIW ? 0 : e.rl[i];
						sl = nl[0];
						for (var i in nl) if (sl>nl[i] && nl[i]>0) { sl = nl[i]; ix=i;}
						var m = pw>(e.gw[ix]+e.tabw+e.thumbw) ? 1 : (pw-(e.tabw+e.thumbw)) / (e.gw[ix]);
						newh =  (e.gh[ix] * m) + (e.tabh + e.thumbh);
					}
					var el = document.getElementById(e.c);
					if (el!==null && el) el.style.height = newh+"px";
					el = document.getElementById(e.c+"_wrapper");
					if (el!==null && el) {
						el.style.height = newh+"px";
						el.style.display = "block";
					}
				} catch(e){
					console.log("Failure at Presize of Slider:" + e)
				}
			//});
		  };</script>
		<style type="text/css" id="wp-custom-css">
			.woocommerce-price-suffix {
    color: red;
}		</style>
		<style>
		
		</style><style data-type="woodmart_shortcodes-custom-css">.wd-rs-696f99e3122ce > .vc_column-inner > .wpb_wrapper{justify-content: space-between}.wd-rs-69ecb02105692{width: auto !important;max-width: auto !important;}.wd-rs-69f3735a0f2b2{width: auto !important;max-width: auto !important;}.wd-rs-69f373977b8d6 .wd-el-title{color: rgb(221,51,51);}.wd-rs-69fc8932db372 .wd-button-wrapper a{background-color: #0073df;border-color: #0073df;}.wd-rs-69fc8991aae6d{--wd-img-height: 183px;}.wd-rs-69fc8991aae6d .wd-button-wrapper a{background-color: #0073df;border-color: #0073df;}.wd-rs-69fc89e80bed4{--wd-img-height: 183px;}.wd-rs-69fc89e80bed4 .wd-button-wrapper a{background-color: #0073df;border-color: #0073df;}.wd-rs-696f9f385b880 > .vc_column-inner > .wpb_wrapper{justify-content: space-betweenjustify-content: space-between}.wd-rs-69ecb044bc0c2{width: auto !important;max-width: auto !important;}.wd-rs-69f354f6b3116 .wd-el-title{color: #0073df;}.wd-rs-696fa0a0efcf6 > .vc_column-inner > .wpb_wrapper{justify-content: space-between}.wd-rs-69ecb3159a1f2{width: auto !important;max-width: auto !important;}.wd-rs-69ecb2d3f139f{width: auto !important;max-width: auto !important;}.wd-rs-696fa08f50042 > .vc_column-inner > .wpb_wrapper{justify-content: space-between}.wd-rs-69ecb24fa1959{width: auto !important;max-width: auto !important;}.wd-rs-696fa0c071ac4 > .vc_column-inner > .wpb_wrapper{justify-content: space-between}.wd-rs-69f5e2bc18280{width: auto !important;max-width: auto !important;}.wd-rs-696f9cadc684a > .vc_column-inner > .wpb_wrapper{justify-content: space-between}.wd-rs-69ecaf9d0468f{width: auto !important;max-width: auto !important;}#wd-69ecb02105692 .woodmart-title-container{line-height:38px;font-size:28px;color:#dd3333;}#wd-69fc8c09dbc24 a{background-color:#0073df;border-color:#0073df !important;}#wd-69f3735a0f2b2 .woodmart-title-container{line-height:38px;font-size:28px;color:#dd3333;}#wd-69fc8c2792b5e a{background-color:#0073df;border-color:#0073df !important;}#wd-69fc50ee87f61 .woodmart-title-container{color:#dd3333;}#wd-69fc8932db372 .banner-title{color:#ffffff;}#wd-69fc8991aae6d .banner-title{color:#ffffff;}#wd-69fc89e80bed4 .banner-title{color:#ffffff;}#wd-69ecb044bc0c2 .woodmart-title-container{line-height:38px;font-size:28px;color:#dd3333;}#wd-69ecb1bb35627 a{background-color:#0073df;border-color:#0073df !important;}#wd-69ecb3159a1f2 .woodmart-title-container{line-height:38px;font-size:28px;color:#dd3333;}#wd-69ecb32316c61 a{background-color:#0073df;border-color:#0073df !important;}#wd-69ecb2d3f139f .woodmart-title-container{line-height:38px;font-size:28px;color:#dd3333;}#wd-69ecb2df516e1 a{background-color:#0073df;border-color:#0073df !important;}#wd-69ecb24fa1959 .woodmart-title-container{line-height:38px;font-size:28px;color:#dd3333;}#wd-69ecb25f4ac95 a{background-color:#0073df;border-color:#0073df !important;}#wd-69f5e2bc18280 .woodmart-title-container{line-height:38px;font-size:28px;color:#dd3333;}#wd-69f5fa656f653 a{background-color:#0073df;border-color:#0073df !important;}#wd-69ecaf9d0468f .woodmart-title-container{line-height:38px;font-size:28px;color:#dd3333;}#wd-69ecb534f2cb3 a{background-color:#0073df;border-color:#0073df !important;}@media (max-width: 1199px) {html .wd-rs-6970ead36e995{margin-bottom:30px !important;}#wd-69ecb02105692 .woodmart-title-container{line-height:34px;font-size:24px;}#wd-69f3735a0f2b2 .woodmart-title-container{line-height:34px;font-size:24px;}#wd-69ecb044bc0c2 .woodmart-title-container{line-height:34px;font-size:24px;}#wd-69ecb3159a1f2 .woodmart-title-container{line-height:34px;font-size:24px;}#wd-69ecb2d3f139f .woodmart-title-container{line-height:34px;font-size:24px;}#wd-69ecb24fa1959 .woodmart-title-container{line-height:34px;font-size:24px;}#wd-69f5e2bc18280 .woodmart-title-container{line-height:34px;font-size:24px;}#wd-69ecaf9d0468f .woodmart-title-container{line-height:34px;font-size:24px;}}@media (max-width: 767px) {html .wd-rs-6970ead36e995{margin-bottom:10px !important;}#wd-69ecb02105692 .woodmart-title-container{line-height:32px;font-size:22px;}#wd-69f3735a0f2b2 .woodmart-title-container{line-height:32px;font-size:22px;}#wd-69ecb044bc0c2 .woodmart-title-container{line-height:32px;font-size:22px;}#wd-69ecb3159a1f2 .woodmart-title-container{line-height:32px;font-size:22px;}#wd-69ecb2d3f139f .woodmart-title-container{line-height:32px;font-size:22px;}#wd-69ecb24fa1959 .woodmart-title-container{line-height:32px;font-size:22px;}#wd-69f5e2bc18280 .woodmart-title-container{line-height:32px;font-size:22px;}#wd-69ecaf9d0468f .woodmart-title-container{line-height:32px;font-size:22px;}}</style><style type="text/css" data-type="vc_shortcodes-custom-css">.vc_custom_1769007845374{padding-top: 30px !important;}.vc_custom_1777025241121{padding-top: 30px !important;padding-bottom: 30px !important;}.vc_custom_1777119272181{margin-bottom: 20px !important;}.vc_custom_1778158624167{margin-right: 0px !important;margin-bottom: 20px !important;}.vc_custom_1777562470230{margin-bottom: 20px !important;}.vc_custom_1778158655513{margin-right: 0px !important;margin-bottom: 20px !important;}.vc_custom_1777119308012{margin-bottom: 20px !important;}.vc_custom_1777119731156{margin-right: 0px !important;margin-bottom: 20px !important;}.vc_custom_1777120029488{margin-bottom: 20px !important;}.vc_custom_1777120047020{margin-right: 0px !important;margin-bottom: 20px !important;}.vc_custom_1777119962441{margin-bottom: 20px !important;}.vc_custom_1777119982752{margin-right: 0px !important;margin-bottom: 20px !important;}.vc_custom_1777119833065{margin-bottom: 20px !important;}.vc_custom_1777119851005{margin-right: 0px !important;margin-bottom: 20px !important;}.vc_custom_1777722137004{margin-bottom: 20px !important;}.vc_custom_1777728109094{margin-right: 0px !important;margin-bottom: 20px !important;}.vc_custom_1777119158076{margin-bottom: 20px !important;}.vc_custom_1777120596146{margin-right: 0px !important;margin-bottom: 20px !important;}</style><noscript><style> .wpb_animate_when_almost_visible { opacity: 1; }</style></noscript></head>

<body data-rsssl=1 class="home wp-singular page-template-default page page-id-324 wp-theme-woodmart theme-woodmart woocommerce-no-js metaslider-plugin wrapper-custom  categories-accordion-on woodmart-ajax-shop-on notifications-sticky wpb-js-composer js-comp-ver-8.7.2 vc_responsive">
			<script type="text/javascript" id="wd-flicker-fix">// Flicker fix.</script>	
	
	<div class="wd-page-wrapper website-wrapper">
									<header class="whb-header whb-header_931922 whb-sticky-shadow whb-scroll-stick whb-sticky-real">
					<div class="whb-main-header">
	
<div class="whb-row whb-top-bar whb-not-sticky-row whb-with-bg whb-without-border whb-color-light whb-flex-flex-middle">
	<div class="container">
		<div class="whb-flex-row whb-top-bar-inner">
			<div class="whb-column whb-col-left whb-column5 whb-visible-lg whb-empty-column">
	</div>
<div class="whb-column whb-col-center whb-column6 whb-visible-lg">
	
<div class="wd-header-text reset-last-child whb-jibi7kzk7lc04v461thd"><p style="color: #ffffff; font-size: 17px; text-align: center;"><a style="color: #ffffff; text-decoration: none;" href="tel:+254111040400">Call: 0111 040 400</a> |
<a style="color: #ffffff; text-decoration: none;" href="https://wa.me/254792792750" target="_blank" rel="noopener">WhatsApp: 0792 792 750</a> |
<a style="color: #ffffff; text-decoration: none;" href="/cdn-cgi/l/email-protection#3a495b565f497a575557585b495b5955574a4f4e5f484914595557"><span class="__cf_email__" data-cfemail="05766469607645686a6867647664666a687570716077762b666a68">[email&#160;protected]</span></a></p>
&nbsp;</div>
</div>
<div class="whb-column whb-col-right whb-column7 whb-visible-lg whb-empty-column">
	</div>
<div class="whb-column whb-col-mobile whb-column_mobile1 whb-hidden-lg">
	
<div class="wd-header-text reset-last-child whb-p1uxm6s4caplh5njmeuq"><br><p style="color: #ffffff; font-size: 17px; text-align: center;"><a style="color: #ffffff; text-decoration: none;" href="tel:+254111040400">Call: 0111 040 400</a> |
<a style="color: #ffffff; text-decoration: none;" href="https://wa.me/254792792750" target="_blank" rel="noopener">WhatsApp: 0792 792 750</a> |
<a style="color: #ffffff; text-decoration: none;" href="/cdn-cgi/l/email-protection#e192808d8492a18c8e8c83809280828e8c919495849392cf828e8c"><span class="__cf_email__" data-cfemail="7b081a171e083b161416191a081a1814160b0e0f1e090855181416">[email&#160;protected]</span></a></p>
&nbsp;</div>
</div>
		</div>
	</div>
</div>

<div class="whb-row whb-general-header whb-not-sticky-row whb-without-bg whb-without-border whb-color-dark whb-flex-equal-sides">
	<div class="container">
		<div class="whb-flex-row whb-general-header-inner">
			<div class="whb-column whb-col-left whb-column8 whb-visible-lg">
	<div class="site-logo whb-8hp8bv22198xynwcinzb">
	<a href="https://www.mombasacomputers.com/" class="wd-logo wd-main-logo" rel="home" aria-label="Site logo">
		<img width="300" height="107" src="https://www.mombasacomputers.com/wp-content/uploads/2020/08/MCL-Logo-2a.png" class="attachment-full size-full" alt="" style="max-width:300px;" decoding="async" srcset="https://www.mombasacomputers.com/wp-content/uploads/2020/08/MCL-Logo-2a.png 300w, https://www.mombasacomputers.com/wp-content/uploads/2020/08/MCL-Logo-2a-150x54.png 150w, https://www.mombasacomputers.com/wp-content/uploads/2020/08/MCL-Logo-2a-64x23.png 64w" sizes="(max-width: 300px) 100vw, 300px" />	</a>
	</div>
</div>
<div class="whb-column whb-col-center whb-column9 whb-visible-lg whb-empty-column">
	</div>
<div class="whb-column whb-col-right whb-column10 whb-visible-lg">
	<div class="wd-header-my-account wd-tools-element wd-event-hover wd-design-1 wd-account-style-text login-side-opener whb-xvwqavg4ns62dczxwcol">
			<a href="https://www.mombasacomputers.com/my-account/" title="My account">
			
				<span class="wd-tools-icon">
									</span>
				<span class="wd-tools-text">
				Login / Register			</span>

					</a>

			</div>

<div class="whb-space-element whb-wba64l0v8hyfg91686h1 " style="width:10px;"></div>
<div class="wd-header-divider wd-full-height whb-aw5evp5isgiexrwdyupg"></div>

<div class="whb-space-element whb-ta0tj1lmahk2j0e37gas " style="width:10px;"></div>
<div class="wd-header-search wd-tools-element wd-design-1 wd-style-text wd-display-full-screen whb-7lyykd6p8490t7x423md" title="Search">
	<a href="#" rel="nofollow" aria-label="Search">
		
			<span class="wd-tools-icon">
							</span>

			<span class="wd-tools-text">
				Search			</span>

			</a>

	</div>

<div class="wd-header-wishlist wd-tools-element wd-style-icon wd-with-count wd-design-1 whb-48xd1h856vw16dnl3hee" title="My Wishlist">
	<a href="https://www.mombasacomputers.com/wishlist-6/" title="Wishlist products">
		
			<span class="wd-tools-icon">
				
									<span class="wd-tools-count">
						0					</span>
							</span>

			<span class="wd-tools-text">
				Wishlist			</span>

			</a>
</div>

<div class="wd-header-cart wd-tools-element wd-design-1 cart-widget-opener wd-style-text whb-g16pzktw94ucb7tgn7mq">
	<a href="https://www.mombasacomputers.com/cart/" title="Shopping cart">
		
			<span class="wd-tools-icon">
											</span>
			<span class="wd-tools-text">
											<span class="wd-cart-number wd-tools-count">0 <span>items</span></span>
						
									<span class="subtotal-divider">/</span>
										<span class="wd-cart-subtotal"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>0</bdi></span></span>
					</span>

			</a>
	</div>
</div>
<div class="whb-column whb-mobile-left whb-column_mobile2 whb-hidden-lg">
	<div class="wd-tools-element wd-header-mobile-nav wd-style-icon wd-design-1 whb-0wc38rgvjlfjfa4jsz3u">
	<a href="#" rel="nofollow" aria-label="Open mobile menu">
		
		<span class="wd-tools-icon">
					</span>

		<span class="wd-tools-text">Menu</span>

			</a>
</div></div>
<div class="whb-column whb-mobile-center whb-column_mobile3 whb-hidden-lg">
	<div class="site-logo whb-nqbbnj5nhktkts5m11lx">
	<a href="https://www.mombasacomputers.com/" class="wd-logo wd-main-logo" rel="home" aria-label="Site logo">
		<img width="300" height="107" src="https://www.mombasacomputers.com/wp-content/uploads/2020/08/MCL-Logo-2a.png" class="attachment-full size-full" alt="" style="max-width:223px;" decoding="async" srcset="https://www.mombasacomputers.com/wp-content/uploads/2020/08/MCL-Logo-2a.png 300w, https://www.mombasacomputers.com/wp-content/uploads/2020/08/MCL-Logo-2a-150x54.png 150w, https://www.mombasacomputers.com/wp-content/uploads/2020/08/MCL-Logo-2a-64x23.png 64w" sizes="(max-width: 300px) 100vw, 300px" />	</a>
	</div>
</div>
<div class="whb-column whb-mobile-right whb-column_mobile4 whb-hidden-lg">
	
<div class="wd-header-cart wd-tools-element wd-design-5 cart-widget-opener wd-style-icon whb-7xb44y4wxgtogem0nqio">
	<a href="https://www.mombasacomputers.com/cart/" title="Shopping cart">
		
			<span class="wd-tools-icon">
															<span class="wd-cart-number wd-tools-count">0 <span>items</span></span>
									</span>
			<span class="wd-tools-text">
				
										<span class="wd-cart-subtotal"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>0</bdi></span></span>
					</span>

			</a>
	</div>
</div>
		</div>
	</div>
</div>

<div class="whb-row whb-header-bottom whb-not-sticky-row whb-without-bg whb-without-border whb-color-dark whb-hidden-mobile whb-flex-flex-middle">
	<div class="container">
		<div class="whb-flex-row whb-header-bottom-inner">
			<div class="whb-column whb-col-left whb-column11 whb-visible-lg">
	
<div class="wd-header-cats wd-style-1 wd-event-click whb-yv1kwdhjt4srrgf4igvt" role="navigation" aria-label="Header categories navigation">
	<span class="menu-opener color-scheme-light">
					<span class="menu-opener-icon"></span>
		
		<span class="menu-open-label">
			BROWSE CATEGORIES		</span>
	</span>
	<div class="wd-dropdown wd-dropdown-cats">
		<ul id="menu-vertical-menu" class="menu wd-nav wd-nav-vertical wd-design-default"><li id="menu-item-13109" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-13109 item-level-0 menu-simple-dropdown wd-event-hover" ><a href="https://www.mombasacomputers.com/product-category/brand-new-deals/" class="woodmart-nav-link"><span class="nav-link-text">Brand New Deals</span></a></li>
<li id="menu-item-13110" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-13110 item-level-0 menu-simple-dropdown wd-event-hover" ><a href="https://www.mombasacomputers.com/product-category/ex-uk-deals/" class="woodmart-nav-link"><span class="nav-link-text">Ex UK Deals</span></a></li>
<li id="menu-item-13111" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-13111 item-level-0 menu-simple-dropdown wd-event-hover" ><a href="https://www.mombasacomputers.com/product-category/accessories/" class="woodmart-nav-link"><span class="nav-link-text">Accessories</span></a></li>
<li id="menu-item-16078" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-16078 item-level-0 menu-simple-dropdown wd-event-hover" ><a href="https://www.mombasacomputers.com/product-category/printers-scanners/" class="woodmart-nav-link"><span class="nav-link-text">Printers &amp; Scanners</span></a></li>
<li id="menu-item-13112" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-13112 item-level-0 menu-simple-dropdown wd-event-hover" ><a href="https://www.mombasacomputers.com/product-category/networking/" class="woodmart-nav-link"><span class="nav-link-text">Networking</span></a></li>
<li id="menu-item-13113" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-13113 item-level-0 menu-simple-dropdown wd-event-hover" ><a href="https://www.mombasacomputers.com/product-category/softwares/" class="woodmart-nav-link"><span class="nav-link-text">Softwares</span></a></li>
<li id="menu-item-13115" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-13115 item-level-0 menu-simple-dropdown wd-event-hover" ><a href="https://www.mombasacomputers.com/product-category/gaming/" class="woodmart-nav-link"><span class="nav-link-text">Gaming</span></a></li>
<li id="menu-item-13116" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-13116 item-level-0 menu-simple-dropdown wd-event-hover" ><a href="https://www.mombasacomputers.com/product-category/pos-systems/" class="woodmart-nav-link"><span class="nav-link-text">POS Systems</span></a></li>
<li id="menu-item-13114" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-13114 item-level-0 menu-simple-dropdown wd-event-hover" ><a href="https://www.mombasacomputers.com/product-category/apple-products/" class="woodmart-nav-link"><span class="nav-link-text">Apple Products</span></a></li>
<li id="menu-item-13117" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-13117 item-level-0 menu-simple-dropdown wd-event-hover" ><a href="https://www.mombasacomputers.com/product-category/service-repair/" class="woodmart-nav-link"><span class="nav-link-text">Service &amp; Repair</span></a></li>
</ul>	</div>
</div>
</div>
<div class="whb-column whb-col-center whb-column12 whb-visible-lg whb-empty-column">
	</div>
<div class="whb-column whb-col-right whb-column13 whb-visible-lg whb-empty-column">
	</div>
<div class="whb-column whb-col-mobile whb-column_mobile5 whb-hidden-lg whb-empty-column">
	</div>
		</div>
	</div>
</div>
</div>
				</header>
			
								<div class="wd-page-content main-page-wrapper">
		
		
		<main id="main-content" class="wd-content-layout content-layout-wrapper container" role="main">
				

<div class="wd-content-area site-content">
									<article id="post-324" class="entry-content post-324 page type-page status-publish hentry">
					<div class="wpb-content-wrapper"><div class="vc_row wpb_row vc_row-fluid"><div class="wpb_column vc_column_container vc_col-sm-3 vc_hidden-xs wd-rs-69f5a1b73f05c"><div class="vc_column-inner"><div class="wpb_wrapper">
	<div  class="wpb_single_image wpb_content_element vc_align_center">
		
		<figure class="wpb_wrapper vc_figure">
			<a href="https://www.mombasacomputers.com/product/cisco-c3850-nm-4-10g-catalyst-3850-48-port-upoe-networking-switch/" target="_self" class="vc_single_image-wrapper   vc_box_border_grey"><img fetchpriority="high" decoding="async" width="770" height="814" src="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Cisco-2.jpg" class="vc_single_image-img attachment-full" alt="" title="Cisco-2" srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Cisco-2.jpg 770w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Cisco-2-284x300.jpg 284w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Cisco-2-768x812.jpg 768w" sizes="(max-width: 770px) 100vw, 770px" /></a>
		</figure>
	</div>
</div></div></div><div class="wpb_column vc_column_container vc_col-sm-6"><div class="vc_column-inner"><div class="wpb_wrapper"><div class="wpb_revslider_element wpb_content_element">
			<!-- START NEW YEAR REVOLUTION SLIDER 6.7.40 --><p class="rs-p-wp-fix"></p>
			<rs-module-wrap id="rev_slider_16_1_wrapper" data-source="gallery" style="visibility:hidden;background:transparent;padding:0;margin:0px auto;margin-top:0;margin-bottom:0;">
				<rs-module id="rev_slider_16_1" style="" data-version="6.7.40">
					<rs-slides style="overflow: hidden; position: absolute;">
						<rs-slide style="position: absolute;" data-key="rs-147" data-title="slide" data-thumb="//www.mombasacomputers.com/wp-content/uploads/2026/05/HP-PROBOOK-430-G7-1-100x50.png" data-link="//www.mombasacomputers.com/product/hp-probook-430-g7-intel-core-i5-10th-gen-8gb-128gb-notebook-pc/" data-tag="l" data-target="_self" data-seoz="front" data-in="o:0;" data-out="a:false;">
							<img decoding="async" src="//www.mombasacomputers.com/wp-content/plugins/revslider/sr6/assets/assets/dummy.png" alt="" title="HP PROBOOK 430 G7" width="1760" height="894" class="rev-slidebg tp-rs-img rs-lazyload" data-lazyload="//www.mombasacomputers.com/wp-content/uploads/2026/05/HP-PROBOOK-430-G7-1.png" data-no-retina>
<!---->					</rs-slide>
						<rs-slide style="position: absolute;" data-key="rs-139" data-title="Slide" data-thumb="//www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-3410-100x50.jpg" data-link="//www.mombasacomputers.com/product/dell-latitude-3410-notebook-intel-core-i5-10th-gen-8gb-ram-256gb-ssd-14-inch-fhd-display/" data-tag="l" data-target="_self" data-seoz="front" data-anim="ms:2000;" data-in="x:100%;">
							<img decoding="async" src="//www.mombasacomputers.com/wp-content/plugins/revslider/sr6/assets/assets/dummy.png" alt="" title="Dell-3410" width="2000" height="1000" class="rev-slidebg tp-rs-img rs-lazyload" data-lazyload="//www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-3410.jpg" data-no-retina>
<!---->					</rs-slide>
						<rs-slide style="position: absolute;" data-key="rs-134" data-title="Slide" data-thumb="//www.mombasacomputers.com/wp-content/uploads/2026/04/Onescreen-a-100x50.jpg" data-link="//www.mombasacomputers.com/product/onescreen-smart-board-tl6-65-interactive-flat-panel/" data-tag="l" data-target="_self" data-seoz="front" data-anim="ms:2000;" data-in="x:100%;">
							<img decoding="async" src="//www.mombasacomputers.com/wp-content/plugins/revslider/sr6/assets/assets/dummy.png" alt="" title="Onescreen-a" width="2000" height="1000" class="rev-slidebg tp-rs-img rs-lazyload" data-lazyload="//www.mombasacomputers.com/wp-content/uploads/2026/04/Onescreen-a.jpg" data-no-retina>
<!---->					</rs-slide>
						<rs-slide style="position: absolute;" data-key="rs-140" data-title="Slide" data-thumb="//www.mombasacomputers.com/wp-content/uploads/2026/04/Dynabook-1-100x50.jpg" data-link="//www.mombasacomputers.com/product/toshiba-dynabook-portege-x40-j-business-laptop-intel-i7-11th-gen-16gb-ram-256gb-ssd-14-inch-fhd-display/" data-tag="l" data-target="_self" data-seoz="front" data-anim="ms:2000;" data-in="x:100%;" data-out="x:-100%;">
							<img decoding="async" src="//www.mombasacomputers.com/wp-content/plugins/revslider/sr6/assets/assets/dummy.png" alt="" title="Dynabook" width="2000" height="1000" class="rev-slidebg tp-rs-img rs-lazyload" data-lazyload="//www.mombasacomputers.com/wp-content/uploads/2026/04/Dynabook-1.jpg" data-no-retina>
<!---->					</rs-slide>
						<rs-slide style="position: absolute;" data-key="rs-141" data-title="Slide" data-thumb="//www.mombasacomputers.com/wp-content/uploads/2026/04/Surface-Laptop-1-100x50.jpg" data-link="//www.mombasacomputers.com/product/microsoft-surface-laptop-4-intel-core-i7-11th-gen-16gb-ram-256gb-ssd-13-5-inch-pixelsense-touch-display/" data-tag="l" data-target="_self" data-seoz="front" data-anim="ms:900ms;" data-in="o:0;x:100%;">
							<img decoding="async" src="//www.mombasacomputers.com/wp-content/plugins/revslider/sr6/assets/assets/dummy.png" alt="" title="Surface-Laptop-1" width="2000" height="1000" class="rev-slidebg tp-rs-img rs-lazyload" data-lazyload="//www.mombasacomputers.com/wp-content/uploads/2026/04/Surface-Laptop-1.jpg" data-no-retina>
<!---->					</rs-slide>
						<rs-slide style="position: absolute;" data-key="rs-137" data-title="Slide" data-thumb="//www.mombasacomputers.com/wp-content/uploads/2026/03/Lenovo-T8480s-100x50.jpg" data-link="//www.mombasacomputers.com/product/lenovo-thinkpad-t490s-intel-core-i7-8th-gen-32gb-ram-512gb-ssd-14-inch-fhd-touch-display/" data-tag="l" data-target="_self" data-seoz="front" data-anim="ms:2000;" data-in="x:100%;" data-out="x:-100%;">
							<img decoding="async" src="//www.mombasacomputers.com/wp-content/plugins/revslider/sr6/assets/assets/dummy.png" alt="" title="Lenovo-T8480s" width="915" height="465" class="rev-slidebg tp-rs-img rs-lazyload" data-lazyload="//www.mombasacomputers.com/wp-content/uploads/2026/03/Lenovo-T8480s.jpg" data-no-retina>
<!---->					</rs-slide>
						<rs-slide style="position: absolute;" data-key="rs-129" data-title="Slide" data-thumb="//www.mombasacomputers.com/wp-content/uploads/2026/04/zbooks-100x50.jpg" data-link="#" data-tag="l" data-target="_self" data-seoz="front" data-anim="ms:2000;" data-in="x:100%;" data-out="x:-100%;">
							<img decoding="async" src="//www.mombasacomputers.com/wp-content/plugins/revslider/sr6/assets/assets/dummy.png" alt="" title="zbooks" width="2000" height="1000" class="rev-slidebg tp-rs-img rs-lazyload" data-lazyload="//www.mombasacomputers.com/wp-content/uploads/2026/04/zbooks.jpg" data-no-retina>
<!---->					</rs-slide>
					</rs-slides>
				</rs-module>
				<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script>
					setREVStartSize({c: 'rev_slider_16_1',rl:[915,465,778,480],el:[465],gw:[915],gh:[465],type:'standard',justify:'',layout:'fullwidth',mh:"0"});if (window.RS_MODULES!==undefined && window.RS_MODULES.modules!==undefined && window.RS_MODULES.modules["revslider161"]!==undefined) {window.RS_MODULES.modules["revslider161"].once = false;window.revapi16 = undefined;if (window.RS_MODULES.checkMinimal!==undefined) window.RS_MODULES.checkMinimal()}
				</script>
			</rs-module-wrap>
			<!-- END REVOLUTION SLIDER -->
</div></div></div></div><div class="wpb_column vc_column_container vc_col-sm-3 vc_hidden-xs wd-rs-69f5a1c6715cf"><div class="vc_column-inner"><div class="wpb_wrapper">
	<div  class="wpb_single_image wpb_content_element vc_align_center">
		
		<figure class="wpb_wrapper vc_figure">
			<a href="https://www.mombasacomputers.com/product/jbl-charge-essential-2-portable-waterproof-bluetooth-speaker-with-built-in-powerbank-and-up-to-20-hour-battery-life/" target="_self" class="vc_single_image-wrapper   vc_box_border_grey"><img loading="lazy" decoding="async" width="770" height="814" src="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Charge.jpg" class="vc_single_image-img attachment-full" alt="" title="Charge" srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Charge.jpg 770w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Charge-284x300.jpg 284w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Charge-768x812.jpg 768w" sizes="auto, (max-width: 770px) 100vw, 770px" /></a>
		</figure>
	</div>
</div></div></div></div><div class="vc_row wpb_row vc_row-fluid vc_custom_1769007845374 wd-rs-6970ead36e995"><div class="wpb_column vc_column_container vc_col-sm-12 wd-enabled-flex wd-rs-696f99e3122ce"><div class="vc_column-inner"><div class="wpb_wrapper">
		<div id="wd-69ecb02105692" class="title-wrapper wd-wpb wd-set-mb reset-last-child  wd-rs-69ecb02105692 wd-enabled-width wd-title-color-default wd-title-style-default text-left vc_custom_1777119272181 wd-underline-colored">
			
			<div class="liner-continer">
				<h4 class="woodmart-title-container title  wd-font-weight- wd-fontsize-l" >LAPTOPS</h4>
							</div>
			
			
			
		</div>
		
		<div id="wd-69fc8c09dbc24" class=" wd-rs-69fc8c09dbc24 vc_custom_1778158624167 wd-button-wrapper text-center inline-element"><a href="https://www.mombasacomputers.com/product-category/laptops/" title="" style="--btn-color:#fff;--btn-color-hover:#fff;" class="btn btn-style-default btn-shape-round btn-size-default btn-icon-pos-right">More products<span class="wd-btn-icon"><img decoding="async"  src="https://www.mombasacomputers.com/wp-content/uploads/2024/10/Icon.svg" title="Icon" loading="lazy" width="12" height="12"></span></a></div>			
			<div id="carousel-128" class="wd-carousel-container  wd-wpb wd-rs-6a0f06dbda764  wd-products-element wd-products products products-bordered-grid">
				
							
				<div class="wd-carousel-inner">
					<div class=" wd-carousel wd-grid"  data-grid-gallery='{"grid_gallery":"1","grid_gallery_control":"arrows","grid_gallery_enable_arrows":"none"}' data-scroll_per_page="yes" style="--wd-col-lg:8;--wd-col-md:4;--wd-col-sm:2;--wd-gap-lg:20px;--wd-gap-sm:10px;">
						<div class="wd-carousel-wrap">
									<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-63154 status-publish instock product_cat-refurbished-laptops-notebooks has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="1" data-id="63154">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/hp-probook-430-g7-intel-core-i5-10th-gen-8gb-128gb-notebook-pc/" class="product-image-link" aria-label="HP ProBook 430 G7 Intel Core i5 10th Gen 8GB 128GB Notebook PC">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/430-G7-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/430-G7-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/430-G7-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/430-G7-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/430-G7.jpg 679w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/430_G7_1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/430_G7_1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/430_G7_1-150x150.jpg 150w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/430-G7-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/430-G7-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/430-G7-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/430-G7-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/430-G7-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/430-G7-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/430-G7-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/430-G7-1.jpg 1500w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/430_G7-4-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/430_G7-4-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/430_G7-4-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/430_G7-4-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/430_G7-4-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/430_G7-4-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/430_G7-4-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/430_G7-4.jpg 1500w" data-image-id="3"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/430_G7-5-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/430_G7-5-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/430_G7-5-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/430_G7-5-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/430_G7-5-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/430_G7-5-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/430_G7-5-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/430_G7-5.jpg 1500w" data-image-id="4"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2026/05/430-G7-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="" srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/430-G7-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/430-G7-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/430-G7-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/430-G7.jpg 679w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=63154" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_63154" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="63154" data-product_sku="MCL-1149" aria-label="Add to cart: &ldquo;HP ProBook 430 G7 Intel Core i5 10th Gen 8GB 128GB Notebook PC&rdquo;" rel="nofollow" data-success_message="&ldquo;HP ProBook 430 G7 Intel Core i5 10th Gen 8GB 128GB Notebook PC&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_63154" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/hp-probook-430-g7-intel-core-i5-10th-gen-8gb-128gb-notebook-pc/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="63154"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="63154" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/hp-probook-430-g7-intel-core-i5-10th-gen-8gb-128gb-notebook-pc/">HP ProBook 430 G7 Intel Core i5 10th Gen 8GB 128GB Notebook PC</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/laptops/refurbished-laptops-notebooks/" rel="tag">Ex UK Laptops</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-1149			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>29,000</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-62977 status-publish instock product_cat-refurbished-laptops-notebooks has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="2" data-id="62977">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/hp-elitebook-630-g10-notebook-pc-intel-core-i5-13th-gen-16gb-ram-512gb-ssd-13-3-inch-fhd-touch-display/" class="product-image-link" aria-label="HP EliteBook 630 G10 Notebook PC Intel Core i5 13th Gen 16GB RAM 512GB SSD 13.3 Inch FHD TOUCH Display">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-a-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-a-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-a-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-a-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-a-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-a-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-a-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-a-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-a.jpg 2000w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-b-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-b-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-b-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-b-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-b-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-b-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-b-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-b-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-b.jpg 2000w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-c-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-c-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-c-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-c-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-c-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-c.jpg 1000w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-d-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-d-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-d-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-d-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-d-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-d-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-d-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-d-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-d.jpg 2000w" data-image-id="3"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-e-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-e-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-e-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-e-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-e-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-e-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-e-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-e-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-e.jpg 2000w" data-image-id="4"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-f-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-f-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-f-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-f-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-f-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-f-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-f-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-f-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-f.jpg 2000w" data-image-id="5"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-g-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-g-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-g-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-g-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-g-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-g-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-g-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-g-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-g.jpg 2000w" data-image-id="6"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-a-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="HP EliteBook 630 G10 Notebook PC Intel Core i5 13th Gen 16GB RAM 512GB SSD 13.3 Inch FHD TOUCH Display" srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-a-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-a-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-a-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-a-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-a-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-a-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-a-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-630-13.3-inch-G10-Notebook-PC-a.jpg 2000w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=62977" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_62977" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="62977" data-product_sku="MCL-1141" aria-label="Add to cart: &ldquo;HP EliteBook 630 G10 Notebook PC Intel Core i5 13th Gen 16GB RAM 512GB SSD 13.3 Inch FHD TOUCH Display&rdquo;" rel="nofollow" data-success_message="&ldquo;HP EliteBook 630 G10 Notebook PC Intel Core i5 13th Gen 16GB RAM 512GB SSD 13.3 Inch FHD TOUCH Display&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_62977" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/hp-elitebook-630-g10-notebook-pc-intel-core-i5-13th-gen-16gb-ram-512gb-ssd-13-3-inch-fhd-touch-display/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="62977"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="62977" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/hp-elitebook-630-g10-notebook-pc-intel-core-i5-13th-gen-16gb-ram-512gb-ssd-13-3-inch-fhd-touch-display/">HP EliteBook 630 G10 Notebook PC Intel Core i5 13th Gen 16GB RAM 512GB SSD 13.3 Inch FHD TOUCH Display</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/laptops/refurbished-laptops-notebooks/" rel="tag">Ex UK Laptops</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-1141			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>70,000</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-62955 status-publish last instock product_cat-refurbished-laptops-notebooks has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="3" data-id="62955">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/hp-elitebook-x360-1030-g8-notebook-pc-intel-core-i7-11th-gen-16gb-ram-256gb-ssd-13-3-inch-fhd-touch-display/" class="product-image-link" aria-label="HP EliteBook x360 1030 G8 Notebook PC Intel Core i7 11th Gen 16GB RAM 256GB SSD 13.3 Inch FHD TOUCH Display">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-a-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-a-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-a-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-a-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-a-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-a-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-a-1-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-a-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-a-1.jpg 2000w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-b-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-b-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-b-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-b-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-b-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-b-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-b-1-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-b-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-b-1.jpg 2000w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-c-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-c-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-c-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-c-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-c-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-c-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-c-1-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-c-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-c-1.jpg 2000w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-d-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-d-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-d-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-d-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-d-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-d-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-d-1-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-d-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-d-1.jpg 2000w" data-image-id="3"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-e-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-e-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-e-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-e-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-e-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-e-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-e-1-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-e-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-e-1.jpg 2000w" data-image-id="4"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-f-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-f-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-f-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-f-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-f-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-f-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-f-1-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-f-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-f-1.jpg 2000w" data-image-id="5"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-g-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-g-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-g-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-g-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-g-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-g-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-g-1-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-g-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-g-1.jpg 2000w" data-image-id="6"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-h-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-h-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-h-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-h-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-h-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-h-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-h-1-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-h-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-h-1.jpg 2000w" data-image-id="7"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-i-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-i-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-i-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-i-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-i-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-i-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-i-1-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-i-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-i-1.jpg 2000w" data-image-id="8"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-a-1-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="HP EliteBook x360 1030 G8 Notebook PC Intel Core i7 11th Gen 16GB RAM 256GB SSD 13.3 Inch FHD TOUCH Display" srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-a-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-a-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-a-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-a-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-a-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-a-1-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-a-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-a-1.jpg 2000w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=62955" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_62955" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="62955" data-product_sku="MCL-1139" aria-label="Add to cart: &ldquo;HP EliteBook x360 1030 G8 Notebook PC Intel Core i7 11th Gen 16GB RAM 256GB SSD 13.3 Inch FHD TOUCH Display&rdquo;" rel="nofollow" data-success_message="&ldquo;HP EliteBook x360 1030 G8 Notebook PC Intel Core i7 11th Gen 16GB RAM 256GB SSD 13.3 Inch FHD TOUCH Display&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_62955" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/hp-elitebook-x360-1030-g8-notebook-pc-intel-core-i7-11th-gen-16gb-ram-256gb-ssd-13-3-inch-fhd-touch-display/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="62955"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="62955" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/hp-elitebook-x360-1030-g8-notebook-pc-intel-core-i7-11th-gen-16gb-ram-256gb-ssd-13-3-inch-fhd-touch-display/">HP EliteBook x360 1030 G8 Notebook PC Intel Core i7 11th Gen 16GB RAM 256GB SSD 13.3 Inch FHD TOUCH Display</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/laptops/refurbished-laptops-notebooks/" rel="tag">Ex UK Laptops</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-1139			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>57,000</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-62945 status-publish first instock product_cat-refurbished-laptops-notebooks has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="4" data-id="62945">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/hp-elitebook-x360-1030-g8-notebook-pc-intel-core-i5-11th-gen-16gb-ram-512gb-ssd-13-3-inch-fhd-touch-display/" class="product-image-link" aria-label="HP EliteBook x360 1030 G8 Notebook PC Intel Core i5 11th Gen 16GB RAM 512GB SSD 13.3 Inch FHD TOUCH Display">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-a-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-a-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-a-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-a-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-a-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-a-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-a-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-a-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-a.jpg 2000w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-b-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-b-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-b-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-b-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-b-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-b-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-b-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-b-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-b.jpg 2000w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-c-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-c-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-c-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-c-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-c-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-c-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-c-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-c-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-c.jpg 2000w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-d-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-d-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-d-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-d-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-d-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-d-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-d-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-d-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-d.jpg 2000w" data-image-id="3"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-e-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-e-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-e-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-e-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-e-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-e-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-e-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-e-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-e.jpg 2000w" data-image-id="4"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-f-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-f-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-f-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-f-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-f-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-f-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-f-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-f-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-f.jpg 2000w" data-image-id="5"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-g-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-g-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-g-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-g-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-g-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-g-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-g-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-g-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-g.jpg 2000w" data-image-id="6"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-h-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-h-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-h-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-h-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-h-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-h-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-h-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-h-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-h.jpg 2000w" data-image-id="7"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-i-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-i-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-i-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-i-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-i-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-i-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-i-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-i-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-i.jpg 2000w" data-image-id="8"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-a-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="HP EliteBook x360 1030 G8 Notebook PC Intel Core i5 11th Gen 16GB RAM 512GB SSD 13.3 Inch FHD TOUCH Display" srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-a-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-a-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-a-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-a-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-a-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-a-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-a-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-EliteBook-x360-1030-G8-Notebook-PC-a.jpg 2000w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=62945" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_62945" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="62945" data-product_sku="MCL-1138" aria-label="Add to cart: &ldquo;HP EliteBook x360 1030 G8 Notebook PC Intel Core i5 11th Gen 16GB RAM 512GB SSD 13.3 Inch FHD TOUCH Display&rdquo;" rel="nofollow" data-success_message="&ldquo;HP EliteBook x360 1030 G8 Notebook PC Intel Core i5 11th Gen 16GB RAM 512GB SSD 13.3 Inch FHD TOUCH Display&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_62945" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/hp-elitebook-x360-1030-g8-notebook-pc-intel-core-i5-11th-gen-16gb-ram-512gb-ssd-13-3-inch-fhd-touch-display/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="62945"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="62945" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/hp-elitebook-x360-1030-g8-notebook-pc-intel-core-i5-11th-gen-16gb-ram-512gb-ssd-13-3-inch-fhd-touch-display/">HP EliteBook x360 1030 G8 Notebook PC Intel Core i5 11th Gen 16GB RAM 512GB SSD 13.3 Inch FHD TOUCH Display</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/laptops/refurbished-laptops-notebooks/" rel="tag">Ex UK Laptops</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-1138			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>62,000</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-61936 status-publish instock product_cat-refurbished-laptops-notebooks has-post-thumbnail purchasable product-type-simple" data-loop="5" data-id="61936">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/dell-latitude-3410-notebook-intel-core-i5-10th-gen-8gb-ram-256gb-ssd-14-inch-fhd-display/" class="product-image-link" aria-label="Dell Latitude 3410 Notebook Intel Core i5 10th Gen 8GB RAM 256GB SSD 14 Inch FHD Display">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display.jpg 2000w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-2-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-2-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-2-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-2-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-2-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-2-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-2.jpg 2000w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-1-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-1.jpg 2000w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-3-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-3-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-3-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-3-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-3-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-3-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-3-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-3-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-3.jpg 2000w" data-image-id="3"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-4-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-4-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-4-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-4-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-4-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-4-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-4-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-4-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-4.jpg 2000w" data-image-id="4"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-5-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-5-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-5-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-5-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-5-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-5-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-5-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-5-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-5.jpg 2000w" data-image-id="5"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-6-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-6-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-6-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-6-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-6-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-6-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-6-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-6-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-6.jpg 2000w" data-image-id="6"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-7-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-7-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-7-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-7-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-7-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-7-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-7-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-7-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-7.jpg 2000w" data-image-id="7"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="Dell Latitude 3410 Notebook Intel Core i5 10th Gen 8GB RAM 256GB SSD 14 Inch FHD Display" srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Dell-Latitude-3410-Notebook-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-14-Inch-FHD-Display.jpg 2000w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=61936" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_61936" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="61936" data-product_sku="MCL-1052" aria-label="Add to cart: &ldquo;Dell Latitude 3410 Notebook Intel Core i5 10th Gen 8GB RAM 256GB SSD 14 Inch FHD Display&rdquo;" rel="nofollow" data-success_message="&ldquo;Dell Latitude 3410 Notebook Intel Core i5 10th Gen 8GB RAM 256GB SSD 14 Inch FHD Display&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_61936" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/dell-latitude-3410-notebook-intel-core-i5-10th-gen-8gb-ram-256gb-ssd-14-inch-fhd-display/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="61936"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="61936" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/dell-latitude-3410-notebook-intel-core-i5-10th-gen-8gb-ram-256gb-ssd-14-inch-fhd-display/">Dell Latitude 3410 Notebook Intel Core i5 10th Gen 8GB RAM 256GB SSD 14 Inch FHD Display</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/laptops/refurbished-laptops-notebooks/" rel="tag">Ex UK Laptops</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-1052			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>35,000</bdi></span></span>

		
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-61668 status-publish instock product_cat-refurbished-laptops-notebooks has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="6" data-id="61668">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/hp-elitebook-830-g8-notebook-pc-intel-core-i5-11th-gen-16gb-ram-512gb-ssd-13-3-inch-fhd-touch-display/" class="product-image-link" aria-label="HP EliteBook 830 G8 Notebook PC Intel Core i5 11th Gen 16GB RAM 512GB SSD 13.3 Inch FHD TOUCH Display">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC.jpg 2000w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-2-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-2-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-2-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-2-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-2-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-2-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-2.jpg 2000w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-1-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-1.jpg 2000w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-3-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-3-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-3-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-3-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-3-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-3-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-3-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-3-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-3.jpg 2000w" data-image-id="3"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-4-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-4-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-4-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-4-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-4-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-4-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-4-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-4-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-4.jpg 2000w" data-image-id="4"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-5-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-5-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-5-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-5-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-5-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-5-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-5-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-5-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-5.jpg 2000w" data-image-id="5"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-6-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-6-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-6-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-6-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-6-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-6-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-6-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-6-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-6.jpg 2000w" data-image-id="6"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="HP EliteBook 830 G8 Notebook PC Intel Core i5 11th Gen 16GB RAM 512GB SSD 13.3 Inch FHD TOUCH Display" srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/HP-EliteBook-830-G8-Notebook-PC.jpg 2000w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=61668" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_61668" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="61668" data-product_sku="MCL-1042" aria-label="Add to cart: &ldquo;HP EliteBook 830 G8 Notebook PC Intel Core i5 11th Gen 16GB RAM 512GB SSD 13.3 Inch FHD TOUCH Display&rdquo;" rel="nofollow" data-success_message="&ldquo;HP EliteBook 830 G8 Notebook PC Intel Core i5 11th Gen 16GB RAM 512GB SSD 13.3 Inch FHD TOUCH Display&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_61668" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/hp-elitebook-830-g8-notebook-pc-intel-core-i5-11th-gen-16gb-ram-512gb-ssd-13-3-inch-fhd-touch-display/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="61668"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="61668" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/hp-elitebook-830-g8-notebook-pc-intel-core-i5-11th-gen-16gb-ram-512gb-ssd-13-3-inch-fhd-touch-display/">HP EliteBook 830 G8 Notebook PC Intel Core i5 11th Gen 16GB RAM 512GB SSD 13.3 Inch FHD TOUCH Display</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/laptops/refurbished-laptops-notebooks/" rel="tag">Ex UK Laptops</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-1042			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>52,000</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-28012 status-publish last instock product_cat-ex-uk-graphics-laptops has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="7" data-id="28012">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/hp-elitebook-745-g6-amd-ryzen-7-pro-3700u-8gb-ram-256gb-ssd-2gb-amd-radeon-graphics-14-inch-fhd-display/" class="product-image-link" aria-label="HP EliteBook 745 G6 AMD Ryzen 7  PRO 3700U 8GB RAM 256GB SSD + 2GB AMD Radeon Graphics 14 Inch FHD Display">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-600x600.jpeg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-600x600.jpeg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-300x300.jpeg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-1024x1024.jpeg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-150x150.jpeg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-768x768.jpeg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6.jpeg 1200w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-1-600x600.jpeg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-1-600x600.jpeg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-1-300x300.jpeg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-1-1024x1024.jpeg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-1-150x150.jpeg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-1-768x768.jpeg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-1.jpeg 1200w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-2-600x600.jpeg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-2-600x600.jpeg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-2-300x300.jpeg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-2-1024x1024.jpeg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-2-150x150.jpeg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-2-768x768.jpeg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-2.jpeg 1200w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-3-600x600.jpeg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-3-600x600.jpeg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-3-300x300.jpeg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-3-1024x1024.jpeg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-3-150x150.jpeg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-3-768x768.jpeg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-3.jpeg 1200w" data-image-id="3"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-4-600x600.jpeg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-4-600x600.jpeg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-4-300x300.jpeg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-4-1024x1024.jpeg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-4-150x150.jpeg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-4-768x768.jpeg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-4.jpeg 1200w" data-image-id="4"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-5-600x600.jpeg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-5-600x600.jpeg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-5-300x300.jpeg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-5-1024x1024.jpeg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-5-150x150.jpeg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-5-768x768.jpeg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-5.jpeg 1200w" data-image-id="5"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-600x600.jpeg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="HP EliteBook 745 G6 AMD Ryzen 7 PRO 3700U 8GB RAM 256GB SSD + 2GB AMD Radeon Graphics 14 Inch FHD Display" srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-600x600.jpeg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-300x300.jpeg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-1024x1024.jpeg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-150x150.jpeg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6-768x768.jpeg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/05/HP-EliteBook-745-G6.jpeg 1200w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=28012" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_28012" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="28012" data-product_sku="MCL-480" aria-label="Add to cart: &ldquo;HP EliteBook 745 G6 AMD Ryzen 7  PRO 3700U 8GB RAM 256GB SSD + 2GB AMD Radeon Graphics 14 Inch FHD Display&rdquo;" rel="nofollow" data-success_message="&ldquo;HP EliteBook 745 G6 AMD Ryzen 7  PRO 3700U 8GB RAM 256GB SSD + 2GB AMD Radeon Graphics 14 Inch FHD Display&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_28012" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/hp-elitebook-745-g6-amd-ryzen-7-pro-3700u-8gb-ram-256gb-ssd-2gb-amd-radeon-graphics-14-inch-fhd-display/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="28012"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="28012" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/hp-elitebook-745-g6-amd-ryzen-7-pro-3700u-8gb-ram-256gb-ssd-2gb-amd-radeon-graphics-14-inch-fhd-display/">HP EliteBook 745 G6 AMD Ryzen 7  PRO 3700U 8GB RAM 256GB SSD + 2GB AMD Radeon Graphics 14 Inch FHD Display</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/graphics-laptops/ex-uk-graphics-laptops/" rel="tag">Ex Uk Graphics Laptops</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-480			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>33,000</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-27525 status-publish first instock product_cat-refurbished-laptops-notebooks has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="8" data-id="27525">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/hp-elitebook-850-g8-notebook-pc-intel-core-i5-11th-gen-16gb-ram-512gb-ssd-15-6-inch-fhd-touch-display/" class="product-image-link" aria-label="HP EliteBook 850 G8 Notebook PC Intel Core i5 11th Gen 16GB RAM 512GB SSD 15.6 Inch FHD TOUCH Display">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display--600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display--600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display--300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display--1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display--150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display--768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-.jpg 1200w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-1.jpg 1200w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-2-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-2-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-2-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-2-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-2.jpg 1200w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-3-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-3-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-3-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-3-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-3-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-3-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-3.jpg 1200w" data-image-id="3"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-4-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-4-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-4-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-4-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-4-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-4-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-4.jpg 1200w" data-image-id="4"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-5-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-5-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-5-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-5-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-5-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-5-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-5.jpg 1200w" data-image-id="5"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-6-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-6-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-6-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-6-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-6-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-6-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-6.jpg 1200w" data-image-id="6"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display--600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="HP EliteBook 850 G8 Notebook PC Intel Core i5 11th Gen 16GB RAM 512GB SSD 15.6 Inch FHD TOUCH Display" srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display--600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display--300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display--1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display--150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display--768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/HP-EliteBook-850-G8-Intel-Core-i5-11th-Gen-16GB-RAM-256GB-SSD-15.6-Inches-FHD-Display-.jpg 1200w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=27525" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_27525" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="27525" data-product_sku="MCL-458" aria-label="Add to cart: &ldquo;HP EliteBook 850 G8 Notebook PC Intel Core i5 11th Gen 16GB RAM 512GB SSD 15.6 Inch FHD TOUCH Display&rdquo;" rel="nofollow" data-success_message="&ldquo;HP EliteBook 850 G8 Notebook PC Intel Core i5 11th Gen 16GB RAM 512GB SSD 15.6 Inch FHD TOUCH Display&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_27525" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/hp-elitebook-850-g8-notebook-pc-intel-core-i5-11th-gen-16gb-ram-512gb-ssd-15-6-inch-fhd-touch-display/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="27525"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="27525" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/hp-elitebook-850-g8-notebook-pc-intel-core-i5-11th-gen-16gb-ram-512gb-ssd-15-6-inch-fhd-touch-display/">HP EliteBook 850 G8 Notebook PC Intel Core i5 11th Gen 16GB RAM 512GB SSD 15.6 Inch FHD TOUCH Display</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/laptops/refurbished-laptops-notebooks/" rel="tag">Ex UK Laptops</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-458			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>52,000</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		
				
			</div>
</div>
</div>
					</div>
								</div>
					</div>

							<div class="wd-nav-arrows wd-pos-sep wd-hover-1 wd-icon-1">
			<div class="wd-btn-arrow wd-prev wd-disabled">
				<div class="wd-arrow-inner"></div>
			</div>
			<div class="wd-btn-arrow wd-next">
				<div class="wd-arrow-inner"></div>
			</div>
		</div>
						</div>

									<div class="wd-nav-pagin-wrap text-center wd-style-shape wd-hide-md-sm wd-hide-sm">
			<ul class="wd-nav-pagin"></ul>
		</div>
									</div>
						</div></div></div></div><div class="vc_row wpb_row vc_row-fluid"><div class="wpb_column vc_column_container vc_col-sm-8"><div class="vc_column-inner"><div class="wpb_wrapper">
		<div id="wd-69f3735a0f2b2" class="title-wrapper wd-wpb wd-set-mb reset-last-child  wd-rs-69f3735a0f2b2 wd-enabled-width wd-title-color-default wd-title-style-default text-left vc_custom_1777562470230 wd-underline-colored">
			
			<div class="liner-continer">
				<h4 class="woodmart-title-container title  wd-font-weight- wd-fontsize-l" >TOP DESKTOP PICKS</h4>
							</div>
			
			
			
		</div>
		
		<div id="wd-69fc8c2792b5e" class=" wd-rs-69fc8c2792b5e vc_custom_1778158655513 wd-button-wrapper text-center inline-element"><a href="https://www.mombasacomputers.com/product-category/computers/desktops/" title="" style="--btn-color:#fff;--btn-color-hover:#fff;" class="btn btn-style-default btn-shape-round btn-size-default btn-icon-pos-right">More products<span class="wd-btn-icon"><img decoding="async"  src="https://www.mombasacomputers.com/wp-content/uploads/2024/10/Icon.svg" title="Icon" loading="lazy" width="12" height="12"></span></a></div>			
			<div id="carousel-256" class="wd-carousel-container  wd-wpb wd-rs-69f1def29f715  wd-products-element wd-products products products-bordered-grid">
				
							
				<div class="wd-carousel-inner">
					<div class=" wd-carousel wd-grid"  data-grid-gallery='{"grid_gallery":"1","grid_gallery_control":"arrows","grid_gallery_enable_arrows":"none"}' data-scroll_per_page="yes" style="--wd-col-lg:3;--wd-col-md:3;--wd-col-sm:2;--wd-gap-lg:20px;--wd-gap-sm:10px;">
						<div class="wd-carousel-wrap">
									<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-62642 status-publish instock product_cat-small-form-factor has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="1" data-id="62642">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/hp-elitedesk-705-g5-small-form-factor-amd-ryzen-5-pro-3400g-8gb-ram-256gb-ssd-4gb-gddr5-amd-radeon-rx-550x-graphics-desktop-pc/" class="product-image-link" aria-label="HP EliteDesk 705 G5 Small Form Factor AMD Ryzen 5 PRO 3400G 8GB RAM 256GB SSD 4GB GDDR5 AMD Radeon RX 550X Graphics Desktop PC">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-705-G5-Small-Form-Factor-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-705-G5-Small-Form-Factor-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-705-G5-Small-Form-Factor-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-705-G5-Small-Form-Factor-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-705-G5-Small-Form-Factor-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-705-G5-Small-Form-Factor-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-705-G5-Small-Form-Factor.jpg 1200w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-705-G5-Small-Form-Factor-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-705-G5-Small-Form-Factor-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-705-G5-Small-Form-Factor-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-705-G5-Small-Form-Factor-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-705-G5-Small-Form-Factor-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-705-G5-Small-Form-Factor-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-705-G5-Small-Form-Factor-1.jpg 1200w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-705-G5-Small-Form-Factor-2-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-705-G5-Small-Form-Factor-2-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-705-G5-Small-Form-Factor-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-705-G5-Small-Form-Factor-2-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-705-G5-Small-Form-Factor-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-705-G5-Small-Form-Factor-2-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-705-G5-Small-Form-Factor-2.jpg 1200w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-705-G5-Small-Form-Factor-3-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-705-G5-Small-Form-Factor-3-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-705-G5-Small-Form-Factor-3-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-705-G5-Small-Form-Factor-3-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-705-G5-Small-Form-Factor-3-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-705-G5-Small-Form-Factor-3-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-705-G5-Small-Form-Factor-3.jpg 1200w" data-image-id="3"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-705-G5-Small-Form-Factor-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="HP EliteDesk 705 G5 Small Form Factor AMD Ryzen 5 PRO 3400G 8GB RAM 256GB SSD 4GB GDDR5 AMD Radeon RX 550X Graphics Desktop PC" srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-705-G5-Small-Form-Factor-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-705-G5-Small-Form-Factor-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-705-G5-Small-Form-Factor-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-705-G5-Small-Form-Factor-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-705-G5-Small-Form-Factor-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-705-G5-Small-Form-Factor.jpg 1200w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=62642" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_62642" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="62642" data-product_sku="MCL-1107" aria-label="Add to cart: &ldquo;HP EliteDesk 705 G5 Small Form Factor AMD Ryzen 5 PRO 3400G 8GB RAM 256GB SSD 4GB GDDR5 AMD Radeon RX 550X Graphics Desktop PC&rdquo;" rel="nofollow" data-success_message="&ldquo;HP EliteDesk 705 G5 Small Form Factor AMD Ryzen 5 PRO 3400G 8GB RAM 256GB SSD 4GB GDDR5 AMD Radeon RX 550X Graphics Desktop PC&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_62642" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/hp-elitedesk-705-g5-small-form-factor-amd-ryzen-5-pro-3400g-8gb-ram-256gb-ssd-4gb-gddr5-amd-radeon-rx-550x-graphics-desktop-pc/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="62642"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="62642" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/hp-elitedesk-705-g5-small-form-factor-amd-ryzen-5-pro-3400g-8gb-ram-256gb-ssd-4gb-gddr5-amd-radeon-rx-550x-graphics-desktop-pc/">HP EliteDesk 705 G5 Small Form Factor AMD Ryzen 5 PRO 3400G 8GB RAM 256GB SSD 4GB GDDR5 AMD Radeon RX 550X Graphics Desktop PC</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/desktops/small-form-factor/" rel="tag">Small Form Factor</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-1107			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>22,000</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-60398 status-publish instock product_cat-towers-desktops has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="2" data-id="60398">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/dell-precision-tower-5810-workstation-intel-xeon-e5-1607-v3-16gb-ram-1tb-hdd-2gb-nvidia-quadro-k620-graphics/" class="product-image-link" aria-label="Dell Precision Tower 5810 Workstation Intel Xeon E5 1607 V3 16GB RAM 1TB HDD 2GB Nvidia Quadro K620 Graphics">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-64x64.jpg 64w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation.jpg 2000w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-2-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-2-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-2-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-2-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-2-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-2-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-2-64x64.jpg 64w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-2.jpg 2000w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-3-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-3-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-3-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-3-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-3-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-3-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-3-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-3-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-3-64x64.jpg 64w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-3.jpg 2000w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-1-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-1-64x64.jpg 64w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-1.jpg 2000w" data-image-id="3"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="Dell Precision Tower 5810 Workstation Intel Xeon E5 1607 V3 16GB RAM 1TB HDD 2GB Nvidia Quadro K620 Graphics" srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation-64x64.jpg 64w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Dell-Precision-Tower-5810-Workstation.jpg 2000w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=60398" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_60398" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="60398" data-product_sku="MCL-916" aria-label="Add to cart: &ldquo;Dell Precision Tower 5810 Workstation Intel Xeon E5 1607 V3 16GB RAM 1TB HDD 2GB Nvidia Quadro K620 Graphics&rdquo;" rel="nofollow" data-success_message="&ldquo;Dell Precision Tower 5810 Workstation Intel Xeon E5 1607 V3 16GB RAM 1TB HDD 2GB Nvidia Quadro K620 Graphics&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_60398" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/dell-precision-tower-5810-workstation-intel-xeon-e5-1607-v3-16gb-ram-1tb-hdd-2gb-nvidia-quadro-k620-graphics/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="60398"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="60398" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/dell-precision-tower-5810-workstation-intel-xeon-e5-1607-v3-16gb-ram-1tb-hdd-2gb-nvidia-quadro-k620-graphics/">Dell Precision Tower 5810 Workstation Intel Xeon E5 1607 V3 16GB RAM 1TB HDD 2GB Nvidia Quadro K620 Graphics</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/desktops/towers-desktops/" rel="tag">Towers</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-916			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>62,000</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-32983 status-publish last instock product_cat-workstations has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="3" data-id="32983">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/hp-z6-g4-workstation-intel-xeon-gold-6132-16gb-ram-512gb-ssd-2tb-hdd-2gb-gddr5-nvidia-geforce-gtx-1050-graphics/" class="product-image-link" aria-label="HP Z6 G4 Workstation Intel Xeon Gold 6132 16GB RAM 512GB SSD + 2TB HDD + 5GB GDDR5 NVIDIA GeForce GTX 1050 Graphics">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2024/09/HP-Z6-G4-Workstation-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2024/09/HP-Z6-G4-Workstation-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2024/09/HP-Z6-G4-Workstation-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2024/09/HP-Z6-G4-Workstation-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2024/09/HP-Z6-G4-Workstation-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2024/09/HP-Z6-G4-Workstation-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2024/09/HP-Z6-G4-Workstation-1.jpg 1200w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2024/09/HP-Z6-G4-Workstation-2-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2024/09/HP-Z6-G4-Workstation-2-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2024/09/HP-Z6-G4-Workstation-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2024/09/HP-Z6-G4-Workstation-2-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2024/09/HP-Z6-G4-Workstation-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2024/09/HP-Z6-G4-Workstation-2-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2024/09/HP-Z6-G4-Workstation-2.jpg 1200w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2024/09/HP-Z6-G4-Workstation-3-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2024/09/HP-Z6-G4-Workstation-3-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2024/09/HP-Z6-G4-Workstation-3-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2024/09/HP-Z6-G4-Workstation-3-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2024/09/HP-Z6-G4-Workstation-3-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2024/09/HP-Z6-G4-Workstation-3-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2024/09/HP-Z6-G4-Workstation-3.jpg 1200w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2024/09/HP-Z6-G4-Workstation-4-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2024/09/HP-Z6-G4-Workstation-4-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2024/09/HP-Z6-G4-Workstation-4-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2024/09/HP-Z6-G4-Workstation-4-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2024/09/HP-Z6-G4-Workstation-4-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2024/09/HP-Z6-G4-Workstation-4-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2024/09/HP-Z6-G4-Workstation-4.jpg 1200w" data-image-id="3"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2024/09/HP-Z6-G4-Workstation-1-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="HP Z6 G4 Workstation Intel Xeon Gold 6132 16GB RAM 512GB SSD + 2TB HDD + 5GB GDDR5 NVIDIA GeForce GTX 1050 Graphics" srcset="https://www.mombasacomputers.com/wp-content/uploads/2024/09/HP-Z6-G4-Workstation-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2024/09/HP-Z6-G4-Workstation-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2024/09/HP-Z6-G4-Workstation-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2024/09/HP-Z6-G4-Workstation-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2024/09/HP-Z6-G4-Workstation-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2024/09/HP-Z6-G4-Workstation-1.jpg 1200w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=32983" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_32983" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="32983" data-product_sku="MCL-705" aria-label="Add to cart: &ldquo;HP Z6 G4 Workstation Intel Xeon Gold 6132 16GB RAM 512GB SSD + 2TB HDD + 5GB GDDR5 NVIDIA GeForce GTX 1050 Graphics&rdquo;" rel="nofollow" data-success_message="&ldquo;HP Z6 G4 Workstation Intel Xeon Gold 6132 16GB RAM 512GB SSD + 2TB HDD + 5GB GDDR5 NVIDIA GeForce GTX 1050 Graphics&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_32983" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/hp-z6-g4-workstation-intel-xeon-gold-6132-16gb-ram-512gb-ssd-2tb-hdd-2gb-gddr5-nvidia-geforce-gtx-1050-graphics/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="32983"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="32983" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/hp-z6-g4-workstation-intel-xeon-gold-6132-16gb-ram-512gb-ssd-2tb-hdd-2gb-gddr5-nvidia-geforce-gtx-1050-graphics/">HP Z6 G4 Workstation Intel Xeon Gold 6132 16GB RAM 512GB SSD + 2TB HDD + 5GB GDDR5 NVIDIA GeForce GTX 1050 Graphics</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/desktops/workstations/" rel="tag">Workstations</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-705			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>155,000</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		
				
			</div>
</div>
</div>
					</div>
								</div>
					</div>

							<div class="wd-nav-arrows wd-pos-sep wd-hover-1 wd-icon-1">
			<div class="wd-btn-arrow wd-prev wd-disabled">
				<div class="wd-arrow-inner"></div>
			</div>
			<div class="wd-btn-arrow wd-next">
				<div class="wd-arrow-inner"></div>
			</div>
		</div>
						</div>

									<div class="wd-nav-pagin-wrap text-center wd-style-shape wd-hide-md-sm wd-hide-sm">
			<ul class="wd-nav-pagin"></ul>
		</div>
									</div>
						</div></div></div><div class="wpb_column vc_column_container vc_col-sm-4 wd-rs-69f355daddf24"><div class="vc_column-inner"><div class="wpb_wrapper">			<div id="" class="wd-products-element wd-rs-69f373977b8d6 wd-wpb with-title">
			<h4 class="wd-el-title title element-title">BEST OF MINI DESKTOPS</h4>
		
					<div class="products wd-products  grid-columns-1 elements-grid wd-grid-g products-bordered-grid-ins" data-paged="1" data-atts="{&quot;post_type&quot;:&quot;ids&quot;,&quot;element_title&quot;:&quot;BEST OF MINI DESKTOPS&quot;,&quot;include&quot;:&quot;62311, 62626, 62635&quot;,&quot;product_hover&quot;:&quot;small&quot;,&quot;columns&quot;:&quot;1&quot;,&quot;highlighted_products&quot;:&quot;0&quot;,&quot;products_divider&quot;:&quot;0&quot;,&quot;products_bordered_grid&quot;:&quot;1&quot;,&quot;products_bordered_grid_style&quot;:&quot;inside&quot;,&quot;products_with_background&quot;:&quot;0&quot;,&quot;products_shadow&quot;:&quot;0&quot;,&quot;img_size&quot;:&quot;150x150&quot;,&quot;woodmart_css_id&quot;:&quot;69f373977b8d6&quot;,&quot;force_not_ajax&quot;:&quot;no&quot;}" data-source="shortcode" data-columns="1" data-grid-gallery="{&quot;grid_gallery&quot;:&quot;1&quot;,&quot;grid_gallery_control&quot;:&quot;arrows&quot;,&quot;grid_gallery_enable_arrows&quot;:&quot;none&quot;}" style="--wd-col-lg:1;--wd-col-md:1;--wd-col-sm:1;--wd-gap-lg:20px;--wd-gap-sm:10px;">
			<div class="wd-product wd-hover-small wd-col product-grid-item product type-product post-62635 status-publish instock product_cat-mini-pcs has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="1" data-id="62635">
				
	


<div class="product-wrapper">
	<div class="product-element-top">
		<a href="https://www.mombasacomputers.com/product/hp-elitedesk-800-g6-mini-pc-intel-core-i5-10th-gen-8gb-ram-256gb-ssd-desktop/" class="product-image-link" aria-label="HP EliteDesk 800 G6 Mini PC Intel Core i5 10th Gen 8GB RAM 256GB SSD Desktop">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-150x150.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC.jpg 2000w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-1-150x150.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-1-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-1.jpg 2000w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-2-150x150.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-2-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-2-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-2-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-2-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-2-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-2.jpg 2000w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-3-150x150.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-3-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-3-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-3-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-3-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-3-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-3-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-3-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-3.jpg 2000w" data-image-id="3"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="150" height="150" src="https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-150x150.jpg" class="attachment-150x150 size-150x150" alt="HP EliteDesk 800 G6 Mini PC Intel Core i5 10th Gen 8GB RAM 256GB SSD Desktop" srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-EliteDesk-800-G6-Desktop-Mini-PC.jpg 2000w" sizes="auto, (max-width: 150px) 100vw, 150px" />		</a>
	</div>

	<div class="product-element-bottom">
	<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/hp-elitedesk-800-g6-mini-pc-intel-core-i5-10th-gen-8gb-ram-256gb-ssd-desktop/">HP EliteDesk 800 G6 Mini PC Intel Core i5 10th Gen 8GB RAM 256GB SSD Desktop</a></h3>					<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
				
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>45,000</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>
	</div>
</div>

</div>
<div class="wd-product wd-hover-small wd-col product-grid-item product type-product post-62626 status-publish instock product_cat-mini-pcs has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="2" data-id="62626">
				
	


<div class="product-wrapper">
	<div class="product-element-top">
		<a href="https://www.mombasacomputers.com/product/hp-pro-mini-400-g9-intel-core-i5-12th-gen-8gb-ram-256gb-ssd-desktop-pc/" class="product-image-link" aria-label="HP Pro Mini 400 G9 Intel Core i5 12th Gen 8GB RAM 256GB SSD Desktop PC">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-150x150.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC.jpg 2000w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-1-150x150.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-1-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-1.jpg 2000w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-2-150x150.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-2-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-2-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-2-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-2-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-2-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-2.jpg 2000w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-3-150x150.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-3-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-3-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-3-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-3-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-3-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-3-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-3-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-3.jpg 2000w" data-image-id="3"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="150" height="150" src="https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-150x150.jpg" class="attachment-150x150 size-150x150" alt="HP Pro Mini 400 G9 Intel Core i5 12th Gen 8GB RAM 256GB SSD Desktop PC" srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/HP-Pro-Mini-400-G9-Desktop-PC.jpg 2000w" sizes="auto, (max-width: 150px) 100vw, 150px" />		</a>
	</div>

	<div class="product-element-bottom">
	<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/hp-pro-mini-400-g9-intel-core-i5-12th-gen-8gb-ram-256gb-ssd-desktop-pc/">HP Pro Mini 400 G9 Intel Core i5 12th Gen 8GB RAM 256GB SSD Desktop PC</a></h3>					<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
				
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>55,000</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>
	</div>
</div>

</div>
<div class="wd-product wd-hover-small wd-col product-grid-item product type-product post-62311 status-publish last instock product_cat-mini-pcs has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="3" data-id="62311">
				
	


<div class="product-wrapper">
	<div class="product-element-top">
		<a href="https://www.mombasacomputers.com/product/hp-prodesk-400-g6-mini-pc-intel-core-i5-10th-gen-8gb-ram-256gb-ssd-desktop-computer/" class="product-image-link" aria-label="HP ProDesk 400 G6 Mini PC Intel Core i5 10th Gen 8GB RAM 256GB SSD Desktop Computer">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-150x150.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC.jpg 2000w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-1-150x150.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-1-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-1.jpg 2000w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-2-150x150.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-2-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-2-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-2-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-2-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-2-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-2.jpg 2000w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-3-150x150.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-3-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-3-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-3-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-3-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-3-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-3-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-3-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-3.jpg 2000w" data-image-id="3"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="150" height="150" src="https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-150x150.jpg" class="attachment-150x150 size-150x150" alt="HP ProDesk 400 G6 Mini PC Intel Core i5 10th Gen 8GB RAM 256GB SSD Desktop Computer" srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/HP-ProDesk-400-G6-Desktop-Mini-PC.jpg 2000w" sizes="auto, (max-width: 150px) 100vw, 150px" />		</a>
	</div>

	<div class="product-element-bottom">
	<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/hp-prodesk-400-g6-mini-pc-intel-core-i5-10th-gen-8gb-ram-256gb-ssd-desktop-computer/">HP ProDesk 400 G6 Mini PC Intel Core i5 10th Gen 8GB RAM 256GB SSD Desktop Computer</a></h3>					<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
				
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>45,000</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>
	</div>
</div>

</div>
			</div>
			</div></div></div></div></div><div class="vc_row wpb_row vc_row-fluid"><div class="wpb_column vc_column_container vc_col-sm-12"><div class="vc_column-inner"><div class="wpb_wrapper"><div class="vc_empty_space"   style="height: 32px"><span class="vc_empty_space_inner"></span></div></div></div></div></div><div class="vc_row wpb_row vc_row-fluid"><div class="wpb_column vc_column_container vc_col-sm-12"><div class="vc_column-inner"><div class="wpb_wrapper"><div class="vc_separator wpb_content_element vc_separator_align_center vc_sep_width_100 vc_sep_pos_align_center vc_separator_no_text vc_sep_color_grey" ><span class="vc_sep_holder vc_sep_holder_l"><span class="vc_sep_line"></span></span><span class="vc_sep_holder vc_sep_holder_r"><span class="vc_sep_line"></span></span>
</div></div></div></div></div><div class="vc_row wpb_row vc_row-fluid"><div class="wpb_column vc_column_container vc_col-sm-2"><div class="vc_column-inner"><div class="wpb_wrapper"></div></div></div><div class="wpb_column vc_column_container vc_col-sm-8"><div class="vc_column-inner"><div class="wpb_wrapper">
		<div id="wd-69fc50ee87f61" class="title-wrapper wd-wpb wd-set-mb reset-last-child  wd-rs-69fc50ee87f61 wd-title-color-default wd-title-style-default text-center  wd-underline-colored">
			
			<div class="liner-continer">
				<h3 class="woodmart-title-container title  wd-font-weight-700 wd-fontsize-xxl" >Interactive Whiteboards &amp; Smart Boards in Kenya</h3>
							</div>
			
			
			
		</div>
		
		
	<div class="wpb_text_column wpb_content_element" >
		<div class="wpb_wrapper">
			<p style="text-align: center;" data-start="0" data-end="376">Transform the way you teach, collaborate, and present with advanced Interactive Smart Boards in Kenya. Designed for modern classrooms, boardrooms, training centers, and conference spaces, smart interactive displays combine powerful touch technology, ultra-clear 4K visuals, wireless connectivity, and intelligent collaboration tools into one seamless solution.</p>

		</div>
	</div>
</div></div></div><div class="wpb_column vc_column_container vc_col-sm-2"><div class="vc_column-inner"><div class="wpb_wrapper"></div></div></div></div><div class="vc_row wpb_row vc_row-fluid vc_custom_1777025241121 wd-rs-69eb40c35dfe8"><div class="wpb_column vc_column_container vc_col-sm-6"><div class="vc_column-inner"><div class="wpb_wrapper">
			<!-- START Slider 1 REVOLUTION SLIDER 6.7.40 --><p class="rs-p-wp-fix"></p>
			<rs-module-wrap id="rev_slider_18_2_wrapper" data-source="gallery" style="visibility:hidden;background:transparent;padding:0;margin:0px auto;margin-top:0;margin-bottom:0;">
				<rs-module id="rev_slider_18_2" style="" data-version="6.7.40">
					<rs-slides style="overflow: hidden; position: absolute;">
						<rs-slide style="position: absolute;" data-key="rs-144" data-title="Slide" data-in="o:0;" data-out="a:false;">
							<img decoding="async" src="//www.mombasacomputers.com/wp-content/plugins/revslider/sr6/assets/assets/dummy.png" alt="" title="Onescreen-Slider" width="1536" height="1024" class="rev-slidebg tp-rs-img rs-lazyload" data-lazyload="//www.mombasacomputers.com/wp-content/uploads/2026/05/Onescreen-Slider.jpg" data-no-retina>
<!---->					</rs-slide>
						<rs-slide style="position: absolute;" data-key="rs-145" data-title="Slide" data-in="o:0;" data-out="a:false;">
							<img decoding="async" src="//www.mombasacomputers.com/wp-content/plugins/revslider/sr6/assets/assets/dummy.png" alt="OneScreen Smart Board TL6-65 Interactive Flat Panel" title="OneScreen Smart Board TL6-65 Interactive Flat Panel" width="1536" height="1024" class="rev-slidebg tp-rs-img rs-lazyload" data-lazyload="//www.mombasacomputers.com/wp-content/uploads/2026/05/ChatGPT-Image-May-7-2026-11_15_14-AM.png" data-no-retina>
<!---->					</rs-slide>
					</rs-slides>
				</rs-module>
				<script>
					setREVStartSize({c: 'rev_slider_18_2',rl:[915,465,778,480],el:[533],gw:[800],gh:[533],type:'standard',justify:'',layout:'fullwidth',mh:"0"});if (window.RS_MODULES!==undefined && window.RS_MODULES.modules!==undefined && window.RS_MODULES.modules["revslider182"]!==undefined) {window.RS_MODULES.modules["revslider182"].once = false;window.revapi18 = undefined;if (window.RS_MODULES.checkMinimal!==undefined) window.RS_MODULES.checkMinimal()}
				</script>
			</rs-module-wrap>
			<!-- END REVOLUTION SLIDER -->
</div></div></div><div class="wpb_column vc_column_container vc_col-sm-6"><div class="vc_column-inner"><div class="wpb_wrapper"><div class="vc_empty_space"   style="height: 22px"><span class="vc_empty_space_inner"></span></div>
	<div class="wpb_text_column wpb_content_element" >
		<div class="wpb_wrapper">
			<h2><em><strong>Touchscreens that work the way you do, </strong></em><em><strong>in classrooms and conference rooms.</strong></em></h2>
<p>The <em><a href="https://www.interactivedisplay.me/onescreen-smart-board-tl6-65/" target="_blank" rel="noopener"><strong>Onescreen Smart Board Interactive Flat Panel</strong></a></em> is a cutting-edge digital display designed to transform the way we teach, learn, and collaborate. Known for its intuitive touch functionality, vibrant display, and seamless connectivity, <strong>it’s the perfect tool for enhancing interaction in classrooms, boardrooms, and training facilities.</strong></p>
<p>From schools embracing digital learning to corporate teams enhancing productivity, Interactive Whiteboards offer a smarter, more connected experience built for today’s hybrid environments. Explore a wide range of Smart Boards in Kenya from leading global brands, available in multiple screen sizes and tailored for every workspace and learning environment.</p>

		</div>
	</div>
<div class="vc_row wpb_row vc_inner vc_row-fluid vc_column-gap-3 vc_row-o-equal-height vc_row-flex wd-rs-69fc35f44cf5a"><div class="wpb_column vc_column_container vc_col-sm-4"><div class="vc_column-inner"><div class="wpb_wrapper">		<div class="promo-banner-wrapper  wd-rs-69fc8932db372 ">
			<div id="wd-69fc8932db372" class="promo-banner  banner-mask banner-hover-zoom color-scheme-light banner-btn-size-default banner-btn-style-default  with-btn banner-btn-position-static wd-with-link wd-underline-colored">
				<div class="main-wrapp-img">
					<div class="banner-image wd-bg-position-center" >
						<img loading="lazy" decoding="async" width="800" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2026/05/WhatsApp-Image-2026-05-07-at-09.24.28-4-800x600.jpeg" class="attachment-800x600 size-800x600" alt="" />					</div>
				</div>

				<div class="wrapper-content-banner wd-fill  wd-items-middle wd-justify-center">
					<div class="content-banner  text-center">
						<h2 class="banner-title wd-font-weight-600 wd-fontsize-xl">FREE DEMO</h2>						
						
						<div class="banner-btn-wrapper"><div id="wd-6a0f6b21c442c" class="  wd-button-wrapper text-center"><a href="https://www.mombasacomputers.com/onscreen-demo-booking/" title="" style="--btn-color:#fff;--btn-color-hover:#fff;" class="btn btn-style-default btn-shape-rectangle btn-size-default btn-icon-pos-right">BOOK NOW<span class="wd-btn-icon"><span class="wd-icon fa fa-solid fa-headset"></span></span></a></div></div>					</div>
				</div>

									<a class="wd-promo-banner-link wd-fill" aria-label="Banner link" href="https://www.mombasacomputers.com/onscreen-demo-booking/" title=""></a>
				
							</div>
		</div>

		</div></div></div><div class="wpb_column vc_column_container vc_col-sm-4"><div class="vc_column-inner"><div class="wpb_wrapper">		<div class="promo-banner-wrapper  wd-rs-69fc8991aae6d ">
			<div id="wd-69fc8991aae6d" class="promo-banner  banner-mask banner-hover-zoom color-scheme-light banner-btn-size-default banner-btn-style-default  with-btn banner-btn-position-static wd-with-link wd-underline-colored">
				<div class="main-wrapp-img">
					<div class="banner-image wd-bg-position-center" >
						<img loading="lazy" decoding="async" width="800" height="450" src="https://www.mombasacomputers.com/wp-content/uploads/2026/05/WhatsApp-Image-2026-05-07-at-11.33.58-1.jpeg" class="attachment-800x600 size-800x600" alt="" />					</div>
				</div>

				<div class="wrapper-content-banner wd-fill  wd-items-middle wd-justify-center">
					<div class="content-banner  text-center">
						<h2 class="banner-title wd-font-weight-600 wd-fontsize-xl">INTERACTION</h2>						
						
						<div class="banner-btn-wrapper"><div id="wd-6a0f6b21c4ad7" class="  wd-button-wrapper text-center"><a href="https://www.mombasacomputers.com/product/onescreen-smart-board-tl6-65-interactive-flat-panel/" title="" style="--btn-color:#fff;--btn-color-hover:#fff;" class="btn btn-style-default btn-shape-rectangle btn-size-default btn-icon-pos-right">CHECK IT OUT<span class="wd-btn-icon"><span class="wd-icon fa fa-solid fa-headset"></span></span></a></div></div>					</div>
				</div>

									<a class="wd-promo-banner-link wd-fill" aria-label="Banner link" href="https://www.mombasacomputers.com/product/onescreen-smart-board-tl6-65-interactive-flat-panel/" title=""></a>
				
							</div>
		</div>

		</div></div></div><div class="wpb_column vc_column_container vc_col-sm-4"><div class="vc_column-inner"><div class="wpb_wrapper">		<div class="promo-banner-wrapper  wd-rs-69fc89e80bed4 ">
			<div id="wd-69fc89e80bed4" class="promo-banner  banner-mask banner-hover-zoom color-scheme-light banner-btn-size-default banner-btn-style-default  with-btn banner-btn-position-static wd-with-link wd-underline-colored">
				<div class="main-wrapp-img">
					<div class="banner-image wd-bg-position-center" >
						<video src="https://www.mombasacomputers.com/wp-content/uploads/2026/05/WhatsApp-Video-2026-05-07-at-10.03.37.mp4 " autoplay muted loop playsinline></video>					</div>
				</div>

				<div class="wrapper-content-banner wd-fill  wd-items-middle wd-justify-center">
					<div class="content-banner  text-center">
						<h2 class="banner-title wd-font-weight-600 wd-fontsize-xl">DELIVERY</h2>						
						
						<div class="banner-btn-wrapper"><div id="wd-6a0f6b21c4f6b" class="  wd-button-wrapper text-center"><a href="https://www.mombasacomputers.com/smart-board-delivery/" title="" style="--btn-color:#fff;--btn-color-hover:#fff;" class="btn btn-style-default btn-shape-rectangle btn-size-default btn-icon-pos-right">ORDER NOW<span class="wd-btn-icon"><span class="wd-icon fa fa-solid fa-headset"></span></span></a></div></div>					</div>
				</div>

									<a class="wd-promo-banner-link wd-fill" aria-label="Banner link" href="https://www.mombasacomputers.com/smart-board-delivery/" title=""></a>
				
							</div>
		</div>

		</div></div></div></div></div></div></div></div><div class="vc_row wpb_row vc_row-fluid"><div class="wpb_column vc_column_container vc_col-sm-12"><div class="vc_column-inner"><div class="wpb_wrapper"><div class="vc_empty_space"   style="height: 32px"><span class="vc_empty_space_inner"></span></div><div class="vc_separator wpb_content_element vc_separator_align_center vc_sep_width_100 vc_sep_pos_align_center vc_separator_no_text vc_sep_color_grey" ><span class="vc_sep_holder vc_sep_holder_l"><span class="vc_sep_line"></span></span><span class="vc_sep_holder vc_sep_holder_r"><span class="vc_sep_line"></span></span>
</div></div></div></div></div><div class="vc_row wpb_row vc_row-fluid wd-rs-6970ebaf2de40"><div class="wpb_column vc_column_container vc_col-sm-8 wd-enabled-flex wd-rs-696f9f385b880"><div class="vc_column-inner"><div class="wpb_wrapper">
		<div id="wd-69ecb044bc0c2" class="title-wrapper wd-wpb wd-set-mb reset-last-child  wd-rs-69ecb044bc0c2 wd-enabled-width wd-title-color-default wd-title-style-default text-left vc_custom_1777119308012 wd-underline-colored">
			
			<div class="liner-continer">
				<h4 class="woodmart-title-container title  wd-font-weight- wd-fontsize-l" >MICROSOFT DEALS</h4>
							</div>
			
			
			
		</div>
		
		<div id="wd-69ecb1bb35627" class=" wd-rs-69ecb1bb35627 vc_custom_1777119731156 wd-button-wrapper text-center inline-element"><a href="https://www.mombasacomputers.com/product-category/laptops/microsoft-surface/" title="" style="--btn-color:#fff;--btn-color-hover:#fff;" class="btn btn-style-default btn-shape-round btn-size-default btn-icon-pos-right">More products<span class="wd-btn-icon"><img decoding="async"  src="https://www.mombasacomputers.com/wp-content/uploads/2024/10/Icon.svg" title="Icon" loading="lazy" width="12" height="12"></span></a></div>			
			<div id="carousel-353" class="wd-carousel-container  wd-wpb wd-rs-69f2281322ce5  wd-products-element wd-products products products-bordered-grid">
				
							
				<div class="wd-carousel-inner">
					<div class=" wd-carousel wd-grid"  data-grid-gallery='{"grid_gallery":"1","grid_gallery_control":"arrows","grid_gallery_enable_arrows":"none"}' data-scroll_per_page="yes" style="--wd-col-lg:4;--wd-col-md:4;--wd-col-sm:2;--wd-gap-lg:20px;--wd-gap-sm:10px;">
						<div class="wd-carousel-wrap">
									<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-62542 status-publish instock product_cat-microsoft-surface-laptops has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="1" data-id="62542">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/microsoft-surface-laptop-1-intel-core-i5-7th-gen-8gb-ram-256gb-ssd-13-5-inch-pixelsense-touch-display/" class="product-image-link" aria-label="Microsoft Surface Laptop 1 Intel Core i5 7th Gen 8GB RAM 256GB SSD 13.5 Inch PixelSense Touch Display">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1.jpg 2000w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-1-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-1.jpg 2000w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-2-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-2-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-2-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-2-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-2-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-2-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-2.jpg 2000w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-3-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-3-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-3-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-3-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-3-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-3-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-3-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-3-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-3.jpg 2000w" data-image-id="3"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-4-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-4-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-4-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-4-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-4-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-4-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-4-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-4-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-4.jpg 2000w" data-image-id="4"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="Microsoft Surface Laptop 1 Intel Core i5 7th Gen 8GB RAM 256GB SSD 13.5 Inch PixelSense Touch Display" srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Microsoft-Surface-Laptop-1.jpg 2000w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=62542" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_62542" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="62542" data-product_sku="MCL-1098" aria-label="Add to cart: &ldquo;Microsoft Surface Laptop 1 Intel Core i5 7th Gen 8GB RAM 256GB SSD 13.5 Inch PixelSense Touch Display&rdquo;" rel="nofollow" data-success_message="&ldquo;Microsoft Surface Laptop 1 Intel Core i5 7th Gen 8GB RAM 256GB SSD 13.5 Inch PixelSense Touch Display&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_62542" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/microsoft-surface-laptop-1-intel-core-i5-7th-gen-8gb-ram-256gb-ssd-13-5-inch-pixelsense-touch-display/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="62542"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="62542" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/microsoft-surface-laptop-1-intel-core-i5-7th-gen-8gb-ram-256gb-ssd-13-5-inch-pixelsense-touch-display/">Microsoft Surface Laptop 1 Intel Core i5 7th Gen 8GB RAM 256GB SSD 13.5 Inch PixelSense Touch Display</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/laptops/microsoft-surface/microsoft-surface-laptops/" rel="tag">Microsoft Surface Laptops</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-1098			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>30,500</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-with-labels wd-hover-tiled product-grid-item product type-product post-62153 status-publish instock product_cat-microsoft-surface-laptops has-post-thumbnail sale taxable shipping-taxable purchasable product-type-simple" data-loop="2" data-id="62153">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/microsoft-surface-laptop-4-intel-core-i7-11th-gen-16gb-ram-256gb-ssd-13-5-inch-pixelsense-touch-display/" class="product-image-link" aria-label="Microsoft Surface Laptop 4 Intel Core i7 11th Gen 16GB RAM 256GB SSD 13.5 Inch PixelSense Touch Display">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7.jpg 2000w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-1-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-1.jpg 2000w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-2-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-2-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-2-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-2-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-2-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-2-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-2.jpg 2000w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-3-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-3-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-3-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-3-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-3-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-3-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-3-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-3-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-3.jpg 2000w" data-image-id="3"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-4-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-4-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-4-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-4-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-4-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-4-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-4-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-4-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-4.jpg 2000w" data-image-id="4"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<div class="product-labels labels-rounded"><span class="onsale product-label">-21%</span></div><img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="Microsoft Surface Laptop 4 Intel Core i7 11th Gen 16GB RAM 256GB SSD 13.5 Inch PixelSense Touch Display" srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-4-Intel-Core-i7.jpg 2000w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=62153" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_62153" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="62153" data-product_sku="MCL-439" aria-label="Add to cart: &ldquo;Microsoft Surface Laptop 4 Intel Core i7 11th Gen 16GB RAM 256GB SSD 13.5 Inch PixelSense Touch Display&rdquo;" rel="nofollow" data-success_message="&ldquo;Microsoft Surface Laptop 4 Intel Core i7 11th Gen 16GB RAM 256GB SSD 13.5 Inch PixelSense Touch Display&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_62153" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/microsoft-surface-laptop-4-intel-core-i7-11th-gen-16gb-ram-256gb-ssd-13-5-inch-pixelsense-touch-display/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="62153"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="62153" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/microsoft-surface-laptop-4-intel-core-i7-11th-gen-16gb-ram-256gb-ssd-13-5-inch-pixelsense-touch-display/">Microsoft Surface Laptop 4 Intel Core i7 11th Gen 16GB RAM 256GB SSD 13.5 Inch PixelSense Touch Display</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/laptops/microsoft-surface/microsoft-surface-laptops/" rel="tag">Microsoft Surface Laptops</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-439			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><del aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>65,999</bdi></span></del> <span class="screen-reader-text">Original price was: KSh65,999.</span><ins aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>52,000</bdi></span></ins><span class="screen-reader-text">Current price is: KSh52,000.</span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-62138 status-publish last instock product_cat-microsoft-surface-laptops has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="3" data-id="62138">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/microsoft-surface-laptop-2-intel-core-i7-8th-gen-8gb-ram-256gb-ssd-13-5-inch-pixelsense-touch-display/" class="product-image-link" aria-label="Microsoft Surface Laptop 2 Intel Core i7 8th Gen 8GB RAM 256GB SSD 13.5 Inch PixelSense Touch Display">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7.jpg 2000w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-1-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-1.jpg 2000w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-3-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-3-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-3-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-3-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-3-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-3-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-3-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-3-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-3.jpg 2000w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-2-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-2-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-2-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-2-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-2-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-2-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-2.jpg 2000w" data-image-id="3"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-4-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-4-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-4-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-4-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-4-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-4-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-4-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-4-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-4.jpg 2000w" data-image-id="4"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="Microsoft Surface Laptop 2 Intel Core i7 8th Gen 8GB RAM 256GB SSD 13.5 Inch PixelSense Touch Display" srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/02/Microsoft-Surface-Laptop-2-Intel-Core-i7.jpg 2000w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=62138" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_62138" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="62138" data-product_sku="MCL-1029" aria-label="Add to cart: &ldquo;Microsoft Surface Laptop 2 Intel Core i7 8th Gen 8GB RAM 256GB SSD 13.5 Inch PixelSense Touch Display&rdquo;" rel="nofollow" data-success_message="&ldquo;Microsoft Surface Laptop 2 Intel Core i7 8th Gen 8GB RAM 256GB SSD 13.5 Inch PixelSense Touch Display&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_62138" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/microsoft-surface-laptop-2-intel-core-i7-8th-gen-8gb-ram-256gb-ssd-13-5-inch-pixelsense-touch-display/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="62138"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="62138" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/microsoft-surface-laptop-2-intel-core-i7-8th-gen-8gb-ram-256gb-ssd-13-5-inch-pixelsense-touch-display/">Microsoft Surface Laptop 2 Intel Core i7 8th Gen 8GB RAM 256GB SSD 13.5 Inch PixelSense Touch Display</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/laptops/microsoft-surface/microsoft-surface-laptops/" rel="tag">Microsoft Surface Laptops</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-1029			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>35,500</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-61947 status-publish first instock product_cat-microsoft-surface-laptops has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="4" data-id="61947">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/microsoft-surface-laptop-3-intel-core-i5-10th-gen-8gb-ram-256gb-ssd-13-5-inch-fhd-touchscreen-display/" class="product-image-link" aria-label="Microsoft Surface Laptop 3 Intel Core i5 10th Gen 8GB RAM 256GB SSD 13.5 Inch FHD Touchscreen Display">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/01/Microsoft-Surface-Laptop-3-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-13.5-Inch-FHD-Touchscreen-Display-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/01/Microsoft-Surface-Laptop-3-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-13.5-Inch-FHD-Touchscreen-Display-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Microsoft-Surface-Laptop-3-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-13.5-Inch-FHD-Touchscreen-Display-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Microsoft-Surface-Laptop-3-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-13.5-Inch-FHD-Touchscreen-Display-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Microsoft-Surface-Laptop-3-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-13.5-Inch-FHD-Touchscreen-Display-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Microsoft-Surface-Laptop-3-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-13.5-Inch-FHD-Touchscreen-Display-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Microsoft-Surface-Laptop-3-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-13.5-Inch-FHD-Touchscreen-Display.jpg 1200w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/01/Microsoft-Surface-Laptop-3-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-13.5-Inch-FHD-Touchscreen-Display-1-600x600.jpeg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/01/Microsoft-Surface-Laptop-3-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-13.5-Inch-FHD-Touchscreen-Display-1-600x600.jpeg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Microsoft-Surface-Laptop-3-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-13.5-Inch-FHD-Touchscreen-Display-1-300x300.jpeg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Microsoft-Surface-Laptop-3-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-13.5-Inch-FHD-Touchscreen-Display-1-150x150.jpeg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Microsoft-Surface-Laptop-3-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-13.5-Inch-FHD-Touchscreen-Display-1-768x768.jpeg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Microsoft-Surface-Laptop-3-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-13.5-Inch-FHD-Touchscreen-Display-1.jpeg 1000w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/01/Microsoft-Surface-Laptop-3-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-13.5-Inch-FHD-Touchscreen-Display-2-600x600.jpeg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/01/Microsoft-Surface-Laptop-3-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-13.5-Inch-FHD-Touchscreen-Display-2-600x600.jpeg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Microsoft-Surface-Laptop-3-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-13.5-Inch-FHD-Touchscreen-Display-2-300x300.jpeg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Microsoft-Surface-Laptop-3-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-13.5-Inch-FHD-Touchscreen-Display-2-150x150.jpeg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Microsoft-Surface-Laptop-3-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-13.5-Inch-FHD-Touchscreen-Display-2-768x768.jpeg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Microsoft-Surface-Laptop-3-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-13.5-Inch-FHD-Touchscreen-Display-2.jpeg 1000w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/01/Microsoft-Surface-Laptop-3-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-13.5-Inch-FHD-Touchscreen-Display-3-600x600.jpeg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/01/Microsoft-Surface-Laptop-3-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-13.5-Inch-FHD-Touchscreen-Display-3-600x600.jpeg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Microsoft-Surface-Laptop-3-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-13.5-Inch-FHD-Touchscreen-Display-3-300x300.jpeg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Microsoft-Surface-Laptop-3-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-13.5-Inch-FHD-Touchscreen-Display-3-150x150.jpeg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Microsoft-Surface-Laptop-3-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-13.5-Inch-FHD-Touchscreen-Display-3-768x768.jpeg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Microsoft-Surface-Laptop-3-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-13.5-Inch-FHD-Touchscreen-Display-3.jpeg 1000w" data-image-id="3"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/01/Microsoft-Surface-Laptop-3-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-13.5-Inch-FHD-Touchscreen-Display-4-600x600.jpeg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/01/Microsoft-Surface-Laptop-3-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-13.5-Inch-FHD-Touchscreen-Display-4-600x600.jpeg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Microsoft-Surface-Laptop-3-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-13.5-Inch-FHD-Touchscreen-Display-4-300x300.jpeg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Microsoft-Surface-Laptop-3-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-13.5-Inch-FHD-Touchscreen-Display-4-150x150.jpeg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Microsoft-Surface-Laptop-3-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-13.5-Inch-FHD-Touchscreen-Display-4-768x768.jpeg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Microsoft-Surface-Laptop-3-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-13.5-Inch-FHD-Touchscreen-Display-4.jpeg 1000w" data-image-id="4"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2026/01/Microsoft-Surface-Laptop-3-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-13.5-Inch-FHD-Touchscreen-Display-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="Microsoft Surface Laptop 3 Intel Core i5 10th Gen 8GB RAM 256GB SSD 13.5 Inch FHD Touchscreen Display" srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/01/Microsoft-Surface-Laptop-3-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-13.5-Inch-FHD-Touchscreen-Display-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Microsoft-Surface-Laptop-3-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-13.5-Inch-FHD-Touchscreen-Display-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Microsoft-Surface-Laptop-3-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-13.5-Inch-FHD-Touchscreen-Display-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Microsoft-Surface-Laptop-3-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-13.5-Inch-FHD-Touchscreen-Display-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Microsoft-Surface-Laptop-3-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-13.5-Inch-FHD-Touchscreen-Display-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/01/Microsoft-Surface-Laptop-3-Intel-Core-i5-10th-Gen-8GB-RAM-256GB-SSD-13.5-Inch-FHD-Touchscreen-Display.jpg 1200w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=61947" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_61947" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="61947" data-product_sku="MCL-1053" aria-label="Add to cart: &ldquo;Microsoft Surface Laptop 3 Intel Core i5 10th Gen 8GB RAM 256GB SSD 13.5 Inch FHD Touchscreen Display&rdquo;" rel="nofollow" data-success_message="&ldquo;Microsoft Surface Laptop 3 Intel Core i5 10th Gen 8GB RAM 256GB SSD 13.5 Inch FHD Touchscreen Display&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_61947" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/microsoft-surface-laptop-3-intel-core-i5-10th-gen-8gb-ram-256gb-ssd-13-5-inch-fhd-touchscreen-display/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="61947"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="61947" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/microsoft-surface-laptop-3-intel-core-i5-10th-gen-8gb-ram-256gb-ssd-13-5-inch-fhd-touchscreen-display/">Microsoft Surface Laptop 3 Intel Core i5 10th Gen 8GB RAM 256GB SSD 13.5 Inch FHD Touchscreen Display</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/laptops/microsoft-surface/microsoft-surface-laptops/" rel="tag">Microsoft Surface Laptops</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-1053			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>40,500</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		
				
			</div>
</div>
</div>
					</div>
								</div>
					</div>

							<div class="wd-nav-arrows wd-pos-sep wd-hover-1 wd-icon-1">
			<div class="wd-btn-arrow wd-prev wd-disabled">
				<div class="wd-arrow-inner"></div>
			</div>
			<div class="wd-btn-arrow wd-next">
				<div class="wd-arrow-inner"></div>
			</div>
		</div>
						</div>

									<div class="wd-nav-pagin-wrap text-center wd-style-shape wd-hide-md-sm wd-hide-sm">
			<ul class="wd-nav-pagin"></ul>
		</div>
									</div>
						</div></div></div><div class="wpb_column vc_column_container vc_col-sm-4"><div class="vc_column-inner"><div class="wpb_wrapper">			<div id="" class="wd-products-element wd-rs-69f354f6b3116 wd-wpb with-title wd-hide">
			<h4 class="wd-el-title title element-title">Power Beyond Limits.</h4>
		
					</div>
			</div></div></div></div><div class="vc_row wpb_row vc_row-fluid wd-rs-6970ebd48f1d8"><div class="wpb_column vc_column_container vc_col-sm-12 wd-enabled-flex wd-rs-696fa0a0efcf6"><div class="vc_column-inner"><div class="wpb_wrapper">
		<div id="wd-69ecb3159a1f2" class="title-wrapper wd-wpb wd-set-mb reset-last-child  wd-rs-69ecb3159a1f2 wd-enabled-width wd-title-color-default wd-title-style-default text-left vc_custom_1777120029488 wd-underline-colored">
			
			<div class="liner-continer">
				<h4 class="woodmart-title-container title  wd-font-weight- wd-fontsize-l" >APPLE LAPTOPS</h4>
							</div>
			
			
			
		</div>
		
		<div id="wd-69ecb32316c61" class=" wd-rs-69ecb32316c61 vc_custom_1777120047020 wd-button-wrapper text-center inline-element"><a href="https://www.mombasacomputers.com/product-category/apple-products/apple-laptops/" title="" style="--btn-color:#fff;--btn-color-hover:#fff;" class="btn btn-style-default btn-shape-round btn-size-default btn-icon-pos-right">More products<span class="wd-btn-icon"><img decoding="async"  src="https://www.mombasacomputers.com/wp-content/uploads/2024/10/Icon.svg" title="Icon" loading="lazy" width="12" height="12"></span></a></div>			
			<div id="carousel-602" class="wd-carousel-container  wd-wpb wd-rs-69ecb33568399  wd-products-element wd-products products products-bordered-grid">
				
							
				<div class="wd-carousel-inner">
					<div class=" wd-carousel wd-grid"  data-grid-gallery='{"grid_gallery":"1","grid_gallery_control":"arrows","grid_gallery_enable_arrows":"none"}' data-scroll_per_page="yes" style="--wd-col-lg:8;--wd-col-md:4;--wd-col-sm:2;--wd-gap-lg:20px;--wd-gap-sm:10px;">
						<div class="wd-carousel-wrap">
									<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-62531 status-publish instock product_cat-macbook-pro has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="1" data-id="62531">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/apple-macbook-pro-mrw23ll-a-m3-chip-12-core-cpu-38-core-gpu-36gb-ram-512gb-ssd-16-2-inch-3456-x-2234-liquid-retina-xdr-display/" class="product-image-link" aria-label="Apple MacBook Pro MRW23LL/A M3 Chip 12 Core CPU – 38 Core GPU 36GB RAM 512GB SSD 16.2 inch (3456 × 2234) Liquid Retina XDR Display">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA.jpg 2000w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-1-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-1.jpg 2000w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-3-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-3-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-3-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-3-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-3-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-3-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-3-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-3-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-3.jpg 2000w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-2-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-2-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-2-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-2-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-2-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-2-2048x2048.jpg 2048w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-2-1200x1200.jpg 1200w" data-image-id="3"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="Apple MacBook Pro MRW23LL/A M3 Chip 12 Core CPU – 38 Core GPU 36GB RAM 512GB SSD 16.2 inch (3456 × 2234) Liquid Retina XDR Display" srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MRW23LLA.jpg 2000w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=62531" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_62531" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="62531" data-product_sku="MCL-1096" aria-label="Add to cart: &ldquo;Apple MacBook Pro MRW23LL/A M3 Chip 12 Core CPU – 38 Core GPU 36GB RAM 512GB SSD 16.2 inch (3456 × 2234) Liquid Retina XDR Display&rdquo;" rel="nofollow" data-success_message="&ldquo;Apple MacBook Pro MRW23LL/A M3 Chip 12 Core CPU – 38 Core GPU 36GB RAM 512GB SSD 16.2 inch (3456 × 2234) Liquid Retina XDR Display&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_62531" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/apple-macbook-pro-mrw23ll-a-m3-chip-12-core-cpu-38-core-gpu-36gb-ram-512gb-ssd-16-2-inch-3456-x-2234-liquid-retina-xdr-display/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="62531"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="62531" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/apple-macbook-pro-mrw23ll-a-m3-chip-12-core-cpu-38-core-gpu-36gb-ram-512gb-ssd-16-2-inch-3456-x-2234-liquid-retina-xdr-display/">Apple MacBook Pro MRW23LL/A M3 Chip 12 Core CPU – 38 Core GPU 36GB RAM 512GB SSD 16.2 inch (3456 × 2234) Liquid Retina XDR Display</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/apple-products/apple-laptops/macbook-pro/" rel="tag">MacBook Pro</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-1096			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>373,000</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-62520 status-publish instock product_cat-macbook-pro has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="2" data-id="62520">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/apple-macbook-pro-mnwa3ll-a-m2-max-chip-12-core-cpu-38-core-gpu-32gb-ram-1tb-ssd-16-2-inch-3456-x-2234-liquid-retina-xdr-display/" class="product-image-link" aria-label="Apple MacBook Pro MNWA3LL/A M2 Max Chip 12 Core CPU – 38 Core GPU 32GB RAM 1TB SSD 16.2 inch (3456 × 2234) Liquid Retina XDR Display">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA.jpg 2000w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-1-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-1.jpg 2000w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-2-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-2-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-2-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-2-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-2-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-2-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-2.jpg 2000w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-3-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-3-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-3-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-3-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-3-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-3-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-3-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-3-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-3.jpg 2000w" data-image-id="3"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="Apple MacBook Pro MNWA3LL/A M2 Max Chip 12 Core CPU – 38 Core GPU 32GB RAM 1TB SSD 16.2 inch (3456 × 2234) Liquid Retina XDR Display" srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MNWA3LLA.jpg 2000w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=62520" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_62520" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="62520" data-product_sku="MCL-1094" aria-label="Add to cart: &ldquo;Apple MacBook Pro MNWA3LL/A M2 Max Chip 12 Core CPU – 38 Core GPU 32GB RAM 1TB SSD 16.2 inch (3456 × 2234) Liquid Retina XDR Display&rdquo;" rel="nofollow" data-success_message="&ldquo;Apple MacBook Pro MNWA3LL/A M2 Max Chip 12 Core CPU – 38 Core GPU 32GB RAM 1TB SSD 16.2 inch (3456 × 2234) Liquid Retina XDR Display&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_62520" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/apple-macbook-pro-mnwa3ll-a-m2-max-chip-12-core-cpu-38-core-gpu-32gb-ram-1tb-ssd-16-2-inch-3456-x-2234-liquid-retina-xdr-display/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="62520"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="62520" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/apple-macbook-pro-mnwa3ll-a-m2-max-chip-12-core-cpu-38-core-gpu-32gb-ram-1tb-ssd-16-2-inch-3456-x-2234-liquid-retina-xdr-display/">Apple MacBook Pro MNWA3LL/A M2 Max Chip 12 Core CPU – 38 Core GPU 32GB RAM 1TB SSD 16.2 inch (3456 × 2234) Liquid Retina XDR Display</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/apple-products/apple-laptops/macbook-pro/" rel="tag">MacBook Pro</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-1094			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>460,000</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-62463 status-publish last instock product_cat-macbook-pro has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="3" data-id="62463">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/apple-macbook-pro-mde34ll-a-m5-chip-10-core-cpu-10-core-gpu-24gb-ram-1tb-ssd-14-2-inch-3024-x-1964-liquid-retina-xdr-display/" class="product-image-link" aria-label="Apple MacBook Pro MDE34LL/A M5 Chip 10 Core CPU – 10 Core GPU 24GB RAM 1TB SSD 14.2 inch (3024 × 1964) Liquid Retina XDR Display">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA.jpg 2000w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-1-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-1.jpg 2000w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-2-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-2-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-2-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-2-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-2-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-2-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-2.jpg 2000w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-3-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-3-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-3-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-3-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-3-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-3-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-3-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-3-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-3.jpg 2000w" data-image-id="3"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="Apple MacBook Pro MDE34LL/A M5 Chip 10 Core CPU – 10 Core GPU 24GB RAM 1TB SSD 14.2 inch (3024 × 1964) Liquid Retina XDR Display" srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MDE34LLA.jpg 2000w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=62463" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_62463" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="62463" data-product_sku="MCL-1088" aria-label="Add to cart: &ldquo;Apple MacBook Pro MDE34LL/A M5 Chip 10 Core CPU – 10 Core GPU 24GB RAM 1TB SSD 14.2 inch (3024 × 1964) Liquid Retina XDR Display&rdquo;" rel="nofollow" data-success_message="&ldquo;Apple MacBook Pro MDE34LL/A M5 Chip 10 Core CPU – 10 Core GPU 24GB RAM 1TB SSD 14.2 inch (3024 × 1964) Liquid Retina XDR Display&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_62463" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/apple-macbook-pro-mde34ll-a-m5-chip-10-core-cpu-10-core-gpu-24gb-ram-1tb-ssd-14-2-inch-3024-x-1964-liquid-retina-xdr-display/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="62463"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="62463" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/apple-macbook-pro-mde34ll-a-m5-chip-10-core-cpu-10-core-gpu-24gb-ram-1tb-ssd-14-2-inch-3024-x-1964-liquid-retina-xdr-display/">Apple MacBook Pro MDE34LL/A M5 Chip 10 Core CPU – 10 Core GPU 24GB RAM 1TB SSD 14.2 inch (3024 × 1964) Liquid Retina XDR Display</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/apple-products/apple-laptops/macbook-pro/" rel="tag">MacBook Pro</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-1088			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>290,000</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-62443 status-publish first instock product_cat-macbook-pro has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="4" data-id="62443">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/apple-macbook-pro-mx2j3ll-a-m4-pro-chip-12-core-cpu-16-core-gpu-24gb-ram-1tb-ssd-14-2-inch-3024-x-1964-liquid-retina-xdr-display/" class="product-image-link" aria-label="Apple MacBook Pro MX2J3LL/A M4 Pro Chip 12 Core CPU – 16 Core GPU 24GB RAM 1TB SSD 14.2 inch (3024 × 1964) Liquid Retina XDR Display">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA.jpg 2000w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-1-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-1.jpg 2000w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-2-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-2-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-2-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-2-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-2-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-2-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-2.jpg 2000w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-3-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-3-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-3-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-3-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-3-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-3-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-3-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-3-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-3.jpg 2000w" data-image-id="3"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="Apple MacBook Pro MX2J3LL/A M4 Pro Chip 12 Core CPU – 16 Core GPU 24GB RAM 1TB SSD 14.2 inch (3024 × 1964) Liquid Retina XDR Display" srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Apple-MacBook-Pro-MX2J3LLA.jpg 2000w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=62443" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_62443" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="62443" data-product_sku="MCL-1085" aria-label="Add to cart: &ldquo;Apple MacBook Pro MX2J3LL/A M4 Pro Chip 12 Core CPU – 16 Core GPU 24GB RAM 1TB SSD 14.2 inch (3024 × 1964) Liquid Retina XDR Display&rdquo;" rel="nofollow" data-success_message="&ldquo;Apple MacBook Pro MX2J3LL/A M4 Pro Chip 12 Core CPU – 16 Core GPU 24GB RAM 1TB SSD 14.2 inch (3024 × 1964) Liquid Retina XDR Display&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_62443" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/apple-macbook-pro-mx2j3ll-a-m4-pro-chip-12-core-cpu-16-core-gpu-24gb-ram-1tb-ssd-14-2-inch-3024-x-1964-liquid-retina-xdr-display/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="62443"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="62443" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/apple-macbook-pro-mx2j3ll-a-m4-pro-chip-12-core-cpu-16-core-gpu-24gb-ram-1tb-ssd-14-2-inch-3024-x-1964-liquid-retina-xdr-display/">Apple MacBook Pro MX2J3LL/A M4 Pro Chip 12 Core CPU – 16 Core GPU 24GB RAM 1TB SSD 14.2 inch (3024 × 1964) Liquid Retina XDR Display</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/apple-products/apple-laptops/macbook-pro/" rel="tag">MacBook Pro</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-1085			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>340,000</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-62382 status-publish instock product_cat-macbook-air has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="5" data-id="62382">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/apple-macbook-air-mw133pa-a-m4-chip-10-core-cpu-10-core-gpu-16gb-ram-256gb-ssd-13-6-inch-2560-x-1664-liquid-retina-display/" class="product-image-link" aria-label="Apple MacBook Air MW133PA/A M4 Chip 10 Core CPU – 10 Core GPU 16GB RAM 256GB SSD 13.6 inch (2560 x 1664) Liquid Retina Display">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA.jpg 2000w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-1-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-1.jpg 2000w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-2-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-2-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-2-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-2-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-2-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-2-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-2.jpg 2000w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-3-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-3-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-3-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-3-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-3-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-3-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-3-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-3-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-3.jpg 2000w" data-image-id="3"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="Apple MacBook Air MW133PA/A M4 Chip 10 Core CPU – 10 Core GPU 16GB RAM 256GB SSD 13.6 inch (2560 x 1664) Liquid Retina Display" srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/03/Apple-MacBook-Air-MW133PAA.jpg 2000w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=62382" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_62382" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="62382" data-product_sku="MCL-1078" aria-label="Add to cart: &ldquo;Apple MacBook Air MW133PA/A M4 Chip 10 Core CPU – 10 Core GPU 16GB RAM 256GB SSD 13.6 inch (2560 x 1664) Liquid Retina Display&rdquo;" rel="nofollow" data-success_message="&ldquo;Apple MacBook Air MW133PA/A M4 Chip 10 Core CPU – 10 Core GPU 16GB RAM 256GB SSD 13.6 inch (2560 x 1664) Liquid Retina Display&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_62382" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/apple-macbook-air-mw133pa-a-m4-chip-10-core-cpu-10-core-gpu-16gb-ram-256gb-ssd-13-6-inch-2560-x-1664-liquid-retina-display/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="62382"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="62382" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/apple-macbook-air-mw133pa-a-m4-chip-10-core-cpu-10-core-gpu-16gb-ram-256gb-ssd-13-6-inch-2560-x-1664-liquid-retina-display/">Apple MacBook Air MW133PA/A M4 Chip 10 Core CPU – 10 Core GPU 16GB RAM 256GB SSD 13.6 inch (2560 x 1664) Liquid Retina Display</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/apple-products/apple-laptops/macbook-air/" rel="tag">MacBook Air®</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-1078			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>145,000</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-60657 status-publish instock product_cat-macbook-pro has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="6" data-id="60657">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/apple-macbook-pro-mtl83ll-a-m3-8-core-cpu-10-core-gpu-8gb-ram-1tb-ssd-14-2-inch-3024-x-1964-liquid-retina-xdr-display/" class="product-image-link" aria-label="Apple MacBook Pro MTL83LL/A M3 8 core CPU 10-core GPU 8GB RAM 1TB SSD 14.2 inch (3024 × 1964) Liquid Retina XDR Display">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA.jpg 2000w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-1-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-1.jpg 2000w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-2-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-2-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-2-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-2-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-2-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-2-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-2.jpg 2000w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-3-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-3-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-3-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-3-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-3-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-3-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-3-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-3-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-3.jpg 2000w" data-image-id="3"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="Apple MacBook Pro MTL83LL/A M3 8 core CPU 10-core GPU 8GB RAM 1TB SSD 14.2 inch (3024 × 1964) Liquid Retina XDR Display" srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL83LLA.jpg 2000w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=60657" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_60657" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="60657" data-product_sku="MCL-939" aria-label="Add to cart: &ldquo;Apple MacBook Pro MTL83LL/A M3 8 core CPU 10-core GPU 8GB RAM 1TB SSD 14.2 inch (3024 × 1964) Liquid Retina XDR Display&rdquo;" rel="nofollow" data-success_message="&ldquo;Apple MacBook Pro MTL83LL/A M3 8 core CPU 10-core GPU 8GB RAM 1TB SSD 14.2 inch (3024 × 1964) Liquid Retina XDR Display&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_60657" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/apple-macbook-pro-mtl83ll-a-m3-8-core-cpu-10-core-gpu-8gb-ram-1tb-ssd-14-2-inch-3024-x-1964-liquid-retina-xdr-display/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="60657"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="60657" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/apple-macbook-pro-mtl83ll-a-m3-8-core-cpu-10-core-gpu-8gb-ram-1tb-ssd-14-2-inch-3024-x-1964-liquid-retina-xdr-display/">Apple MacBook Pro MTL83LL/A M3 8 core CPU 10-core GPU 8GB RAM 1TB SSD 14.2 inch (3024 × 1964) Liquid Retina XDR Display</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/apple-products/apple-laptops/macbook-pro/" rel="tag">MacBook Pro</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-939			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>232,000</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-60656 status-publish last instock product_cat-macbook-pro has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="7" data-id="60656">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/apple-macbook-pro-mtl73ll-a-m3-chip-8-core-cpu-10-core-gpu-8gb-ram-512gb-ssd-14-2-inch-3024-x-1964-liquid-retina-xdr-display/" class="product-image-link" aria-label="Apple MacBook Pro MTL73LL/A M3 Chip 8 Core CPU 10-Core GPU 8GB RAM 512GB SSD 14.2 inch (3024 × 1964) Liquid Retina XDR Display">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA.jpg 2000w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-2-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-2-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-2-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-2-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-2-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-2-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-2.jpg 2000w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-3-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-3-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-3-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-3-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-3-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-3-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-3-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-3-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-3.jpg 2000w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-4-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-4-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-4-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-4-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-4-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-4-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-4-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-4-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-4.jpg 2000w" data-image-id="3"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="Apple MacBook Pro MTL73LL/A M3 Chip 8 Core CPU 10-Core GPU 8GB RAM 512GB SSD 14.2 inch (3024 × 1964) Liquid Retina XDR Display" srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Pro-MTL73LLA.jpg 2000w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=60656" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_60656" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="60656" data-product_sku="MCL-937" aria-label="Add to cart: &ldquo;Apple MacBook Pro MTL73LL/A M3 Chip 8 Core CPU 10-Core GPU 8GB RAM 512GB SSD 14.2 inch (3024 × 1964) Liquid Retina XDR Display&rdquo;" rel="nofollow" data-success_message="&ldquo;Apple MacBook Pro MTL73LL/A M3 Chip 8 Core CPU 10-Core GPU 8GB RAM 512GB SSD 14.2 inch (3024 × 1964) Liquid Retina XDR Display&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_60656" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/apple-macbook-pro-mtl73ll-a-m3-chip-8-core-cpu-10-core-gpu-8gb-ram-512gb-ssd-14-2-inch-3024-x-1964-liquid-retina-xdr-display/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="60656"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="60656" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/apple-macbook-pro-mtl73ll-a-m3-chip-8-core-cpu-10-core-gpu-8gb-ram-512gb-ssd-14-2-inch-3024-x-1964-liquid-retina-xdr-display/">Apple MacBook Pro MTL73LL/A M3 Chip 8 Core CPU 10-Core GPU 8GB RAM 512GB SSD 14.2 inch (3024 × 1964) Liquid Retina XDR Display</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/apple-products/apple-laptops/macbook-pro/" rel="tag">MacBook Pro</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-937			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>210,000</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-60586 status-publish first instock product_cat-macbook-air has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="8" data-id="60586">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/apple-macbook-air-mqkw3ll-a-m2-chip-8-core-cpu-10-core-gpu-8gb-ram-256gb-ssd-15-3-inch-2880-x-1864-liquid-retina-display/" class="product-image-link" aria-label="Apple MacBook Air MQKW3LL/A M2 chip 8 core CPU &#8211; 10 core GPU 8GB RAM 256GB SSD 15.3&#8243; inch (2880 × 1864) Liquid Retina Display">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA.jpg 2000w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-1-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-1.jpg 2000w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-2-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-2-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-2-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-2-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-2-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-2-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-2.jpg 2000w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-3-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-3-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-3-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-3-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-3-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-3-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-3-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-3-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-3.jpg 2000w" data-image-id="3"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="Apple MacBook Air MQKW3LL/A M2 chip 8 core CPU - 10 core GPU 8GB RAM 256GB SSD 15.3&quot; inch (2880 × 1864) Liquid Retina Display" srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/09/Apple-MacBook-Air-MQKW3LLA.jpg 2000w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=60586" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_60586" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="60586" data-product_sku="MCL-923" aria-label="Add to cart: &ldquo;Apple MacBook Air MQKW3LL/A M2 chip 8 core CPU - 10 core GPU 8GB RAM 256GB SSD 15.3&quot; inch (2880 × 1864) Liquid Retina Display&rdquo;" rel="nofollow" data-success_message="&ldquo;Apple MacBook Air MQKW3LL/A M2 chip 8 core CPU - 10 core GPU 8GB RAM 256GB SSD 15.3&quot; inch (2880 × 1864) Liquid Retina Display&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_60586" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/apple-macbook-air-mqkw3ll-a-m2-chip-8-core-cpu-10-core-gpu-8gb-ram-256gb-ssd-15-3-inch-2880-x-1864-liquid-retina-display/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="60586"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="60586" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/apple-macbook-air-mqkw3ll-a-m2-chip-8-core-cpu-10-core-gpu-8gb-ram-256gb-ssd-15-3-inch-2880-x-1864-liquid-retina-display/">Apple MacBook Air MQKW3LL/A M2 chip 8 core CPU &#8211; 10 core GPU 8GB RAM 256GB SSD 15.3&#8243; inch (2880 × 1864) Liquid Retina Display</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/apple-products/apple-laptops/macbook-air/" rel="tag">MacBook Air®</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-923			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>165,000</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		
				
			</div>
</div>
</div>
					</div>
								</div>
					</div>

							<div class="wd-nav-arrows wd-pos-sep wd-hover-1 wd-icon-1">
			<div class="wd-btn-arrow wd-prev wd-disabled">
				<div class="wd-arrow-inner"></div>
			</div>
			<div class="wd-btn-arrow wd-next">
				<div class="wd-arrow-inner"></div>
			</div>
		</div>
						</div>

									<div class="wd-nav-pagin-wrap text-center wd-style-shape wd-hide-md-sm wd-hide-sm">
			<ul class="wd-nav-pagin"></ul>
		</div>
									</div>
						</div></div></div></div><div class="vc_row wpb_row vc_row-fluid wd-rs-6970ebaf2de40"><div class="wpb_column vc_column_container vc_col-sm-12 wd-enabled-flex wd-rs-696f9f385b880"><div class="vc_column-inner"><div class="wpb_wrapper">
		<div id="wd-69ecb2d3f139f" class="title-wrapper wd-wpb wd-set-mb reset-last-child  wd-rs-69ecb2d3f139f wd-enabled-width wd-title-color-default wd-title-style-default text-left vc_custom_1777119962441 wd-underline-colored">
			
			<div class="liner-continer">
				<h4 class="woodmart-title-container title  wd-font-weight- wd-fontsize-l" >DEALS ON PRINTERS</h4>
							</div>
			
			
			
		</div>
		
		<div id="wd-69ecb2df516e1" class=" wd-rs-69ecb2df516e1 vc_custom_1777119982752 wd-button-wrapper text-center inline-element"><a href="https://www.mombasacomputers.com/product-category/printers-scanners/printers/" title="" style="--btn-color:#fff;--btn-color-hover:#fff;" class="btn btn-style-default btn-shape-round btn-size-default btn-icon-pos-right">More products<span class="wd-btn-icon"><img decoding="async"  src="https://www.mombasacomputers.com/wp-content/uploads/2024/10/Icon.svg" title="Icon" loading="lazy" width="12" height="12"></span></a></div>			
			<div id="carousel-366" class="wd-carousel-container  wd-wpb wd-rs-69ecb2f43847c  wd-products-element wd-products products products-bordered-grid">
				
							
				<div class="wd-carousel-inner">
					<div class=" wd-carousel wd-grid"  data-grid-gallery='{"grid_gallery":"1","grid_gallery_control":"arrows","grid_gallery_enable_arrows":"none"}' data-scroll_per_page="yes" style="--wd-col-lg:8;--wd-col-md:4;--wd-col-sm:2;--wd-gap-lg:20px;--wd-gap-sm:10px;">
						<div class="wd-carousel-wrap">
									<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-28665 status-publish instock product_cat-brother-printers has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="1" data-id="28665">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/brother-dcp-l2540dw-a4-mono-multifunction-laser-printer/" class="product-image-link" aria-label="Brother DCP-L2540DW A4 Mono Multifunction Laser Printer">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/08/Brother-DCP-L2540DW-A4-Mono-Multifunction-Laser-Printer-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/08/Brother-DCP-L2540DW-A4-Mono-Multifunction-Laser-Printer-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Brother-DCP-L2540DW-A4-Mono-Multifunction-Laser-Printer-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Brother-DCP-L2540DW-A4-Mono-Multifunction-Laser-Printer-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Brother-DCP-L2540DW-A4-Mono-Multifunction-Laser-Printer-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Brother-DCP-L2540DW-A4-Mono-Multifunction-Laser-Printer-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Brother-DCP-L2540DW-A4-Mono-Multifunction-Laser-Printer.jpg 1200w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/08/Brother-DCP-L2540DW-A4-Mono-Multifunction-Laser-Printer-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/08/Brother-DCP-L2540DW-A4-Mono-Multifunction-Laser-Printer-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Brother-DCP-L2540DW-A4-Mono-Multifunction-Laser-Printer-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Brother-DCP-L2540DW-A4-Mono-Multifunction-Laser-Printer-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Brother-DCP-L2540DW-A4-Mono-Multifunction-Laser-Printer-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Brother-DCP-L2540DW-A4-Mono-Multifunction-Laser-Printer-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Brother-DCP-L2540DW-A4-Mono-Multifunction-Laser-Printer-1.jpg 1200w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/08/Brother-DCP-L2540DW-A4-Mono-Multifunction-Laser-Printer-2-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/08/Brother-DCP-L2540DW-A4-Mono-Multifunction-Laser-Printer-2-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Brother-DCP-L2540DW-A4-Mono-Multifunction-Laser-Printer-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Brother-DCP-L2540DW-A4-Mono-Multifunction-Laser-Printer-2-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Brother-DCP-L2540DW-A4-Mono-Multifunction-Laser-Printer-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Brother-DCP-L2540DW-A4-Mono-Multifunction-Laser-Printer-2-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Brother-DCP-L2540DW-A4-Mono-Multifunction-Laser-Printer-2.jpg 1200w" data-image-id="2"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2023/08/Brother-DCP-L2540DW-A4-Mono-Multifunction-Laser-Printer-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="Brother DCP-L2540DW A4 Mono Multifunction Laser Printer" srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/08/Brother-DCP-L2540DW-A4-Mono-Multifunction-Laser-Printer-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Brother-DCP-L2540DW-A4-Mono-Multifunction-Laser-Printer-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Brother-DCP-L2540DW-A4-Mono-Multifunction-Laser-Printer-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Brother-DCP-L2540DW-A4-Mono-Multifunction-Laser-Printer-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Brother-DCP-L2540DW-A4-Mono-Multifunction-Laser-Printer-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Brother-DCP-L2540DW-A4-Mono-Multifunction-Laser-Printer.jpg 1200w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=28665" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_28665" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="28665" data-product_sku="MCL-524" aria-label="Add to cart: &ldquo;Brother DCP-L2540DW A4 Mono Multifunction Laser Printer&rdquo;" rel="nofollow" data-success_message="&ldquo;Brother DCP-L2540DW A4 Mono Multifunction Laser Printer&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_28665" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/brother-dcp-l2540dw-a4-mono-multifunction-laser-printer/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="28665"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="28665" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/brother-dcp-l2540dw-a4-mono-multifunction-laser-printer/">Brother DCP-L2540DW A4 Mono Multifunction Laser Printer</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/printers-scanners/printers/brother-printers/" rel="tag">Brother Printers</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-524			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>37,000</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		<span class="acoplw-badge acoplw-textBlock acoplw-elemBlock "><span class="acoplw-badge-icon acoplw-bseight acoplwRightAlign acoplwPosTop acoplw-custom-badge-62251" style="opacity:1;width:46px;font-size:13px;line-height:px;font-weight: 400;height:46px;transform:rotateX(0deg) rotateY(0deg) rotateZ(0deg);top:0px;bottom:auto;background:rgba(208, 2, 27, 1);"><span class="acoplw-blockText" style="color:rgba(249, 250, 252, 1);">NEW</span></span></span>
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-28613 status-publish instock product_cat-canon-printers has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="2" data-id="28613">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/canon-pixma-g2410-a4-3-in-1-multifunction-printer/" class="product-image-link" aria-label="Canon PIXMA G2410 A4 3-in-1 Multifunction Printer">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer.jpg 1200w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-2-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-2-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-2-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-2-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-2.jpg 1200w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-3-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-3-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-3-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-3-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-3-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-3-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-3.jpg 1200w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-4-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-4-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-4-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-4-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-4-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-4-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-4.jpg 1200w" data-image-id="3"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-6-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-6-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-6-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-6-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-6-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-6-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-6.jpg 1200w" data-image-id="4"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-5-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-5-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-5-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-5-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-5-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-5-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-5.jpg 1200w" data-image-id="5"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-7-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-7-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-7-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-7-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-7-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-7-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-7.jpg 1200w" data-image-id="6"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="Canon PIXMA G2410 A4 3-in-1 Multifunction Printer" srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/08/Canon-PIXMA-G2410-A4-3-in-1-Multifunction-Printer.jpg 1200w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=28613" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_28613" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="28613" data-product_sku="MCL-520" aria-label="Add to cart: &ldquo;Canon PIXMA G2410 A4 3-in-1 Multifunction Printer&rdquo;" rel="nofollow" data-success_message="&ldquo;Canon PIXMA G2410 A4 3-in-1 Multifunction Printer&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_28613" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/canon-pixma-g2410-a4-3-in-1-multifunction-printer/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="28613"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="28613" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/canon-pixma-g2410-a4-3-in-1-multifunction-printer/">Canon PIXMA G2410 A4 3-in-1 Multifunction Printer</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/printers-scanners/printers/canon-printers/" rel="tag">Canon Printers</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-520			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>17,500</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		<span class="acoplw-badge acoplw-textBlock acoplw-elemBlock "><span class="acoplw-badge-icon acoplw-bseight acoplwRightAlign acoplwPosTop acoplw-custom-badge-62251" style="opacity:1;width:46px;font-size:13px;line-height:px;font-weight: 400;height:46px;transform:rotateX(0deg) rotateY(0deg) rotateZ(0deg);top:0px;bottom:auto;background:rgba(208, 2, 27, 1);"><span class="acoplw-blockText" style="color:rgba(249, 250, 252, 1);">NEW</span></span></span>
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-28049 status-publish last instock product_cat-epson-printers has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="3" data-id="28049">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/epson-ecotank-l8050-ink-tank-wireless-high-volume-photo-printer/" class="product-image-link" aria-label="Epson EcoTank L8050 Ink Tank Wireless High Volume Photo Printer">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer.jpg 1200w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-1.jpg 1200w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-2-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-2-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-2-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-2-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-2.jpg 1200w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-4-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-4-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-4-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-4-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-4-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-4-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-4.jpg 1200w" data-image-id="3"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-5-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-5-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-5-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-5-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-5-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-5-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-5.jpg 1200w" data-image-id="4"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-6-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-6-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-6-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-6-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-6-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-6-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-6.jpg 1200w" data-image-id="5"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-7-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-7-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-7-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-7-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-7-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-7-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-7.jpg 1200w" data-image-id="6"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="Epson EcoTank L8050 Ink Tank Wireless High Volume Photo Printer" srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/06/Epson-EcoTank-L8050-Ink-Tank-Wireless-High-Volume-Photo-Printer.jpg 1200w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=28049" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_28049" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="28049" data-product_sku="MCL-483" aria-label="Add to cart: &ldquo;Epson EcoTank L8050 Ink Tank Wireless High Volume Photo Printer&rdquo;" rel="nofollow" data-success_message="&ldquo;Epson EcoTank L8050 Ink Tank Wireless High Volume Photo Printer&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_28049" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/epson-ecotank-l8050-ink-tank-wireless-high-volume-photo-printer/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="28049"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="28049" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/epson-ecotank-l8050-ink-tank-wireless-high-volume-photo-printer/">Epson EcoTank L8050 Ink Tank Wireless High Volume Photo Printer</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/printers-scanners/printers/epson-printers/" rel="tag">Epson Printers</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-483			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>48,000</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		<span class="acoplw-badge acoplw-textBlock acoplw-elemBlock "><span class="acoplw-badge-icon acoplw-bseight acoplwRightAlign acoplwPosTop acoplw-custom-badge-62251" style="opacity:1;width:46px;font-size:13px;line-height:px;font-weight: 400;height:46px;transform:rotateX(0deg) rotateY(0deg) rotateZ(0deg);top:0px;bottom:auto;background:rgba(208, 2, 27, 1);"><span class="acoplw-blockText" style="color:rgba(249, 250, 252, 1);">NEW</span></span></span>
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-27267 status-publish first instock product_cat-epson-printers has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="4" data-id="27267">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/epson-dot-matrix-lq-350-printer/" class="product-image-link" aria-label="Epson Dot Matrix LQ-350 Printer">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/04/Epson-Dot-Matrix-LQ-350-Printer-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/04/Epson-Dot-Matrix-LQ-350-Printer-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/Epson-Dot-Matrix-LQ-350-Printer-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/Epson-Dot-Matrix-LQ-350-Printer-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/Epson-Dot-Matrix-LQ-350-Printer-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/Epson-Dot-Matrix-LQ-350-Printer-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/Epson-Dot-Matrix-LQ-350-Printer.jpg 1200w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/04/Epson-Dot-Matrix-LQ-350-Printer-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/04/Epson-Dot-Matrix-LQ-350-Printer-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/Epson-Dot-Matrix-LQ-350-Printer-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/Epson-Dot-Matrix-LQ-350-Printer-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/Epson-Dot-Matrix-LQ-350-Printer-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/Epson-Dot-Matrix-LQ-350-Printer-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/Epson-Dot-Matrix-LQ-350-Printer-1.jpg 1200w" data-image-id="1"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2023/04/Epson-Dot-Matrix-LQ-350-Printer-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="Epson Dot Matrix LQ-350 Printer" srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/04/Epson-Dot-Matrix-LQ-350-Printer-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/Epson-Dot-Matrix-LQ-350-Printer-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/Epson-Dot-Matrix-LQ-350-Printer-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/Epson-Dot-Matrix-LQ-350-Printer-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/Epson-Dot-Matrix-LQ-350-Printer-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/Epson-Dot-Matrix-LQ-350-Printer.jpg 1200w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=27267" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_27267" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="27267" data-product_sku="MCL-445" aria-label="Add to cart: &ldquo;Epson Dot Matrix LQ-350 Printer&rdquo;" rel="nofollow" data-success_message="&ldquo;Epson Dot Matrix LQ-350 Printer&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_27267" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/epson-dot-matrix-lq-350-printer/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="27267"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="27267" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/epson-dot-matrix-lq-350-printer/">Epson Dot Matrix LQ-350 Printer</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/printers-scanners/printers/epson-printers/" rel="tag">Epson Printers</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-445			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>32,000</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		<span class="acoplw-badge acoplw-textBlock acoplw-elemBlock "><span class="acoplw-badge-icon acoplw-bseight acoplwRightAlign acoplwPosTop acoplw-custom-badge-62251" style="opacity:1;width:46px;font-size:13px;line-height:px;font-weight: 400;height:46px;transform:rotateX(0deg) rotateY(0deg) rotateZ(0deg);top:0px;bottom:auto;background:rgba(208, 2, 27, 1);"><span class="acoplw-blockText" style="color:rgba(249, 250, 252, 1);">NEW</span></span></span>
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-26055 status-publish instock product_cat-epson-printers has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="5" data-id="26055">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/epson-eco-tank-l3250-a4-wi-fi-all-in-one-ink-tank-printer/" class="product-image-link" aria-label="Epson Eco-Tank L3250 A4 Wi-Fi All-in-One Ink Tank Printer">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250-3-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250-3-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250-3-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250-3-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250-3-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250-3-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250-3-100x100.jpg 100w, https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250-3.jpg 1200w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250-1-100x100.jpg 100w, https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250-1.jpg 1200w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250-2-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250-2-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250-2-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250-2-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250-2-100x100.jpg 100w, https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250-2.jpg 1200w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250-100x100.jpg 100w, https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250.jpg 1200w" data-image-id="3"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250-3-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="Epson EcoTank L3250 A4 Wi-Fi All-in-One Ink Tank Printer" srcset="https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250-3-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250-3-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250-3-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250-3-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250-3-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250-3-100x100.jpg 100w, https://www.mombasacomputers.com/wp-content/uploads/2022/09/Epson-L3250-3.jpg 1200w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=26055" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_26055" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="26055" data-product_sku="MCL-392" aria-label="Add to cart: &ldquo;Epson Eco-Tank L3250 A4 Wi-Fi All-in-One Ink Tank Printer&rdquo;" rel="nofollow" data-success_message="&ldquo;Epson Eco-Tank L3250 A4 Wi-Fi All-in-One Ink Tank Printer&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_26055" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/epson-eco-tank-l3250-a4-wi-fi-all-in-one-ink-tank-printer/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="26055"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="26055" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/epson-eco-tank-l3250-a4-wi-fi-all-in-one-ink-tank-printer/">Epson Eco-Tank L3250 A4 Wi-Fi All-in-One Ink Tank Printer</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/printers-scanners/printers/epson-printers/" rel="tag">Epson Printers</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-392			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>24,500</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		<span class="acoplw-badge acoplw-textBlock acoplw-elemBlock "><span class="acoplw-badge-icon acoplw-bseight acoplwRightAlign acoplwPosTop acoplw-custom-badge-62251" style="opacity:1;width:46px;font-size:13px;line-height:px;font-weight: 400;height:46px;transform:rotateX(0deg) rotateY(0deg) rotateZ(0deg);top:0px;bottom:auto;background:rgba(208, 2, 27, 1);"><span class="acoplw-blockText" style="color:rgba(249, 250, 252, 1);">NEW</span></span></span>
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-with-labels wd-hover-tiled product-grid-item product type-product post-22131 status-publish instock product_cat-brother-printers has-post-thumbnail sale taxable shipping-taxable purchasable product-type-simple" data-loop="6" data-id="22131">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/brother-dcp-t420w-all-in-one-ink-tank-refill-system-printer-with-built-in-wireless-technology/" class="product-image-link" aria-label="Brother DCP-T420W All-in One Ink Tank Refill System Printer with Built-in-Wireless Technology">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology.jpg 1200w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-1.jpg 1200w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-2-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-2-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-2-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-2-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-2.jpg 1200w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-3-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-3-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-3-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-3-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-3-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-3-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-3.jpg 1200w" data-image-id="3"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-4-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-4-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-4-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-4-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-4-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-4-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-4.jpg 1200w" data-image-id="4"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<div class="product-labels labels-rounded"><span class="onsale product-label">-10%</span></div><img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="Brother DCP-T420W All-in One Ink Tank Refill System Printer with Built-in-Wireless Technology" srcset="https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2022/03/Brother-DCP-T420W-All-in-One-Ink-Tank-Refill-System-Printer-with-Built-in-Wireless-Technology.jpg 1200w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=22131" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_22131" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="22131" data-product_sku="MCL-296" aria-label="Add to cart: &ldquo;Brother DCP-T420W All-in One Ink Tank Refill System Printer with Built-in-Wireless Technology&rdquo;" rel="nofollow" data-success_message="&ldquo;Brother DCP-T420W All-in One Ink Tank Refill System Printer with Built-in-Wireless Technology&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_22131" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/brother-dcp-t420w-all-in-one-ink-tank-refill-system-printer-with-built-in-wireless-technology/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="22131"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="22131" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/brother-dcp-t420w-all-in-one-ink-tank-refill-system-printer-with-built-in-wireless-technology/">Brother DCP-T420W All-in One Ink Tank Refill System Printer with Built-in-Wireless Technology</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/printers-scanners/printers/brother-printers/" rel="tag">Brother Printers</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-296			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><del aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>26,000</bdi></span></del> <span class="screen-reader-text">Original price was: KSh26,000.</span><ins aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>23,500</bdi></span></ins><span class="screen-reader-text">Current price is: KSh23,500.</span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		<span class="acoplw-badge acoplw-textBlock acoplw-elemBlock "><span class="acoplw-badge-icon acoplw-bseight acoplwRightAlign acoplwPosTop acoplw-custom-badge-62251" style="opacity:1;width:46px;font-size:13px;line-height:px;font-weight: 400;height:46px;transform:rotateX(0deg) rotateY(0deg) rotateZ(0deg);top:0px;bottom:auto;background:rgba(208, 2, 27, 1);"><span class="acoplw-blockText" style="color:rgba(249, 250, 252, 1);">NEW</span></span></span>
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-21698 status-publish last instock product_cat-epson-printers has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="7" data-id="21698">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/epson-ecotank-l15150-a3-wi-fi-duplex-all-in-one-ink-printer/" class="product-image-link" aria-label="Epson EcoTank L15150 A3 Wi-Fi Duplex All-in-One Ink Printer">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-370x370.jpg 370w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-100x100.jpg 100w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer.jpg 1200w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-1-370x370.jpg 370w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-1-100x100.jpg 100w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-1.jpg 1200w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-2-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-2-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-2-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-2-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-2-370x370.jpg 370w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-2-100x100.jpg 100w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-2.jpg 1200w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-3-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-3-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-3-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-3-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-3-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-3-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-3-370x370.jpg 370w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-3-100x100.jpg 100w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-3.jpg 1200w" data-image-id="3"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-4-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-4-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-4-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-4-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-4-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-4-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-4-370x370.jpg 370w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-4-100x100.jpg 100w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-4.jpg 1200w" data-image-id="4"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="Epson EcoTank L15150 A3 Wi-Fi Duplex All-in-One Ink Printer" srcset="https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-370x370.jpg 370w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer-100x100.jpg 100w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Epson-EcoTank-L15150-A3-Wi-Fi-Duplex-All-in-One-Ink-Printer.jpg 1200w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=21698" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_21698" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="21698" data-product_sku="MCL-286" aria-label="Add to cart: &ldquo;Epson EcoTank L15150 A3 Wi-Fi Duplex All-in-One Ink Printer&rdquo;" rel="nofollow" data-success_message="&ldquo;Epson EcoTank L15150 A3 Wi-Fi Duplex All-in-One Ink Printer&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_21698" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/epson-ecotank-l15150-a3-wi-fi-duplex-all-in-one-ink-printer/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="21698"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="21698" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/epson-ecotank-l15150-a3-wi-fi-duplex-all-in-one-ink-printer/">Epson EcoTank L15150 A3 Wi-Fi Duplex All-in-One Ink Printer</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/printers-scanners/printers/epson-printers/" rel="tag">Epson Printers</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-286			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>140,000</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		<span class="acoplw-badge acoplw-textBlock acoplw-elemBlock "><span class="acoplw-badge-icon acoplw-bseight acoplwRightAlign acoplwPosTop acoplw-custom-badge-62251" style="opacity:1;width:46px;font-size:13px;line-height:px;font-weight: 400;height:46px;transform:rotateX(0deg) rotateY(0deg) rotateZ(0deg);top:0px;bottom:auto;background:rgba(208, 2, 27, 1);"><span class="acoplw-blockText" style="color:rgba(249, 250, 252, 1);">NEW</span></span></span>
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-with-labels wd-hover-tiled product-grid-item product type-product post-16643 status-publish first instock product_cat-epson-printers has-post-thumbnail sale taxable shipping-taxable purchasable product-type-simple" data-loop="8" data-id="16643">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/epson-dot-matrix-printer-lq-2190-euro-nlsp-240v/" class="product-image-link" aria-label="Epson Dot matrix Printer LQ-2190 EURO NLSP 240V">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2020/09/Epson-Dot-matrix-Printer-LQ-2190-EURO-NLSP-240V.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2020/09/Epson-Dot-matrix-Printer-LQ-2190-EURO-NLSP-240V.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2020/09/Epson-Dot-matrix-Printer-LQ-2190-EURO-NLSP-240V-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2020/09/Epson-Dot-matrix-Printer-LQ-2190-EURO-NLSP-240V-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2020/09/Epson-Dot-matrix-Printer-LQ-2190-EURO-NLSP-240V-100x100.jpg 100w, https://www.mombasacomputers.com/wp-content/uploads/2020/09/Epson-Dot-matrix-Printer-LQ-2190-EURO-NLSP-240V-64x64.jpg 64w, https://www.mombasacomputers.com/wp-content/uploads/2020/09/Epson-Dot-matrix-Printer-LQ-2190-EURO-NLSP-240V-400x400.jpg 400w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2020/09/Epson-Dot-matrix-Printer-LQ-2190-EURO-NLSP-240V-1.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2020/09/Epson-Dot-matrix-Printer-LQ-2190-EURO-NLSP-240V-1.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2020/09/Epson-Dot-matrix-Printer-LQ-2190-EURO-NLSP-240V-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2020/09/Epson-Dot-matrix-Printer-LQ-2190-EURO-NLSP-240V-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2020/09/Epson-Dot-matrix-Printer-LQ-2190-EURO-NLSP-240V-1-100x100.jpg 100w, https://www.mombasacomputers.com/wp-content/uploads/2020/09/Epson-Dot-matrix-Printer-LQ-2190-EURO-NLSP-240V-1-64x64.jpg 64w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2020/09/Epson-Dot-matrix-Printer-LQ-2190-EURO-NLSP-240V-2.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2020/09/Epson-Dot-matrix-Printer-LQ-2190-EURO-NLSP-240V-2.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2020/09/Epson-Dot-matrix-Printer-LQ-2190-EURO-NLSP-240V-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2020/09/Epson-Dot-matrix-Printer-LQ-2190-EURO-NLSP-240V-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2020/09/Epson-Dot-matrix-Printer-LQ-2190-EURO-NLSP-240V-2-100x100.jpg 100w, https://www.mombasacomputers.com/wp-content/uploads/2020/09/Epson-Dot-matrix-Printer-LQ-2190-EURO-NLSP-240V-2-64x64.jpg 64w" data-image-id="2"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<div class="product-labels labels-rounded"><span class="onsale product-label">-5%</span></div><img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2020/09/Epson-Dot-matrix-Printer-LQ-2190-EURO-NLSP-240V.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="Epson Dot matrix Printer LQ-2190 EURO NLSP 240V" srcset="https://www.mombasacomputers.com/wp-content/uploads/2020/09/Epson-Dot-matrix-Printer-LQ-2190-EURO-NLSP-240V.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2020/09/Epson-Dot-matrix-Printer-LQ-2190-EURO-NLSP-240V-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2020/09/Epson-Dot-matrix-Printer-LQ-2190-EURO-NLSP-240V-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2020/09/Epson-Dot-matrix-Printer-LQ-2190-EURO-NLSP-240V-100x100.jpg 100w, https://www.mombasacomputers.com/wp-content/uploads/2020/09/Epson-Dot-matrix-Printer-LQ-2190-EURO-NLSP-240V-64x64.jpg 64w, https://www.mombasacomputers.com/wp-content/uploads/2020/09/Epson-Dot-matrix-Printer-LQ-2190-EURO-NLSP-240V-400x400.jpg 400w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=16643" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_16643" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="16643" data-product_sku="MCL-147" aria-label="Add to cart: &ldquo;Epson Dot matrix Printer LQ-2190 EURO NLSP 240V&rdquo;" rel="nofollow" data-success_message="&ldquo;Epson Dot matrix Printer LQ-2190 EURO NLSP 240V&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_16643" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/epson-dot-matrix-printer-lq-2190-euro-nlsp-240v/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="16643"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="16643" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/epson-dot-matrix-printer-lq-2190-euro-nlsp-240v/">Epson Dot matrix Printer LQ-2190 EURO NLSP 240V</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/printers-scanners/printers/epson-printers/" rel="tag">Epson Printers</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-147			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><del aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>105,000</bdi></span></del> <span class="screen-reader-text">Original price was: KSh105,000.</span><ins aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>100,000</bdi></span></ins><span class="screen-reader-text">Current price is: KSh100,000.</span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		<span class="acoplw-badge acoplw-textBlock acoplw-elemBlock "><span class="acoplw-badge-icon acoplw-bseight acoplwRightAlign acoplwPosTop acoplw-custom-badge-62251" style="opacity:1;width:46px;font-size:13px;line-height:px;font-weight: 400;height:46px;transform:rotateX(0deg) rotateY(0deg) rotateZ(0deg);top:0px;bottom:auto;background:rgba(208, 2, 27, 1);"><span class="acoplw-blockText" style="color:rgba(249, 250, 252, 1);">NEW</span></span></span>
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-14599 status-publish instock product_cat-hp-laser-printers-color has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="9" data-id="14599">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/hp-laserjet-mfp-m141a-monochrome-laser-printer/" class="product-image-link" aria-label="HP LaserJet MFP M141a Monochrome Laser Printer">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer.jpg 1500w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer-1.jpg 1500w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer-2-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer-2-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer-2-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer-2-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer-2-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer-2.jpg 1500w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer-3-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer-3-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer-3-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer-3-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer-3-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer-3-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer-3-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer-3.jpg 1500w" data-image-id="3"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="HP LaserJet MFP M141a Monochrome Laser Printer" srcset="https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2020/07/HP-LaserJet-MFP-M141a-Monochrome-Laser-Printer.jpg 1500w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=14599" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_14599" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="14599" data-product_sku="MCL-68" aria-label="Add to cart: &ldquo;HP LaserJet MFP M141a Monochrome Laser Printer&rdquo;" rel="nofollow" data-success_message="&ldquo;HP LaserJet MFP M141a Monochrome Laser Printer&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_14599" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/hp-laserjet-mfp-m141a-monochrome-laser-printer/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="14599"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="14599" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/hp-laserjet-mfp-m141a-monochrome-laser-printer/">HP LaserJet MFP M141a Monochrome Laser Printer</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/printers-scanners/printers/hp-laser-printers-color/" rel="tag">Hp Laser Printers (Color)</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-68			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>25,000</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		<span class="acoplw-badge acoplw-textBlock acoplw-elemBlock "><span class="acoplw-badge-icon acoplw-bseight acoplwRightAlign acoplwPosTop acoplw-custom-badge-62251" style="opacity:1;width:46px;font-size:13px;line-height:px;font-weight: 400;height:46px;transform:rotateX(0deg) rotateY(0deg) rotateZ(0deg);top:0px;bottom:auto;background:rgba(208, 2, 27, 1);"><span class="acoplw-blockText" style="color:rgba(249, 250, 252, 1);">NEW</span></span></span>
				
			</div>
</div>
</div>
					</div>
								</div>
					</div>

							<div class="wd-nav-arrows wd-pos-sep wd-hover-1 wd-icon-1">
			<div class="wd-btn-arrow wd-prev wd-disabled">
				<div class="wd-arrow-inner"></div>
			</div>
			<div class="wd-btn-arrow wd-next">
				<div class="wd-arrow-inner"></div>
			</div>
		</div>
						</div>

									<div class="wd-nav-pagin-wrap text-center wd-style-shape wd-hide-md-sm wd-hide-sm">
			<ul class="wd-nav-pagin"></ul>
		</div>
									</div>
						</div></div></div></div><div class="vc_row wpb_row vc_row-fluid wd-rs-6970ebc29966b"><div class="wpb_column vc_column_container vc_col-sm-12 wd-enabled-flex wd-rs-696fa08f50042"><div class="vc_column-inner"><div class="wpb_wrapper">
		<div id="wd-69ecb24fa1959" class="title-wrapper wd-wpb wd-set-mb reset-last-child  wd-rs-69ecb24fa1959 wd-enabled-width wd-title-color-default wd-title-style-default text-left vc_custom_1777119833065 wd-underline-colored">
			
			<div class="liner-continer">
				<h4 class="woodmart-title-container title  wd-font-weight- wd-fontsize-l" >DOCKING STATIONS</h4>
							</div>
			
			
			
		</div>
		
		<div id="wd-69ecb25f4ac95" class=" wd-rs-69ecb25f4ac95 vc_custom_1777119851005 wd-button-wrapper text-center inline-element"><a href="https://www.mombasacomputers.com/product-category/docking-stations-2/" title="" style="--btn-color:#fff;--btn-color-hover:#fff;" class="btn btn-style-default btn-shape-round btn-size-default btn-icon-pos-right">More products<span class="wd-btn-icon"><img decoding="async"  src="https://www.mombasacomputers.com/wp-content/uploads/2024/10/Icon.svg" title="Icon" loading="lazy" width="12" height="12"></span></a></div>			
			<div id="carousel-689" class="wd-carousel-container  wd-wpb wd-rs-69ecb4d6acae3  wd-products-element wd-products products products-bordered-grid">
				
							
				<div class="wd-carousel-inner">
					<div class=" wd-carousel wd-grid"  data-grid-gallery='{"grid_gallery":"1","grid_gallery_control":"arrows","grid_gallery_enable_arrows":"none"}' data-scroll_per_page="yes" style="--wd-col-lg:5;--wd-col-md:4;--wd-col-sm:2;--wd-gap-lg:20px;--wd-gap-sm:10px;">
						<div class="wd-carousel-wrap">
									<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-58100 status-publish instock product_cat-usb-hubs has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="1" data-id="58100">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/dell-pro-7-in-1-usb-c-multiport-travel-hub-adapter-da310/" class="product-image-link" aria-label="Dell Pro 7-in-1 USB-C Multiport Travel Hub Adapter &#8211; DA310">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310.jpg 2000w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-1-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-1.jpg 2000w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-2-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-2-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-2-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-2-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-2-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-2-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-2.jpg 2000w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-3-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-3-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-3-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-3-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-3-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-3-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-3-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-3-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-3.jpg 2000w" data-image-id="3"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="Dell Pro 7-in-1 USB-C Multiport Travel Hub Adapter - DA310" srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/07/Dell-Pro-7-in-1-USB-C-Multiport-Travel-Hub-Adapter-DA310.jpg 2000w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=58100" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_58100" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="58100" data-product_sku="MCL-838" aria-label="Add to cart: &ldquo;Dell Pro 7-in-1 USB-C Multiport Travel Hub Adapter - DA310&rdquo;" rel="nofollow" data-success_message="&ldquo;Dell Pro 7-in-1 USB-C Multiport Travel Hub Adapter - DA310&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_58100" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/dell-pro-7-in-1-usb-c-multiport-travel-hub-adapter-da310/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="58100"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="58100" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/dell-pro-7-in-1-usb-c-multiport-travel-hub-adapter-da310/">Dell Pro 7-in-1 USB-C Multiport Travel Hub Adapter &#8211; DA310</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/accessories/cables-switchboxes/usb-hubs/" rel="tag">USB Hubs</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-838			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>6,500</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		<span class="acoplw-badge acoplw-textBlock acoplw-elemBlock "><span class="acoplw-badge-icon acoplw-bseight acoplwRightAlign acoplwPosTop acoplw-custom-badge-62251" style="opacity:1;width:46px;font-size:13px;line-height:px;font-weight: 400;height:46px;transform:rotateX(0deg) rotateY(0deg) rotateZ(0deg);top:0px;bottom:auto;background:rgba(208, 2, 27, 1);"><span class="acoplw-blockText" style="color:rgba(249, 250, 252, 1);">NEW</span></span></span>
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-45366 status-publish instock product_cat-usb-hubs has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="2" data-id="45366">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/airsky-6in1-usb-c-hub-card-reader-with-4k-hdmi-port/" class="product-image-link" aria-label="AIRSKY 6In1 Usb-C Hub + Card Reader With 4K HDMI Port">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port.jpg 2000w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-1-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-1.jpg 2000w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-2-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-2-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-2-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-2-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-2-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-2-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-2.jpg 2000w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-3-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-3-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-3-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-3-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-3-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-3-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-3-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-3-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-3.jpg 2000w" data-image-id="3"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-4-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-4-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-4-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-4-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-4-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-4-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-4-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-4-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-4.jpg 2000w" data-image-id="4"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-5-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-5-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-5-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-5-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-5-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-5-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-5-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-5-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-5.jpg 2000w" data-image-id="5"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="AIRSKY 6In1 Usb-C Hub + Card Reader With 4K HDMI Port" srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/AIRSKY-6In1-Usb-C-Hub-Card-Reader-With-4K-HDMI-Port.jpg 2000w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=45366" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_45366" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="45366" data-product_sku="MCL-824" aria-label="Add to cart: &ldquo;AIRSKY 6In1 Usb-C Hub + Card Reader With 4K HDMI Port&rdquo;" rel="nofollow" data-success_message="&ldquo;AIRSKY 6In1 Usb-C Hub + Card Reader With 4K HDMI Port&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_45366" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/airsky-6in1-usb-c-hub-card-reader-with-4k-hdmi-port/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="45366"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="45366" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/airsky-6in1-usb-c-hub-card-reader-with-4k-hdmi-port/">AIRSKY 6In1 Usb-C Hub + Card Reader With 4K HDMI Port</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/accessories/cables-switchboxes/usb-hubs/" rel="tag">USB Hubs</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-824			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>2,500</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		<span class="acoplw-badge acoplw-textBlock acoplw-elemBlock "><span class="acoplw-badge-icon acoplw-bseight acoplwRightAlign acoplwPosTop acoplw-custom-badge-62251" style="opacity:1;width:46px;font-size:13px;line-height:px;font-weight: 400;height:46px;transform:rotateX(0deg) rotateY(0deg) rotateZ(0deg);top:0px;bottom:auto;background:rgba(208, 2, 27, 1);"><span class="acoplw-blockText" style="color:rgba(249, 250, 252, 1);">NEW</span></span></span>
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-45037 status-publish last instock product_cat-usb-hubs has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="3" data-id="45037">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/type-c-to-hdtv-8-in-1-adapter-4k-hdmi-pd-2xusb-sd-tf-rj45-compatible-with-linux-windows-xp-windows-vista-chrome-os-windows-10/" class="product-image-link" aria-label="Type-C to HDTV 8 in 1 Adapter 4K HDMI, PD, 2xUSB, SD/TF, Rj45 Compatible with Linux, Windows XP, Windows Vista, Chrome OS, Windows 10">
			<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2025/06/Type-C-to-HDTV-8-in-1-Adapter-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="Type-C to HDTV 8 in 1 Adapter" srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/06/Type-C-to-HDTV-8-in-1-Adapter-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/Type-C-to-HDTV-8-in-1-Adapter-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/Type-C-to-HDTV-8-in-1-Adapter-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/Type-C-to-HDTV-8-in-1-Adapter-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/Type-C-to-HDTV-8-in-1-Adapter-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/Type-C-to-HDTV-8-in-1-Adapter-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/Type-C-to-HDTV-8-in-1-Adapter-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/Type-C-to-HDTV-8-in-1-Adapter.jpg 2000w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=45037" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_45037" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="45037" data-product_sku="MCL-819" aria-label="Add to cart: &ldquo;Type-C to HDTV 8 in 1 Adapter 4K HDMI, PD, 2xUSB, SD/TF, Rj45 Compatible with Linux, Windows XP, Windows Vista, Chrome OS, Windows 10&rdquo;" rel="nofollow" data-success_message="&ldquo;Type-C to HDTV 8 in 1 Adapter 4K HDMI, PD, 2xUSB, SD/TF, Rj45 Compatible with Linux, Windows XP, Windows Vista, Chrome OS, Windows 10&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_45037" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/type-c-to-hdtv-8-in-1-adapter-4k-hdmi-pd-2xusb-sd-tf-rj45-compatible-with-linux-windows-xp-windows-vista-chrome-os-windows-10/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="45037"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="45037" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/type-c-to-hdtv-8-in-1-adapter-4k-hdmi-pd-2xusb-sd-tf-rj45-compatible-with-linux-windows-xp-windows-vista-chrome-os-windows-10/">Type-C to HDTV 8 in 1 Adapter 4K HDMI, PD, 2xUSB, SD/TF, Rj45 Compatible with Linux, Windows XP, Windows Vista, Chrome OS, Windows 10</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/accessories/cables-switchboxes/usb-hubs/" rel="tag">USB Hubs</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-819			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>2,000</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		<span class="acoplw-badge acoplw-textBlock acoplw-elemBlock "><span class="acoplw-badge-icon acoplw-bseight acoplwRightAlign acoplwPosTop acoplw-custom-badge-62251" style="opacity:1;width:46px;font-size:13px;line-height:px;font-weight: 400;height:46px;transform:rotateX(0deg) rotateY(0deg) rotateZ(0deg);top:0px;bottom:auto;background:rgba(208, 2, 27, 1);"><span class="acoplw-blockText" style="color:rgba(249, 250, 252, 1);">NEW</span></span></span>
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-45002 status-publish first instock product_cat-usb-hubs has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="4" data-id="45002">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/usb-c-hub-usb-c-adapter-11-in-1-dongle-with-4k-hdmi-type-c-pd-vga-usb3-0-rj45-ethernet-sd-tf-card-reader-3-5mm-aux-docking-station-compatible-with-macbook-pro-air-other-type-c-laptops/" class="product-image-link" aria-label="USB C HUB, USB C Adapter 11 in 1 Dongle with 4K HDMI, Type-C PD, VGA, USB3.0, RJ45 Ethernet, SD/TF Card Reader, 3.5mm AUX, Docking Station Compatible with MacBook Pro/Air, Other Type C Laptops">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI.jpg 2000w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-1-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-1.jpg 2000w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-2-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-2-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-2-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-2-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-2-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-2-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-2.jpg 2000w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-3-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-3-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-3-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-3-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-3-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-3-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-3-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-3-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-3.jpg 2000w" data-image-id="3"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-4-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-4-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-4-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-4-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-4-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-4-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-4-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-4-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-4.jpg 2000w" data-image-id="4"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-5-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-5-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-5-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-5-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-5-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-5-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-5-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-5-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-5.jpg 2000w" data-image-id="5"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-6-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-6-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-6-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-6-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-6-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-6-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-6-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-6-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-6.jpg 2000w" data-image-id="6"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-7-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-7-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-7-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-7-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-7-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-7-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-7-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-7-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-7.jpg 2000w" data-image-id="7"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="USB C HUB, USB C Adapter 11 in 1 Dongle with 4K HDMI" srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/06/USB-C-HUB-USB-C-Adapter-11-in-1-Dongle-with-4K-HDMI.jpg 2000w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=45002" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_45002" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="45002" data-product_sku="MCL-817" aria-label="Add to cart: &ldquo;USB C HUB, USB C Adapter 11 in 1 Dongle with 4K HDMI, Type-C PD, VGA, USB3.0, RJ45 Ethernet, SD/TF Card Reader, 3.5mm AUX, Docking Station Compatible with MacBook Pro/Air, Other Type C Laptops&rdquo;" rel="nofollow" data-success_message="&ldquo;USB C HUB, USB C Adapter 11 in 1 Dongle with 4K HDMI, Type-C PD, VGA, USB3.0, RJ45 Ethernet, SD/TF Card Reader, 3.5mm AUX, Docking Station Compatible with MacBook Pro/Air, Other Type C Laptops&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_45002" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/usb-c-hub-usb-c-adapter-11-in-1-dongle-with-4k-hdmi-type-c-pd-vga-usb3-0-rj45-ethernet-sd-tf-card-reader-3-5mm-aux-docking-station-compatible-with-macbook-pro-air-other-type-c-laptops/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="45002"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="45002" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/usb-c-hub-usb-c-adapter-11-in-1-dongle-with-4k-hdmi-type-c-pd-vga-usb3-0-rj45-ethernet-sd-tf-card-reader-3-5mm-aux-docking-station-compatible-with-macbook-pro-air-other-type-c-laptops/">USB C HUB, USB C Adapter 11 in 1 Dongle with 4K HDMI, Type-C PD, VGA, USB3.0, RJ45 Ethernet, SD/TF Card Reader, 3.5mm AUX, Docking Station Compatible with MacBook Pro/Air, Other Type C Laptops</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/accessories/cables-switchboxes/usb-hubs/" rel="tag">USB Hubs</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-817			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>2,700</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		<span class="acoplw-badge acoplw-textBlock acoplw-elemBlock "><span class="acoplw-badge-icon acoplw-bseight acoplwRightAlign acoplwPosTop acoplw-custom-badge-62251" style="opacity:1;width:46px;font-size:13px;line-height:px;font-weight: 400;height:46px;transform:rotateX(0deg) rotateY(0deg) rotateZ(0deg);top:0px;bottom:auto;background:rgba(208, 2, 27, 1);"><span class="acoplw-blockText" style="color:rgba(249, 250, 252, 1);">NEW</span></span></span>
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-44013 status-publish instock product_cat-docking-stations-2 has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="5" data-id="44013">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/hp-usb-c-a-universal-dock-g2-5tw13aa/" class="product-image-link" aria-label="HP USB-C/A Universal Dock G2 (5TW13AA)">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA.jpg 2000w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-1-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-1.jpg 2000w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-2-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-2-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-2-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-2-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-2-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-2-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-2.jpg 2000w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-3-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-3-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-3-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-3-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-3-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-3-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-3-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-3-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-3.jpg 2000w" data-image-id="3"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-4-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-4-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-4-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-4-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-4-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-4-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-4-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-4-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-4.jpg 2000w" data-image-id="4"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="HP USB-C/A Universal Dock G2 (5TW13AA)" srcset="https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2025/05/HP-USB-CA-Universal-Dock-G2-5TW13AA.jpg 2000w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=44013" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_44013" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="44013" data-product_sku="MCL-807" aria-label="Add to cart: &ldquo;HP USB-C/A Universal Dock G2 (5TW13AA)&rdquo;" rel="nofollow" data-success_message="&ldquo;HP USB-C/A Universal Dock G2 (5TW13AA)&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_44013" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/hp-usb-c-a-universal-dock-g2-5tw13aa/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="44013"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="44013" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/hp-usb-c-a-universal-dock-g2-5tw13aa/">HP USB-C/A Universal Dock G2 (5TW13AA)</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/docking-stations-2/" rel="tag">Docking Stations</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-807			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>33,000</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		
				
			</div>
</div>
</div>
					</div>
								</div>
					</div>

							<div class="wd-nav-arrows wd-pos-sep wd-hover-1 wd-icon-1">
			<div class="wd-btn-arrow wd-prev wd-disabled">
				<div class="wd-arrow-inner"></div>
			</div>
			<div class="wd-btn-arrow wd-next">
				<div class="wd-arrow-inner"></div>
			</div>
		</div>
						</div>

									<div class="wd-nav-pagin-wrap text-center wd-style-shape wd-hide-md-sm wd-hide-sm">
			<ul class="wd-nav-pagin"></ul>
		</div>
									</div>
						</div></div></div></div><div class="vc_row wpb_row vc_row-fluid wd-rs-6970ebe4583be"><div class="wpb_column vc_column_container vc_col-sm-12 wd-enabled-flex wd-rs-696fa0c071ac4"><div class="vc_column-inner"><div class="wpb_wrapper">
		<div id="wd-69f5e2bc18280" class="title-wrapper wd-wpb wd-set-mb reset-last-child  wd-rs-69f5e2bc18280 wd-enabled-width wd-title-color-default wd-title-style-default text-left vc_custom_1777722137004 wd-underline-colored">
			
			<div class="liner-continer">
				<h4 class="woodmart-title-container title  wd-font-weight- wd-fontsize-l" >TOP PICKS ON MONITORS</h4>
							</div>
			
			
			
		</div>
		
		<div id="wd-69f5fa656f653" class=" wd-rs-69f5fa656f653 vc_custom_1777728109094 wd-button-wrapper text-center inline-element"><a href="https://www.mombasacomputers.com/product-category/monitors/" title="" style="--btn-color:#fff;--btn-color-hover:#fff;" class="btn btn-style-default btn-shape-round btn-size-default btn-icon-pos-right">More products<span class="wd-btn-icon"><img decoding="async"  src="https://www.mombasacomputers.com/wp-content/uploads/2024/10/Icon.svg" title="Icon" loading="lazy" width="12" height="12"></span></a></div>			
			<div id="carousel-658" class="wd-carousel-container  wd-wpb wd-rs-69f5f9f1613cc  wd-products-element wd-products products products-bordered-grid">
				
							
				<div class="wd-carousel-inner">
					<div class=" wd-carousel wd-grid"  data-grid-gallery='{"grid_gallery":"1","grid_gallery_control":"arrows","grid_gallery_enable_arrows":"none"}' data-scroll_per_page="yes" style="--wd-col-lg:8;--wd-col-md:4;--wd-col-sm:2;--wd-gap-lg:20px;--wd-gap-sm:10px;">
						<div class="wd-carousel-wrap">
									<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-62880 status-publish instock product_cat-monitors has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="1" data-id="62880">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/lenovo-thinkvision-s24i-30-23-8-fhd-monitor/" class="product-image-link" aria-label="Lenovo ThinkVision S24i-30 23.8&#8243; FHD Monitor">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor.jpg 2000w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-1-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-1.jpg 2000w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-2-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-2-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-2-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-2-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-2-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-2-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-2.jpg 2000w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-3-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-3-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-3-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-3-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-3-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-3-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-3-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-3-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-3.jpg 2000w" data-image-id="3"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-4-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-4-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-4-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-4-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-4-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-4-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-4-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-4-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-4.jpg 2000w" data-image-id="4"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-5-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-5-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-5-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-5-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-5-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-5-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-5-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-5-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-5.jpg 2000w" data-image-id="5"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-6-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-6-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-6-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-6-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-6-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-6-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-6-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-6-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-6.jpg 2000w" data-image-id="6"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-7-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-7-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-7-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-7-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-7-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-7-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-7-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-7-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-7.jpg 2000w" data-image-id="7"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-8-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-8-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-8-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-8-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-8-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-8-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-8-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-8-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-8.jpg 2000w" data-image-id="8"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-9-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-9-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-9-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-9-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-9-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-9-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-9-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-9-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-9.jpg 2000w" data-image-id="9"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="Lenovo ThinkVision S24i-30 23.8&quot; FHD Monitor" srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/Lenovo-ThinkVision-S24i-30-23.8-FHD-Monitor.jpg 2000w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=62880" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_62880" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="62880" data-product_sku="MCL-1130" aria-label="Add to cart: &ldquo;Lenovo ThinkVision S24i-30 23.8&quot; FHD Monitor&rdquo;" rel="nofollow" data-success_message="&ldquo;Lenovo ThinkVision S24i-30 23.8&quot; FHD Monitor&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_62880" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/lenovo-thinkvision-s24i-30-23-8-fhd-monitor/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="62880"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="62880" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/lenovo-thinkvision-s24i-30-23-8-fhd-monitor/">Lenovo ThinkVision S24i-30 23.8&#8243; FHD Monitor</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/monitors/" rel="tag">Monitors</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-1130			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>22,000</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-62808 status-publish instock product_cat-monitors has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="2" data-id="62808">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/hp-322pv-series-3-pro-21-45-fhd-lcd-monitor-9u5a2aa/" class="product-image-link" aria-label="HP 322pv Series 3 Pro 21.45&#8243; FHD LCD Monitor (9U5A2AA)">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA.jpg 2000w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-1-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-1.jpg 2000w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-2-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-2-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-2-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-2-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-2-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-2-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-2.jpg 2000w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-3-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-3-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-3-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-3-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-3-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-3-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-3-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-3-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-3.jpg 2000w" data-image-id="3"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-4-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-4-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-4-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-4-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-4-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-4-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-4-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-4-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-4.jpg 2000w" data-image-id="4"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="HP 322pv Series 3 Pro 21.45&quot; FHD LCD Monitor (9U5A2AA)" srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/05/HP-322pv-HP-Series-3-Pro-21.45-FHD-LCD-Monitor-9U5A2AA.jpg 2000w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=62808" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_62808" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="62808" data-product_sku="MCL-1127" aria-label="Add to cart: &ldquo;HP 322pv Series 3 Pro 21.45&quot; FHD LCD Monitor (9U5A2AA)&rdquo;" rel="nofollow" data-success_message="&ldquo;HP 322pv Series 3 Pro 21.45&quot; FHD LCD Monitor (9U5A2AA)&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_62808" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/hp-322pv-series-3-pro-21-45-fhd-lcd-monitor-9u5a2aa/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="62808"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="62808" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/hp-322pv-series-3-pro-21-45-fhd-lcd-monitor-9u5a2aa/">HP 322pv Series 3 Pro 21.45&#8243; FHD LCD Monitor (9U5A2AA)</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/monitors/" rel="tag">Monitors</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-1127			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>19,500</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-62798 status-publish last instock product_cat-monitors has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="3" data-id="62798">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/dell-se2225hm-21-5-inch-full-hd-5ms-va-monitor/" class="product-image-link" aria-label="Dell SE2225HM 21.5-inch Full HD 5ms VA Monitor">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor.jpg 2000w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-1-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-1.jpg 2000w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-4-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-4-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-4-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-4-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-4-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-4-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-4-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-4-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-4.jpg 2000w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-5-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-5-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-5-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-5-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-5-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-5-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-5-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-5-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-5.jpg 2000w" data-image-id="3"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-3-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-3-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-3-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-3-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-3-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-3-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-3-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-3-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-3.jpg 2000w" data-image-id="4"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-6-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-6-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-6-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-6-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-6-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-6-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-6-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-6-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-6.jpg 2000w" data-image-id="5"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="Dell SE2225HM 21.5-inch Full HD 5ms VA Monitor" srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-SE2225HM-21.5-inch-Full-HD-5ms-VA-Monitor.jpg 2000w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=62798" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_62798" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="62798" data-product_sku="MCL-1126" aria-label="Add to cart: &ldquo;Dell SE2225HM 21.5-inch Full HD 5ms VA Monitor&rdquo;" rel="nofollow" data-success_message="&ldquo;Dell SE2225HM 21.5-inch Full HD 5ms VA Monitor&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_62798" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/dell-se2225hm-21-5-inch-full-hd-5ms-va-monitor/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="62798"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="62798" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/dell-se2225hm-21-5-inch-full-hd-5ms-va-monitor/">Dell SE2225HM 21.5-inch Full HD 5ms VA Monitor</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/monitors/" rel="tag">Monitors</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-1126			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>19,500</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-62790 status-publish first instock product_cat-monitors has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="4" data-id="62790">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/dell-e2020h-19-5-inch-led-backlit-monitor/" class="product-image-link" aria-label="Dell E2020H 19.5 Inch LED Backlit Monitor">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor.jpg 2000w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-1-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-1.jpg 2000w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-2-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-2-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-2-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-2-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-2-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-2-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-2.jpg 2000w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-3-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-3-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-3-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-3-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-3-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-3-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-3-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-3-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-3.jpg 2000w" data-image-id="3"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-4-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-4-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-4-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-4-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-4-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-4-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-4-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-4-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-4.jpg 2000w" data-image-id="4"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-5-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-5-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-5-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-5-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-5-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-5-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-5-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-5-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-5.jpg 2000w" data-image-id="5"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="Dell E2020H 19.5 Inch LED Backlit Monitor" srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Dell-E2020H-19.5-Inch-LED-Backlit-Monitor.jpg 2000w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=62790" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_62790" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="62790" data-product_sku="MCL-1125" aria-label="Add to cart: &ldquo;Dell E2020H 19.5 Inch LED Backlit Monitor&rdquo;" rel="nofollow" data-success_message="&ldquo;Dell E2020H 19.5 Inch LED Backlit Monitor&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_62790" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/dell-e2020h-19-5-inch-led-backlit-monitor/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="62790"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="62790" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/dell-e2020h-19-5-inch-led-backlit-monitor/">Dell E2020H 19.5 Inch LED Backlit Monitor</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/monitors/" rel="tag">Monitors</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-1125			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>17,000</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-62675 status-publish instock product_cat-monitors has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="5" data-id="62675">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/lenovo-d19-10-18-5-inch-1366-x-768-pixels-led-hd-monitor/" class="product-image-link" aria-label="Lenovo D19-10 18.5 Inch (1366&#215;768) Pixels LED HD Monitor">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10.jpg 1000w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-1-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-1.jpg 2000w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-2-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-2-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-2-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-2-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-2-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-2-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-2.jpg 2000w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-5-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-5-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-5-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-5-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-5-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-5-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-5-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-5-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-5.jpg 2000w" data-image-id="3"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-4-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-4-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-4-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-4-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-4-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-4-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-4-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-4-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-4.jpg 2000w" data-image-id="4"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-3-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-3-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-3-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-3-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-3-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-3-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-3-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-3-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-3.jpg 2000w" data-image-id="5"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-6-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-6-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-6-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-6-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-6-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-6-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-6-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-6-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-6.jpg 2000w" data-image-id="6"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="Lenovo D19-10 18.5 Inch (1366x768) Pixels LED HD Monitor" srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-D19-10.jpg 1000w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=62675" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_62675" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="62675" data-product_sku="" aria-label="Add to cart: &ldquo;Lenovo D19-10 18.5 Inch (1366x768) Pixels LED HD Monitor&rdquo;" rel="nofollow" data-success_message="&ldquo;Lenovo D19-10 18.5 Inch (1366x768) Pixels LED HD Monitor&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_62675" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/lenovo-d19-10-18-5-inch-1366-x-768-pixels-led-hd-monitor/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="62675"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="62675" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/lenovo-d19-10-18-5-inch-1366-x-768-pixels-led-hd-monitor/">Lenovo D19-10 18.5 Inch (1366&#215;768) Pixels LED HD Monitor</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/monitors/" rel="tag">Monitors</a>		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>13,500</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-62664 status-publish instock product_cat-monitors has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="6" data-id="62664">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/lenovo-l15-15-6-fhd-usb-c-portable-monitor/" class="product-image-link" aria-label="Lenovo L15 15.6&#8243; FHD USB-C Portable Monitor">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-1-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-1.jpg 2000w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor.jpg 2000w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-2-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-2-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-2-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-2-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-2-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-2-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-2.jpg 2000w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-3-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-3-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-3-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-3-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-3-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-3-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-3-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-3-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-3.jpg 2000w" data-image-id="3"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-4-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-4-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-4-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-4-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-4-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-4-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-4-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-4-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-4.jpg 2000w" data-image-id="4"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-5-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-5-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-5-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-5-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-5-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-5-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-5-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-5-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-5.jpg 2000w" data-image-id="5"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-6-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-6-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-6-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-6-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-6-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-6-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-6-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-6-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-6.jpg 2000w" data-image-id="6"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-1-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="Lenovo L15 15.6&quot; FHD USB-C Portable Monitor" srcset="https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-1-1536x1536.jpg 1536w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-1-1200x1200.jpg 1200w, https://www.mombasacomputers.com/wp-content/uploads/2026/04/Lenovo-L15-15.6-FHD-USB-C-Portable-Monitor-1.jpg 2000w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=62664" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_62664" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="62664" data-product_sku="" aria-label="Add to cart: &ldquo;Lenovo L15 15.6&quot; FHD USB-C Portable Monitor&rdquo;" rel="nofollow" data-success_message="&ldquo;Lenovo L15 15.6&quot; FHD USB-C Portable Monitor&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_62664" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/lenovo-l15-15-6-fhd-usb-c-portable-monitor/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="62664"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="62664" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/lenovo-l15-15-6-fhd-usb-c-portable-monitor/">Lenovo L15 15.6&#8243; FHD USB-C Portable Monitor</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/monitors/" rel="tag">Monitors</a>		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>29,999</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		
				
			</div>
</div>
</div>
					</div>
								</div>
					</div>

							<div class="wd-nav-arrows wd-pos-sep wd-hover-1 wd-icon-1">
			<div class="wd-btn-arrow wd-prev wd-disabled">
				<div class="wd-arrow-inner"></div>
			</div>
			<div class="wd-btn-arrow wd-next">
				<div class="wd-arrow-inner"></div>
			</div>
		</div>
						</div>

									<div class="wd-nav-pagin-wrap text-center wd-style-shape wd-hide-md-sm wd-hide-sm">
			<ul class="wd-nav-pagin"></ul>
		</div>
									</div>
						</div></div></div></div><div class="vc_row wpb_row vc_row-fluid wd-rs-6970ebf06c263"><div class="wpb_column vc_column_container vc_col-sm-12 wd-enabled-flex wd-rs-696f9cadc684a"><div class="vc_column-inner"><div class="wpb_wrapper">
		<div id="wd-69ecaf9d0468f" class="title-wrapper wd-wpb wd-set-mb reset-last-child  wd-rs-69ecaf9d0468f wd-enabled-width wd-title-color-default wd-title-style-default text-left vc_custom_1777119158076 wd-underline-colored">
			
			<div class="liner-continer">
				<h4 class="woodmart-title-container title  wd-font-weight- wd-fontsize-l" >UPS</h4>
							</div>
			
			
			
		</div>
		
		<div id="wd-69ecb534f2cb3" class=" wd-rs-69ecb534f2cb3 vc_custom_1777120596146 wd-button-wrapper text-center inline-element"><a href="https://www.mombasacomputers.com/product-category/power-protection/ups-systems/" title="" style="--btn-color:#fff;--btn-color-hover:#fff;" class="btn btn-style-default btn-shape-round btn-size-default btn-icon-pos-right">More products<span class="wd-btn-icon"><img decoding="async"  src="https://www.mombasacomputers.com/wp-content/uploads/2024/10/Icon.svg" title="Icon" loading="lazy" width="12" height="12"></span></a></div>			
			<div id="carousel-732" class="wd-carousel-container  wd-wpb wd-rs-69ecb558ecc40  wd-products-element wd-products products products-bordered-grid">
				
							
				<div class="wd-carousel-inner">
					<div class=" wd-carousel wd-grid"  data-grid-gallery='{"grid_gallery":"1","grid_gallery_control":"arrows","grid_gallery_enable_arrows":"none"}' data-scroll_per_page="yes" style="--wd-col-lg:5;--wd-col-md:4;--wd-col-sm:2;--wd-gap-lg:20px;--wd-gap-sm:10px;">
						<div class="wd-carousel-wrap">
									<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-29089 status-publish instock product_cat-ups-systems has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="1" data-id="29089">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/apc-smart-ups-c-line-interactive-1000va-smc1000i-2ucrack-mount-2u-230v-4x-iec-c13-outlets/" class="product-image-link" aria-label="APC Smart-UPS C, Line Interactive, 1000VA SMC1000I-2UC,Rack Mount 2U, 230V, 4x IEC C13 outlets">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets.jpg 1200w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-2-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-2-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-2-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-2-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-2.jpg 1200w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-3-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-3-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-3-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-3-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-3-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-3-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-3.jpg 1200w" data-image-id="2"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-4-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-4-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-4-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-4-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-4-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-4-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-4-1.jpg 1200w" data-image-id="3"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-4-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-4-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-4-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-4-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-4-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-4-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-4.jpg 1200w" data-image-id="4"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="APC Smart-UPS C, Line Interactive, 1000VA SMC1000I-2UC,Rack Mount 2U, 230V, 4x IEC C13 outlets" srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/10/APC-Smart-UPS-C-Line-Interactive-1000VA-SMC1000I-2UCRack-Mount-2U-230V-4x-IEC-C13-outlets.jpg 1200w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=29089" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_29089" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="29089" data-product_sku="MCL-550" aria-label="Add to cart: &ldquo;APC Smart-UPS C, Line Interactive, 1000VA SMC1000I-2UC,Rack Mount 2U, 230V, 4x IEC C13 outlets&rdquo;" rel="nofollow" data-success_message="&ldquo;APC Smart-UPS C, Line Interactive, 1000VA SMC1000I-2UC,Rack Mount 2U, 230V, 4x IEC C13 outlets&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_29089" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/apc-smart-ups-c-line-interactive-1000va-smc1000i-2ucrack-mount-2u-230v-4x-iec-c13-outlets/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="29089"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="29089" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/apc-smart-ups-c-line-interactive-1000va-smc1000i-2ucrack-mount-2u-230v-4x-iec-c13-outlets/">APC Smart-UPS C, Line Interactive, 1000VA SMC1000I-2UC,Rack Mount 2U, 230V, 4x IEC C13 outlets</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/power-protection/ups-systems/" rel="tag">UPS Systems</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-550			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>100,000</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		<span class="acoplw-badge acoplw-textBlock acoplw-elemBlock "><span class="acoplw-badge-icon acoplw-bseight acoplwRightAlign acoplwPosTop acoplw-custom-badge-62251" style="opacity:1;width:46px;font-size:13px;line-height:px;font-weight: 400;height:46px;transform:rotateX(0deg) rotateY(0deg) rotateZ(0deg);top:0px;bottom:auto;background:rgba(208, 2, 27, 1);"><span class="acoplw-blockText" style="color:rgba(249, 250, 252, 1);">NEW</span></span></span>
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-27248 status-publish instock product_cat-ups-systems has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="2" data-id="27248">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/eaton-5e-essential-ups-1100va-5e1100iusb-sea-battery-backup/" class="product-image-link" aria-label="EATON 5E Essential UPS 1100Va 5E1100IUSB-SEA Battery Backup">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/04/5E1100IUSB-SEA2-600x600.jpeg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/04/5E1100IUSB-SEA2-600x600.jpeg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/5E1100IUSB-SEA2-300x300.jpeg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/5E1100IUSB-SEA2-150x150.jpeg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/5E1100IUSB-SEA2-768x768.jpeg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/5E1100IUSB-SEA2.jpeg 1000w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/04/5E1100IUSB-SEA-600x600.jpeg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/04/5E1100IUSB-SEA-600x600.jpeg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/5E1100IUSB-SEA-300x300.jpeg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/5E1100IUSB-SEA-150x150.jpeg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/5E1100IUSB-SEA-768x768.jpeg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/5E1100IUSB-SEA.jpeg 1000w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2023/04/5E1100IUSB-SEA-1-600x600.jpeg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/04/5E1100IUSB-SEA-1-600x600.jpeg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/5E1100IUSB-SEA-1-300x300.jpeg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/5E1100IUSB-SEA-1-150x150.jpeg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/5E1100IUSB-SEA-1-768x768.jpeg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/5E1100IUSB-SEA-1.jpeg 1000w" data-image-id="2"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2023/04/5E1100IUSB-SEA2-600x600.jpeg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="EATON 5E Essential UPS 1100Va 5E1100IUSB-SEA Battery Backup" srcset="https://www.mombasacomputers.com/wp-content/uploads/2023/04/5E1100IUSB-SEA2-600x600.jpeg 600w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/5E1100IUSB-SEA2-300x300.jpeg 300w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/5E1100IUSB-SEA2-150x150.jpeg 150w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/5E1100IUSB-SEA2-768x768.jpeg 768w, https://www.mombasacomputers.com/wp-content/uploads/2023/04/5E1100IUSB-SEA2.jpeg 1000w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=27248" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_27248" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="27248" data-product_sku="MCL-443" aria-label="Add to cart: &ldquo;EATON 5E Essential UPS 1100Va 5E1100IUSB-SEA Battery Backup&rdquo;" rel="nofollow" data-success_message="&ldquo;EATON 5E Essential UPS 1100Va 5E1100IUSB-SEA Battery Backup&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_27248" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/eaton-5e-essential-ups-1100va-5e1100iusb-sea-battery-backup/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="27248"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="27248" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/eaton-5e-essential-ups-1100va-5e1100iusb-sea-battery-backup/">EATON 5E Essential UPS 1100Va 5E1100IUSB-SEA Battery Backup</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/power-protection/ups-systems/" rel="tag">UPS Systems</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-443			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>18,500</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		<span class="acoplw-badge acoplw-textBlock acoplw-elemBlock "><span class="acoplw-badge-icon acoplw-bseight acoplwRightAlign acoplwPosTop acoplw-custom-badge-62251" style="opacity:1;width:46px;font-size:13px;line-height:px;font-weight: 400;height:46px;transform:rotateX(0deg) rotateY(0deg) rotateZ(0deg);top:0px;bottom:auto;background:rgba(208, 2, 27, 1);"><span class="acoplw-blockText" style="color:rgba(249, 250, 252, 1);">NEW</span></span></span>
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-with-labels wd-hover-tiled product-grid-item product type-product post-25465 status-publish last instock product_cat-ups-systems has-post-thumbnail sale taxable shipping-taxable purchasable product-type-simple" data-loop="3" data-id="25465">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/apc-easy-ups-on-line-srv-3000va-2400-watts-srv3kri/" class="product-image-link" aria-label="APC Easy UPS On-Line SRV 3000VA / 2400 Watts (SRV3KRI)">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2022/06/APC-Easy-UPS-On-Line-SRV-3000VA-2400-Watts-SRV3KRI-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2022/06/APC-Easy-UPS-On-Line-SRV-3000VA-2400-Watts-SRV3KRI-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2022/06/APC-Easy-UPS-On-Line-SRV-3000VA-2400-Watts-SRV3KRI-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2022/06/APC-Easy-UPS-On-Line-SRV-3000VA-2400-Watts-SRV3KRI-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2022/06/APC-Easy-UPS-On-Line-SRV-3000VA-2400-Watts-SRV3KRI-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2022/06/APC-Easy-UPS-On-Line-SRV-3000VA-2400-Watts-SRV3KRI-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2022/06/APC-Easy-UPS-On-Line-SRV-3000VA-2400-Watts-SRV3KRI-100x100.jpg 100w, https://www.mombasacomputers.com/wp-content/uploads/2022/06/APC-Easy-UPS-On-Line-SRV-3000VA-2400-Watts-SRV3KRI.jpg 1200w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2022/06/APC-Easy-UPS-On-Line-SRV-3000VA-2400-Watts-SRV3KRI-2-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2022/06/APC-Easy-UPS-On-Line-SRV-3000VA-2400-Watts-SRV3KRI-2-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2022/06/APC-Easy-UPS-On-Line-SRV-3000VA-2400-Watts-SRV3KRI-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2022/06/APC-Easy-UPS-On-Line-SRV-3000VA-2400-Watts-SRV3KRI-2-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2022/06/APC-Easy-UPS-On-Line-SRV-3000VA-2400-Watts-SRV3KRI-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2022/06/APC-Easy-UPS-On-Line-SRV-3000VA-2400-Watts-SRV3KRI-2-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2022/06/APC-Easy-UPS-On-Line-SRV-3000VA-2400-Watts-SRV3KRI-2-100x100.jpg 100w, https://www.mombasacomputers.com/wp-content/uploads/2022/06/APC-Easy-UPS-On-Line-SRV-3000VA-2400-Watts-SRV3KRI-2.jpg 1200w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2022/06/APC-Easy-UPS-On-Line-SRV-3000VA-2400-Watts-SRV3KRI-1-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2022/06/APC-Easy-UPS-On-Line-SRV-3000VA-2400-Watts-SRV3KRI-1-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2022/06/APC-Easy-UPS-On-Line-SRV-3000VA-2400-Watts-SRV3KRI-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2022/06/APC-Easy-UPS-On-Line-SRV-3000VA-2400-Watts-SRV3KRI-1-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2022/06/APC-Easy-UPS-On-Line-SRV-3000VA-2400-Watts-SRV3KRI-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2022/06/APC-Easy-UPS-On-Line-SRV-3000VA-2400-Watts-SRV3KRI-1-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2022/06/APC-Easy-UPS-On-Line-SRV-3000VA-2400-Watts-SRV3KRI-1-100x100.jpg 100w, https://www.mombasacomputers.com/wp-content/uploads/2022/06/APC-Easy-UPS-On-Line-SRV-3000VA-2400-Watts-SRV3KRI-1.jpg 1200w" data-image-id="2"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<div class="product-labels labels-rounded"><span class="onsale product-label">-15%</span></div><img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2022/06/APC-Easy-UPS-On-Line-SRV-3000VA-2400-Watts-SRV3KRI-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="APC Easy UPS On-Line SRV 3000VA / 2400 Watts (SRV3KRI)" srcset="https://www.mombasacomputers.com/wp-content/uploads/2022/06/APC-Easy-UPS-On-Line-SRV-3000VA-2400-Watts-SRV3KRI-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2022/06/APC-Easy-UPS-On-Line-SRV-3000VA-2400-Watts-SRV3KRI-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2022/06/APC-Easy-UPS-On-Line-SRV-3000VA-2400-Watts-SRV3KRI-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2022/06/APC-Easy-UPS-On-Line-SRV-3000VA-2400-Watts-SRV3KRI-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2022/06/APC-Easy-UPS-On-Line-SRV-3000VA-2400-Watts-SRV3KRI-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2022/06/APC-Easy-UPS-On-Line-SRV-3000VA-2400-Watts-SRV3KRI-100x100.jpg 100w, https://www.mombasacomputers.com/wp-content/uploads/2022/06/APC-Easy-UPS-On-Line-SRV-3000VA-2400-Watts-SRV3KRI.jpg 1200w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=25465" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_25465" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="25465" data-product_sku="MCL-365" aria-label="Add to cart: &ldquo;APC Easy UPS On-Line SRV 3000VA / 2400 Watts (SRV3KRI)&rdquo;" rel="nofollow" data-success_message="&ldquo;APC Easy UPS On-Line SRV 3000VA / 2400 Watts (SRV3KRI)&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_25465" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/apc-easy-ups-on-line-srv-3000va-2400-watts-srv3kri/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="25465"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="25465" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/apc-easy-ups-on-line-srv-3000va-2400-watts-srv3kri/">APC Easy UPS On-Line SRV 3000VA / 2400 Watts (SRV3KRI)</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/power-protection/ups-systems/" rel="tag">UPS Systems</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-365			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><del aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>195,000</bdi></span></del> <span class="screen-reader-text">Original price was: KSh195,000.</span><ins aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>165,000</bdi></span></ins><span class="screen-reader-text">Current price is: KSh165,000.</span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		<span class="acoplw-badge acoplw-textBlock acoplw-elemBlock "><span class="acoplw-badge-icon acoplw-bseight acoplwRightAlign acoplwPosTop acoplw-custom-badge-62251" style="opacity:1;width:46px;font-size:13px;line-height:px;font-weight: 400;height:46px;transform:rotateX(0deg) rotateY(0deg) rotateZ(0deg);top:0px;bottom:auto;background:rgba(208, 2, 27, 1);"><span class="acoplw-blockText" style="color:rgba(249, 250, 252, 1);">NEW</span></span></span>
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-21540 status-publish first instock product_cat-ups-systems has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="4" data-id="21540">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/mercury-maverick-1550va-ups/" class="product-image-link" aria-label="Mercury Maverick 1550VA UPS">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2022/02/Mercury-maverick-1550VA-UPS-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2022/02/Mercury-maverick-1550VA-UPS-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Mercury-maverick-1550VA-UPS-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Mercury-maverick-1550VA-UPS-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Mercury-maverick-1550VA-UPS-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Mercury-maverick-1550VA-UPS-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Mercury-maverick-1550VA-UPS-370x370.jpg 370w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Mercury-maverick-1550VA-UPS-100x100.jpg 100w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Mercury-maverick-1550VA-UPS.jpg 1200w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2022/02/Mercury-maverick-1550VA-UPS-2-600x600.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2022/02/Mercury-maverick-1550VA-UPS-2-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Mercury-maverick-1550VA-UPS-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Mercury-maverick-1550VA-UPS-2-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Mercury-maverick-1550VA-UPS-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Mercury-maverick-1550VA-UPS-2-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Mercury-maverick-1550VA-UPS-2-370x370.jpg 370w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Mercury-maverick-1550VA-UPS-2-100x100.jpg 100w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Mercury-maverick-1550VA-UPS-2.jpg 1200w" data-image-id="1"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2022/02/Mercury-maverick-1550VA-UPS-600x600.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="Mercury maverick 1550VA UPS" srcset="https://www.mombasacomputers.com/wp-content/uploads/2022/02/Mercury-maverick-1550VA-UPS-600x600.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Mercury-maverick-1550VA-UPS-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Mercury-maverick-1550VA-UPS-1024x1024.jpg 1024w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Mercury-maverick-1550VA-UPS-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Mercury-maverick-1550VA-UPS-768x768.jpg 768w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Mercury-maverick-1550VA-UPS-370x370.jpg 370w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Mercury-maverick-1550VA-UPS-100x100.jpg 100w, https://www.mombasacomputers.com/wp-content/uploads/2022/02/Mercury-maverick-1550VA-UPS.jpg 1200w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=21540" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_21540" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="21540" data-product_sku="MCL-283" aria-label="Add to cart: &ldquo;Mercury Maverick 1550VA UPS&rdquo;" rel="nofollow" data-success_message="&ldquo;Mercury Maverick 1550VA UPS&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_21540" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/mercury-maverick-1550va-ups/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="21540"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="21540" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/mercury-maverick-1550va-ups/">Mercury Maverick 1550VA UPS</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/power-protection/ups-systems/" rel="tag">UPS Systems</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-283			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>15,000</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		<span class="acoplw-badge acoplw-textBlock acoplw-elemBlock "><span class="acoplw-badge-icon acoplw-bseight acoplwRightAlign acoplwPosTop acoplw-custom-badge-62251" style="opacity:1;width:46px;font-size:13px;line-height:px;font-weight: 400;height:46px;transform:rotateX(0deg) rotateY(0deg) rotateZ(0deg);top:0px;bottom:auto;background:rgba(208, 2, 27, 1);"><span class="acoplw-blockText" style="color:rgba(249, 250, 252, 1);">NEW</span></span></span>
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-18050 status-publish instock product_cat-ups-systems has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="5" data-id="18050">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/apc-easy-ups-bv-650va-avr-universal-outlet-230v/" class="product-image-link" aria-label="APC EASY UPS BV 650VA, AVR, Universal Outlet, 230V">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2020/11/APC-EASY-UPS-BV-650VA-AVR-Universal-Outlet-230V.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2020/11/APC-EASY-UPS-BV-650VA-AVR-Universal-Outlet-230V.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2020/11/APC-EASY-UPS-BV-650VA-AVR-Universal-Outlet-230V-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2020/11/APC-EASY-UPS-BV-650VA-AVR-Universal-Outlet-230V-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2020/11/APC-EASY-UPS-BV-650VA-AVR-Universal-Outlet-230V-370x370.jpg 370w, https://www.mombasacomputers.com/wp-content/uploads/2020/11/APC-EASY-UPS-BV-650VA-AVR-Universal-Outlet-230V-100x100.jpg 100w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2020/11/APC-EASY-UPS-BV-650VA-AVR-Universal-Outlet-230V-1.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2020/11/APC-EASY-UPS-BV-650VA-AVR-Universal-Outlet-230V-1.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2020/11/APC-EASY-UPS-BV-650VA-AVR-Universal-Outlet-230V-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2020/11/APC-EASY-UPS-BV-650VA-AVR-Universal-Outlet-230V-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2020/11/APC-EASY-UPS-BV-650VA-AVR-Universal-Outlet-230V-1-370x370.jpg 370w, https://www.mombasacomputers.com/wp-content/uploads/2020/11/APC-EASY-UPS-BV-650VA-AVR-Universal-Outlet-230V-1-100x100.jpg 100w" data-image-id="1"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2020/11/APC-EASY-UPS-BV-650VA-AVR-Universal-Outlet-230V-2.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2020/11/APC-EASY-UPS-BV-650VA-AVR-Universal-Outlet-230V-2.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2020/11/APC-EASY-UPS-BV-650VA-AVR-Universal-Outlet-230V-2-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2020/11/APC-EASY-UPS-BV-650VA-AVR-Universal-Outlet-230V-2-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2020/11/APC-EASY-UPS-BV-650VA-AVR-Universal-Outlet-230V-2-370x370.jpg 370w, https://www.mombasacomputers.com/wp-content/uploads/2020/11/APC-EASY-UPS-BV-650VA-AVR-Universal-Outlet-230V-2-100x100.jpg 100w" data-image-id="2"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2020/11/APC-EASY-UPS-BV-650VA-AVR-Universal-Outlet-230V.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="APC EASY UPS BV 650VA, AVR, Universal Outlet, 230V" srcset="https://www.mombasacomputers.com/wp-content/uploads/2020/11/APC-EASY-UPS-BV-650VA-AVR-Universal-Outlet-230V.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2020/11/APC-EASY-UPS-BV-650VA-AVR-Universal-Outlet-230V-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2020/11/APC-EASY-UPS-BV-650VA-AVR-Universal-Outlet-230V-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2020/11/APC-EASY-UPS-BV-650VA-AVR-Universal-Outlet-230V-370x370.jpg 370w, https://www.mombasacomputers.com/wp-content/uploads/2020/11/APC-EASY-UPS-BV-650VA-AVR-Universal-Outlet-230V-100x100.jpg 100w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=18050" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_18050" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="18050" data-product_sku="MCL-174" aria-label="Add to cart: &ldquo;APC EASY UPS BV 650VA, AVR, Universal Outlet, 230V&rdquo;" rel="nofollow" data-success_message="&ldquo;APC EASY UPS BV 650VA, AVR, Universal Outlet, 230V&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_18050" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/apc-easy-ups-bv-650va-avr-universal-outlet-230v/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="18050"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="18050" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/apc-easy-ups-bv-650va-avr-universal-outlet-230v/">APC EASY UPS BV 650VA, AVR, Universal Outlet, 230V</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/power-protection/ups-systems/" rel="tag">UPS Systems</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-174			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>11,000</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		<span class="acoplw-badge acoplw-textBlock acoplw-elemBlock "><span class="acoplw-badge-icon acoplw-bseight acoplwRightAlign acoplwPosTop acoplw-custom-badge-62251" style="opacity:1;width:46px;font-size:13px;line-height:px;font-weight: 400;height:46px;transform:rotateX(0deg) rotateY(0deg) rotateZ(0deg);top:0px;bottom:auto;background:rgba(208, 2, 27, 1);"><span class="acoplw-blockText" style="color:rgba(249, 250, 252, 1);">NEW</span></span></span>
				
			</div>
</div>
</div>
					</div>
				<div class="wd-carousel-item">
											<div class="wd-product wd-hover-tiled product-grid-item product type-product post-13690 status-publish instock product_cat-ups-systems has-post-thumbnail taxable shipping-taxable purchasable product-type-simple" data-loop="6" data-id="13690">
				
	
<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="https://www.mombasacomputers.com/product/mecer-650va-line-interactive-ups-me-650-vu/" class="product-image-link" aria-label="MECER 650VA Line Interactive UPS (ME-650-VU)">
					<div class="wd-product-grid-slider wd-fill">
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2020/06/MECER-650VA-Line-Interactive-UPS-ME-650-VU.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2020/06/MECER-650VA-Line-Interactive-UPS-ME-650-VU.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2020/06/MECER-650VA-Line-Interactive-UPS-ME-650-VU-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2020/06/MECER-650VA-Line-Interactive-UPS-ME-650-VU-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2020/06/MECER-650VA-Line-Interactive-UPS-ME-650-VU-370x370.jpg 370w, https://www.mombasacomputers.com/wp-content/uploads/2020/06/MECER-650VA-Line-Interactive-UPS-ME-650-VU-100x100.jpg 100w" data-image-id="0"></div>
							<div class="wd-product-grid-slide" data-image-url="https://www.mombasacomputers.com/wp-content/uploads/2020/06/MECER-650VA-Line-Interactive-UPS-ME-650-VU-1.jpg" data-image-srcset="https://www.mombasacomputers.com/wp-content/uploads/2020/06/MECER-650VA-Line-Interactive-UPS-ME-650-VU-1.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2020/06/MECER-650VA-Line-Interactive-UPS-ME-650-VU-1-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2020/06/MECER-650VA-Line-Interactive-UPS-ME-650-VU-1-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2020/06/MECER-650VA-Line-Interactive-UPS-ME-650-VU-1-370x370.jpg 370w, https://www.mombasacomputers.com/wp-content/uploads/2020/06/MECER-650VA-Line-Interactive-UPS-ME-650-VU-1-100x100.jpg 100w" data-image-id="1"></div>
					</div>

					<div class="wd-product-grid-slider-nav wd-fill wd-hide-md">
				<div class="wd-prev"></div>
				<div class="wd-next"></div>
			</div>
		
									<img loading="lazy" decoding="async" width="600" height="600" src="https://www.mombasacomputers.com/wp-content/uploads/2020/06/MECER-650VA-Line-Interactive-UPS-ME-650-VU.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="MECER 650VA Line Interactive UPS (ME-650-VU)" srcset="https://www.mombasacomputers.com/wp-content/uploads/2020/06/MECER-650VA-Line-Interactive-UPS-ME-650-VU.jpg 600w, https://www.mombasacomputers.com/wp-content/uploads/2020/06/MECER-650VA-Line-Interactive-UPS-ME-650-VU-300x300.jpg 300w, https://www.mombasacomputers.com/wp-content/uploads/2020/06/MECER-650VA-Line-Interactive-UPS-ME-650-VU-150x150.jpg 150w, https://www.mombasacomputers.com/wp-content/uploads/2020/06/MECER-650VA-Line-Interactive-UPS-ME-650-VU-370x370.jpg 370w, https://www.mombasacomputers.com/wp-content/uploads/2020/06/MECER-650VA-Line-Interactive-UPS-ME-650-VU-100x100.jpg 100w" sizes="auto, (max-width: 600px) 100vw, 600px" />		</a>

		
		<div class="wd-buttons wd-pos-r-t">
						<div class="wd-add-btn wd-action-btn wd-style-icon wd-add-cart-icon"><a href="/?add-to-cart=13690" aria-describedby="woocommerce_loop_add_to_cart_link_describedby_13690" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart add-to-cart-loop" data-product_id="13690" data-product_sku="MCL-28" aria-label="Add to cart: &ldquo;MECER 650VA Line Interactive UPS (ME-650-VU)&rdquo;" rel="nofollow" data-success_message="&ldquo;MECER 650VA Line Interactive UPS (ME-650-VU)&rdquo; has been added to your cart" role="button"><span>Add to cart</span></a>	<span id="woocommerce_loop_add_to_cart_link_describedby_13690" class="screen-reader-text">
			</span>
</div>
					<div class="quick-view wd-action-btn wd-style-icon wd-quick-view-icon">
			<a
				href="https://www.mombasacomputers.com/product/mecer-650va-line-interactive-ups-me-650-vu/"
				class="open-quick-view quick-view-button"
				rel="nofollow"
				data-id="13690"
				>Quick view</a>
		</div>
											<div class="wd-wishlist-btn wd-action-btn wd-style-icon wd-wishlist-icon">
				<a class="" href="https://www.mombasacomputers.com/wishlist-6/" data-key="c4c129602e" data-product-id="13690" rel="nofollow" data-added-text="Browse Wishlist">
					<span>Add to wishlist</span>
				</a>
			</div>
				</div>
	</div>

	<div class="product-element-bottom">
		<h3 class="wd-entities-title"><a href="https://www.mombasacomputers.com/product/mecer-650va-line-interactive-ups-me-650-vu/">MECER 650VA Line Interactive UPS (ME-650-VU)</a></h3>				<div class="wd-product-cats">
			<a href="https://www.mombasacomputers.com/product-category/power-protection/ups-systems/" rel="tag">UPS Systems</a>		</div>
				<div class="wd-product-detail wd-product-sku">
			<span class="wd-label">
				SKU:			</span>
			<span>
				MCL-28			</span>
		</div>
														<div class="wd-star-rating">
		
				<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
					<span style="width:0%">
			Rated <strong class="rating">0</strong> out of 5		</span>
				</div>

		
					</div>
										
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">KSh</span>8,500</bdi></span> <small class="woocommerce-price-suffix">(ex VAT)</small></span>

		<span class="acoplw-badge acoplw-textBlock acoplw-elemBlock "><span class="acoplw-badge-icon acoplw-bseight acoplwRightAlign acoplwPosTop acoplw-custom-badge-62251" style="opacity:1;width:46px;font-size:13px;line-height:px;font-weight: 400;height:46px;transform:rotateX(0deg) rotateY(0deg) rotateZ(0deg);top:0px;bottom:auto;background:rgba(208, 2, 27, 1);"><span class="acoplw-blockText" style="color:rgba(249, 250, 252, 1);">NEW</span></span></span>
				
			</div>
</div>
</div>
					</div>
								</div>
					</div>

							<div class="wd-nav-arrows wd-pos-sep wd-hover-1 wd-icon-1">
			<div class="wd-btn-arrow wd-prev wd-disabled">
				<div class="wd-arrow-inner"></div>
			</div>
			<div class="wd-btn-arrow wd-next">
				<div class="wd-arrow-inner"></div>
			</div>
		</div>
						</div>

									<div class="wd-nav-pagin-wrap text-center wd-style-shape wd-hide-md-sm wd-hide-sm">
			<ul class="wd-nav-pagin"></ul>
		</div>
									</div>
						</div></div></div></div>
</div>
					
									</article>

				
		
</div>



			</main>
		
</div>
							<footer class="wd-footer footer-container color-scheme-light">
																				<div class="container main-footer wd-entry-content">
							<style data-type="vc_shortcodes-custom-css">.vc_custom_1729770829316{padding-top: 40px !important;}.vc_custom_1729772889631{margin-right: 0px !important;margin-bottom: 20px !important;margin-left: 0px !important;background-color: #000000 !important;border-radius: 10px !important;}.vc_custom_1729772649562{padding-top: 0px !important;padding-right: 0px !important;padding-left: 0px !important;}.vc_custom_1729772787246{border-top-width: 0px !important;border-left-width: 1px !important;padding-top: 0px !important;padding-right: 0px !important;padding-left: 0px !important;border-left-style: solid !important;border-top-style: solid !important;border-color: #FFFFFF4D !important;}.vc_custom_1768969798453{padding-top: 40px !important;padding-right: 40px !important;padding-bottom: 10px !important;padding-left: 40px !important;}.vc_custom_1768969162388{margin-bottom: 20px !important;}.vc_custom_1768992432278{margin-bottom: 20px !important;}.vc_custom_1768969653950{margin-bottom: 20px !important;}.vc_custom_1729771831497{margin-bottom: 20px !important;}.vc_custom_1729772930067{padding-top: 40px !important;padding-right: 40px !important;padding-bottom: 40px !important;padding-left: 40px !important;}.vc_custom_1729772943341{padding-top: 0px !important;}.vc_custom_1729772152782{margin-right: 0px !important;margin-bottom: 20px !important;}.vc_custom_1729772145060{margin-bottom: 20px !important;}.vc_custom_1730126760211{margin-bottom: 20px !important;}.vc_custom_1768970113302{margin-bottom: 20px !important;}.vc_custom_1729771206856{padding-top: 0px !important;}.vc_custom_1729771184434{margin-bottom: 20px !important;}.vc_custom_1729867120286{margin-bottom: 20px !important;}.wd-rs-671a3a7448833{width: auto !important;max-width: auto !important;}.wd-rs-671a3a5f28e71{width: auto !important;max-width: auto !important;}.wd-rs-671fa390e2406{--wd-brd-radius: 0px;}.wd-rs-671a36c46878a > .vc_column-inner > .wpb_wrapper{align-items: center;justify-content: space-between}.wd-rs-671bad6aa2119{width: auto !important;max-width: auto !important;}#wd-697053afd102e{--wd-max-width:280px;}#wd-6970aea72cfc7{--wd-max-width:280px;}#wd-671b824d5f363 li{color:rgba(255,255,255,0.8);}#wd-671b824d5f363 li:hover{color:#ffffff;}#wd-671a3a7448833 .woodmart-title-container{font-size:42px;line-height:42px;}#wd-671a3a5f28e71 .woodmart-title-container{font-size:22px;line-height:22px;}@media (max-width: 767px) {html .wd-rs-671a3ce90846b > .vc_column-inner{border-top-width:1px !important;border-left-width:0px !important;}html .wd-rs-6970563b62454{padding-top:20px !important;padding-right:20px !important;padding-bottom:20px !important;padding-left:20px !important;}html .wd-rs-671b824d5f363{margin-bottom:0px !important;}html .wd-rs-671a3d777a189{padding-top:20px !important;padding-right:20px !important;padding-bottom:20px !important;padding-left:20px !important;}}</style><div class="wpb-content-wrapper"><section class="vc_section vc_custom_1729770829316 wd-rs-671a354245673"><div class="vc_row wpb_row vc_row-fluid vc_custom_1729772889631 vc_row-has-fill vc_row-o-equal-height vc_row-flex wd-rs-671a3d52afc2d"><div class="wpb_column vc_column_container vc_col-sm-8 vc_col-lg-9 wd-rs-671a3c5e34532"><div class="vc_column-inner vc_custom_1729772649562"><div class="wpb_wrapper"><div class="vc_row wpb_row vc_inner vc_row-fluid vc_custom_1768969798453 wd-rs-6970563b62454"><div class="wpb_column vc_column_container vc_col-sm-12 vc_col-lg-3 wd-rs-671a3c6bae4c2"><div class="vc_column-inner"><div class="wpb_wrapper">		<div id="wd-697053afd102e" class="wd-text-block wd-wpb reset-last-child wd-rs-697053afd102e text-left wd-width-custom vc_custom_1768969162388">
			<p><strong>MOI AVENUE</strong></p>
<p>Moi Avenue opposite Veteran House next to Bihi Towers</p>
<p>+254 111 040 400 or +254 792 792 750</p>
<p>P. O Box 37940, 00100</p>
<p><a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="ef9c8e838a9caf8280828d8e9c8e8c80829f9a9b8a9d9cc18c8082">[email&#160;protected]</a><br />
<a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="a2cbccd3d7cbd0cbc7d1e2cfcdcfc0c3d1c3c1cdcfd2d7d6c7d0d18cc1cdcf">[email&#160;protected]</a></p>
		</div>
		</div></div></div><div class="wpb_column vc_column_container vc_col-sm-4 vc_col-lg-offset-1 vc_col-lg-3 wd-rs-69705673cb84d"><div class="vc_column-inner"><div class="wpb_wrapper">		<div id="wd-6970aea72cfc7" class="wd-text-block wd-wpb reset-last-child wd-rs-6970aea72cfc7 text-left wd-width-custom vc_custom_1768992432278">
			<p><strong>KIMATHI STREET</strong></p>
<p>Kimathi Street next to Safaricom shop &amp; Cooperative Bank</p>
<p>+254 111 040 400 or +254 792 792 750</p>
<p>P. O Box 37940, 00100</p>
<p><a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="3d4e5c51584e7d5052505f5c4e5c5e52504d4849584f4e135e5250">[email&#160;protected]</a><br />
<a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="a5cccbd4d0ccd7ccc0d6e5c8cac8c7c4d6c4c6cac8d5d0d1c0d7d68bc6cac8">[email&#160;protected]</a></p>
		</div>
		</div></div></div><div class="wpb_column vc_column_container vc_col-sm-4 vc_col-lg-offset-1 vc_col-lg-2 wd-rs-6970572a0db80"><div class="vc_column-inner"><div class="wpb_wrapper">
		<div id="wd-69705553442e8" class="title-wrapper wd-wpb wd-set-mb reset-last-child  wd-rs-69705553442e8 wd-title-color-default wd-title-style-default text-left vc_custom_1768969653950 wd-underline-colored">
			
			<div class="liner-continer">
				<h4 class="woodmart-title-container title  wd-font-weight- wd-fontsize-m" >BUSIINESS</h4>
							</div>
			
			
			
		</div>
		
		<div  class="vc_wp_custommenu wpb_content_element"><div class="widget widget_nav_menu"><div class="menu-footer-widget-1-container"><ul id="menu-footer-widget-1" class="menu"><li id="menu-item-24054" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-24054"><a href="https://www.mombasacomputers.com/about-us/">About Us</a></li>
<li id="menu-item-23357" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-23357"><a href="https://www.mombasacomputers.com/privacy-policy/">Privacy Policy</a></li>
<li id="menu-item-24555" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-24555"><a href="#">Term &#038; Conditions</a></li>
<li id="menu-item-24053" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-24053"><a href="https://mombasacomputers.com/jobs">Careers</a></li>
<li id="menu-item-24052" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-24052"><a href="https://www.mombasacomputers.com/contact-us/">Contact Us</a></li>
</ul></div></div></div></div></div></div><div class="wpb_column vc_column_container vc_col-sm-4 vc_col-lg-offset-1 vc_col-lg-2 vc_hidden-lg vc_hidden-md vc_hidden-sm vc_hidden-xs wd-rs-6970573fe1cf5"><div class="vc_column-inner"><div class="wpb_wrapper">
		<div id="wd-671a392e3355c" class="title-wrapper wd-wpb wd-set-mb reset-last-child  wd-rs-671a392e3355c wd-title-color-default wd-title-style-default text-left vc_custom_1729771831497 wd-underline-colored">
			
			<div class="liner-continer">
				<h4 class="woodmart-title-container title  wd-font-weight- wd-fontsize-m" >Useful Links</h4>
							</div>
			
			
			
		</div>
		
		
		<ul class=" wd-rs-671b824d5f363 wd-list wd-wpb color-scheme-custom wd-fontsize-s wd-type-without wd-style-default text-left " id="wd-671b824d5f363">
											<li>
					
					<span class="wd-list-content list-content">About Us</span>
											<a class="wd-fill" href="#" title="About us" aria-label="List link"></a>
									</li>
											<li>
					
					<span class="wd-list-content list-content">Contact Us</span>
											<a class="wd-fill" href="#" title="Contact us" aria-label="List link"></a>
									</li>
											<li>
					
					<span class="wd-list-content list-content">Blog</span>
											<a class="wd-fill" href="#" title="Blog" aria-label="List link"></a>
									</li>
					</ul>
		</div></div></div></div></div></div></div><div class="wpb_column vc_column_container vc_col-sm-4 vc_col-lg-3 vc_col-has-fill wd-rs-671a3ce90846b"><div class="vc_column-inner vc_custom_1729772787246"><div class="wpb_wrapper"><div class="vc_row wpb_row vc_inner vc_row-fluid vc_custom_1729772930067 wd-rs-671a3d777a189"><div class="wpb_column vc_column_container vc_col-sm-12 wd-rs-671a3d83b17fa"><div class="vc_column-inner vc_custom_1729772943341"><div class="wpb_wrapper">
		<div id="wd-671a3a7448833" class="title-wrapper wd-wpb wd-set-mb reset-last-child  wd-rs-671a3a7448833 wd-enabled-width wd-title-color-default wd-title-style-default text-left vc_custom_1729772152782 wd-underline-colored">
			
			<div class="liner-continer">
				<h4 class="woodmart-title-container title  wd-font-weight- wd-fontsize-l" >4,5</h4>
							</div>
			
			
			
		</div>
		
		
		<div id="wd-671a3a5f28e71" class="title-wrapper wd-wpb wd-set-mb reset-last-child  wd-rs-671a3a5f28e71 wd-enabled-width wd-title-color-default wd-title-style-default text-center vc_custom_1729772145060 wd-underline-colored">
			
			<div class="liner-continer">
				<h4 class="woodmart-title-container title  wd-font-weight- wd-fontsize-l" >/5</h4>
							</div>
			
			
			
		</div>
		
				<div id="wd-671fa390e2406" class="wd-image wd-wpb wd-rs-671fa390e2406 text-left vc_custom_1730126760211">
			
			<img width="90" height="18" src="https://www.mombasacomputers.com/wp-content/uploads/2024/10/c2-ftr-rating-stars-90x18.png" class="attachment-90x18 size-90x18" alt="" decoding="async" loading="lazy" srcset="https://www.mombasacomputers.com/wp-content/uploads/2024/10/c2-ftr-rating-stars-90x18.png 90w, https://www.mombasacomputers.com/wp-content/uploads/2024/10/c2-ftr-rating-stars.png 200w" sizes="auto, (max-width: 90px) 100vw, 90px" />
					</div>
				<div id="wd-697057798df06" class="wd-text-block wd-wpb reset-last-child wd-rs-697057798df06 text-left wd-font-weight-600 vc_custom_1768970113302">
			<p><u>Based on 374 Google reviews</u></p>
		</div>
		<div id="wd-69705785b0f54" class=" wd-rs-69705785b0f54  wd-button-wrapper text-left"><a href="#" title="" class="btn btn-color-white btn-style-bordered btn-shape-round btn-size-default">Write a Review</a></div></div></div></div></div></div></div></div></div></section></div>						</div>
																							<div class="wd-copyrights copyrights-wrapper wd-layout-centered">
						<div class="container wd-grid-g">
							<div class="wd-col-start reset-last-child">
																	<i class="fa fa-copyright"></i>  2026 All Rights Reserved <p>Web Design by <a href="https://www.webscreationsdesign.com">Webscreations Design</a><br>
<a href="https://www.webscreationsdesigngroup.com"></a></p>															</div>
															<div class="wd-col-end reset-last-child">
									<img src="https://www.mombasacomputers.com/wp-content/themes/woodmart/images/payments.png" alt="payments">								</div>
													</div>
					</div>
							</footer>
			</div>
<div class="wd-close-side wd-fill"></div>
		<a href="#" class="scrollToTop" aria-label="Scroll to top button"></a>
		<div class="wd-search-full-screen wd-scroll wd-fill">
	<span class="wd-close-search wd-action-btn wd-style-icon wd-cross-icon">
		<a href="#" rel="nofollow" aria-label="Close search form"></a>
	</span>

	
	<form role="search" method="get" class="searchform  wd-style-default woodmart-ajax-search" action="https://www.mombasacomputers.com/"  data-thumbnail="1" data-price="1" data-post_type="product" data-count="20" data-sku="1" data-symbols_count="3" data-include_cat_search="no" autocomplete="off">
		<input type="text" class="s" placeholder="Search for products" value="" name="s" aria-label="Search" title="Search for products" required/>
		<input type="hidden" name="post_type" value="product">

		
		
		<button type="submit" class="searchsubmit">
			<span>
				Search			</span>
					</button>
	</form>

	<div class="wd-search-loader wd-fill"></div>

	
	
	
			<div class="wd-search-results  wd-scroll-content"></div>
		
			<div class="wd-search-info-text">Start typing to see products you are looking for.</div>
	
	</div>
<div class="mobile-nav wd-side-hidden wd-side-hidden-nav wd-left wd-opener-arrow"><div class="wd-search-form ">

<form role="search" method="get" class="searchform  wd-style-default woodmart-ajax-search" action="https://www.mombasacomputers.com/"  data-thumbnail="1" data-price="1" data-post_type="product" data-count="20" data-sku="1" data-symbols_count="3" data-include_cat_search="no" autocomplete="off">
	<input type="text" class="s" placeholder="Search for products" value="" name="s" aria-label="Search" title="Search for products" required/>
	<input type="hidden" name="post_type" value="product">

	<span class="wd-clear-search wd-hide"></span>

	
	<button type="submit" class="searchsubmit">
		<span>
			Search		</span>
			</button>
</form>

	<div class="wd-search-results-wrapper">
		<div class="wd-search-results wd-dropdown-results wd-dropdown wd-scroll">
			<div class="wd-scroll-content">
				
				
							</div>
		</div>
	</div>

</div>
				<ul class="wd-nav wd-nav-mob-tab wd-style-underline wd-swap">
					<li class="mobile-tab-title mobile-pages-title " data-menu="pages">
						<a href="#" rel="nofollow noopener">
							<span class="nav-link-text">
								Menu							</span>
						</a>
					</li>
					<li class="mobile-tab-title mobile-categories-title  wd-active" data-menu="categories">
						<a href="#" rel="nofollow noopener">
							<span class="nav-link-text">
								Categories							</span>
						</a>
					</li>
				</ul>
			<ul id="menu-product-category" class="mobile-categories-menu menu wd-nav wd-nav-mobile wd-layout-dropdown wd-active"><li id="menu-item-23294" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-23294 item-level-0" ><a href="https://www.mombasacomputers.com/product-category/brand-new-deals/" class="woodmart-nav-link"><span class="nav-link-text">Brand New Deals</span></a></li>
<li id="menu-item-23577" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-23577 item-level-0" ><a href="https://www.mombasacomputers.com/product-category/ex-uk-deals/" class="woodmart-nav-link"><span class="nav-link-text">Ex UK Deals</span></a></li>
<li id="menu-item-23297" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-23297 item-level-0" ><a href="https://www.mombasacomputers.com/product-category/laptops/" class="woodmart-nav-link"><span class="nav-link-text">Laptops</span></a></li>
<li id="menu-item-23292" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-23292 item-level-0" ><a href="https://www.mombasacomputers.com/product-category/desktops/" class="woodmart-nav-link"><span class="nav-link-text">Desktops</span></a></li>
<li id="menu-item-23299" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-23299 item-level-0" ><a href="https://www.mombasacomputers.com/product-category/accessories/" class="woodmart-nav-link"><span class="nav-link-text">Accessories</span></a></li>
<li id="menu-item-23296" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-23296 item-level-0" ><a href="https://www.mombasacomputers.com/product-category/printers-scanners/" class="woodmart-nav-link"><span class="nav-link-text">Printers &amp; Scanners</span></a></li>
<li id="menu-item-23293" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-23293 item-level-0" ><a href="https://www.mombasacomputers.com/product-category/networking/" class="woodmart-nav-link"><span class="nav-link-text">Networking</span></a></li>
<li id="menu-item-25573" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-25573 item-level-0" ><a href="https://www.mombasacomputers.com/product-category/apple-products/" class="woodmart-nav-link"><span class="nav-link-text">Apple Products</span></a></li>
<li id="menu-item-23306" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-23306 item-level-0" ><a href="https://www.mombasacomputers.com/product-category/gaming/" class="woodmart-nav-link"><span class="nav-link-text">Gaming</span></a></li>
<li id="menu-item-23298" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-23298 item-level-0" ><a href="https://www.mombasacomputers.com/product-category/power-protection/" class="woodmart-nav-link"><span class="nav-link-text">Power &amp; Protection</span></a></li>
<li id="menu-item-23317" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-23317 item-level-0" ><a href="https://www.mombasacomputers.com/product-category/desktops/workstations/" class="woodmart-nav-link"><span class="nav-link-text">Workstations</span></a></li>
<li id="menu-item-23295" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-23295 item-level-0" ><a href="https://www.mombasacomputers.com/product-category/pos-systems/" class="woodmart-nav-link"><span class="nav-link-text">POS Systems</span></a></li>
<li id="menu-item-23579" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-23579 item-level-0" ><a href="https://www.mombasacomputers.com/product-category/accessories/drives-storage/" class="woodmart-nav-link"><span class="nav-link-text">Drives &amp; Storage</span></a></li>
<li id="menu-item-23318" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-23318 item-level-0" ><a href="https://www.mombasacomputers.com/product-category/softwares/business-utilities/utilities-anti-virus-security/" class="woodmart-nav-link"><span class="nav-link-text">Utilities, Anti-virus, Security</span></a></li>
<li id="menu-item-23300" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-23300 item-level-0" ><a href="https://www.mombasacomputers.com/product-category/service-repair/" class="woodmart-nav-link"><span class="nav-link-text">Service &amp; Repair</span></a></li>
</ul><ul id="menu-mobile-navigation" class="mobile-pages-menu menu wd-nav wd-nav-mobile wd-layout-dropdown"><li id="menu-item-63145" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-324 current_page_item menu-item-63145 item-level-0" ><a href="https://www.mombasacomputers.com/" class="woodmart-nav-link"><span class="nav-link-text">Home</span></a></li>
<li id="menu-item-63155" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-63155 item-level-0" ><a href="https://www.mombasacomputers.com/blog-5/" class="woodmart-nav-link"><span class="nav-link-text">Blog</span></a></li>
<li id="menu-item-24878" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-24878 item-level-0" ><a href="https://www.mombasacomputers.com/?page_id=150" class="woodmart-nav-link"><span class="nav-link-text">Portfolio</span></a></li>
<li id="menu-item-63143" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-63143 item-level-0" ><a href="https://www.mombasacomputers.com/about-us/" class="woodmart-nav-link"><span class="nav-link-text">About Us</span></a></li>
<li id="menu-item-63146" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-63146 item-level-0" ><a href="https://www.mombasacomputers.com/contact-us/" class="woodmart-nav-link"><span class="nav-link-text">Contact Us</span></a></li>
<li class="menu-item menu-item-wishlist wd-with-icon item-level-0">			<a href="https://www.mombasacomputers.com/wishlist-6/" class="woodmart-nav-link">
				<span class="nav-link-text">Wishlist</span>
			</a>
			</li><li class="menu-item  login-side-opener menu-item-account wd-with-icon item-level-0"><a href="https://www.mombasacomputers.com/my-account/" class="woodmart-nav-link">Login / Register</a></li></ul>
		</div>			<div class="cart-widget-side wd-side-hidden wd-right">
				<div class="wd-heading">
					<span class="title">Shopping cart</span>
					<div class="close-side-widget wd-action-btn wd-style-text wd-cross-icon">
						<a href="#" rel="nofollow">Close</a>
					</div>
				</div>
				<div class="widget woocommerce widget_shopping_cart"><div class="widget_shopping_cart_content"></div></div>			</div>
					<div class="login-form-side wd-side-hidden woocommerce wd-right">
				<div class="wd-heading">
					<span class="title">Sign in</span>
					<div class="close-side-widget wd-action-btn wd-style-text wd-cross-icon">
						<a href="#" rel="nofollow">Close</a>
					</div>
				</div>

									<div class="woocommerce-notices-wrapper"></div>				
							<form id="customer_login" method="post" class="login woocommerce-form woocommerce-form-login
			hidden-form			" action="https://www.mombasacomputers.com/my-account/" style="display:none;"			>

				
				
				<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide form-row-username">
					<label for="username">Username or email address&nbsp;<span class="required" aria-hidden="true">*</span><span class="screen-reader-text">Required</span></label>
					<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="" />				</p>
				<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide form-row-password">
					<label for="password">Password&nbsp;<span class="required" aria-hidden="true">*</span><span class="screen-reader-text">Required</span></label>
					<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
				</p>

				
				<p class="form-row">
					<input type="hidden" id="woocommerce-login-nonce" name="woocommerce-login-nonce" value="bacf93bd58" /><input type="hidden" name="_wp_http_referer" value="/" />											<input type="hidden" name="redirect" value="https://www.mombasacomputers.com/" />
										<button type="submit" class="button woocommerce-button woocommerce-form-login__submit" name="login" value="Log in">Log in</button>
				</p>

				<p class="login-form-footer">
					<a href="https://www.mombasacomputers.com/my-account/lost-password/" class="woocommerce-LostPassword lost_password">Lost your password?</a>
					<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
						<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" value="forever" title="Remember me" aria-label="Remember me" /> <span>Remember me</span>
					</label>
				</p>

				
							</form>

		
				<div class="create-account-question">
					<p>No account yet?</p>
					<a href="https://www.mombasacomputers.com/my-account/?action=register" class="btn create-account-button">Create an Account</a>
				</div>
			</div>
		
		<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script>
			window.RS_MODULES = window.RS_MODULES || {};
			window.RS_MODULES.modules = window.RS_MODULES.modules || {};
			window.RS_MODULES.waiting = window.RS_MODULES.waiting || [];
			window.RS_MODULES.defered = true;
			window.RS_MODULES.moduleWaiting = window.RS_MODULES.moduleWaiting || {};
			window.RS_MODULES.type = 'compiled';
		</script>
		<script type="speculationrules">
{"prefetch":[{"source":"document","where":{"and":[{"href_matches":"\/*"},{"not":{"href_matches":["\/wp-*.php","\/wp-admin\/*","\/wp-content\/uploads\/*","\/wp-content\/*","\/wp-content\/plugins\/*","\/wp-content\/themes\/woodmart\/*","\/*\\?(.+)","\/wishlist-6\/","\/compare-2\/","\/my-account\/"]}},{"not":{"selector_matches":"a[rel~=\"nofollow\"]"}},{"not":{"selector_matches":".no-prefetch, .no-prefetch a"}}]},"eagerness":"conservative"}]}
</script>
<style>.products .acoplw-badge-icon{visibility:visible;} .acoplw-custom-badge-62251 { opacity:1;width:46px;font-size:13px;line-height:px;font-weight: 400;height:46px;transform:rotateX(0deg) rotateY(0deg) rotateZ(0deg);top:0px;bottom:auto;background:rgba(208, 2, 27, 1); } .acoplw-badge{visibility:visible;}</style>
<!--Start of Tawk.to Script (0.9.3)-->
<script id="tawk-script" type="text/javascript">
var Tawk_API = Tawk_API || {};
var Tawk_LoadStart=new Date();
(function(){
	var s1 = document.createElement( 'script' ),s0=document.getElementsByTagName( 'script' )[0];
	s1.async = true;
	s1.src = 'https://embed.tawk.to/5efe49eb4a7c6258179bc946/default';
	s1.charset = 'UTF-8';
	s1.setAttribute( 'crossorigin','*' );
	s0.parentNode.insertBefore( s1, s0 );
})();
</script>
<!--End of Tawk.to Script (0.9.3)-->

<link href="//fonts.googleapis.com/css?family=Roboto:400&display=swap" rel="stylesheet" property="stylesheet" media="all" type="text/css" >

	<script type='text/javascript'>
		(function () {
			var c = document.body.className;
			c = c.replace(/woocommerce-no-js/, 'woocommerce-js');
			document.body.className = c;
		})();
	</script>
	<script>
		if(typeof revslider_showDoubleJqueryError === "undefined") {function revslider_showDoubleJqueryError(sliderID) {console.log("You have some jquery.js library include that comes after the Slider Revolution files js inclusion.");console.log("To fix this, you can:");console.log("1. Set 'Module General Options' -> 'Advanced' -> 'jQuery & OutPut Filters' -> 'Put JS to Body' to on");console.log("2. Find the double jQuery.js inclusion and remove it");return "Double Included jQuery Library";}}
</script>
			<link rel="preload" as="font" id="rs-icon-set-revicon-woff" href="//www.mombasacomputers.com/wp-content/plugins/revslider/sr6/assets/fonts/revicons/revicons.woff?5510888" type="font/woff" crossorigin="anonymous" media="all" />
<script type="text/template" id="tmpl-variation-template">
	<div class="woocommerce-variation-description">{{{ data.variation.variation_description }}}</div>
	<div class="woocommerce-variation-price">{{{ data.variation.price_html }}}</div>
	<div class="woocommerce-variation-availability">{{{ data.variation.availability_html }}}</div>
</script>
<script type="text/template" id="tmpl-unavailable-variation-template">
	<p role="alert">Sorry, this product is unavailable. Please choose a different combination.</p>
</script>
<link rel='stylesheet' id='wc-blocks-style-css' href='https://www.mombasacomputers.com/wp-content/plugins/woocommerce/assets/client/blocks/wc-blocks.css?ver=wc-10.7.0' type='text/css' media='all' />
<link rel='stylesheet' id='vc_font_awesome_5_shims-css' href='https://www.mombasacomputers.com/wp-content/plugins/js_composer/assets/lib/vendor/dist/@fortawesome/fontawesome-free/css/v4-shims.min.css?ver=8.7.2' type='text/css' media='all' />
<link rel='stylesheet' id='vc_font_awesome_6-css' href='https://www.mombasacomputers.com/wp-content/plugins/js_composer/assets/lib/vendor/dist/@fortawesome/fontawesome-free/css/all.min.css?ver=8.7.2' type='text/css' media='all' />
<link rel='stylesheet' id='dashicons-css' href='https://www.mombasacomputers.com/wp-includes/css/dashicons.min.css?ver=a11bf4c3c9a1f863a745f8cd9b8b30d6' type='text/css' media='all' />
<link rel='stylesheet' id='rs-plugin-settings-css' href='//www.mombasacomputers.com/wp-content/plugins/revslider/sr6/assets/css/rs6.css?ver=6.7.40' type='text/css' media='all' />
<style id='rs-plugin-settings-inline-css' type='text/css'>
		#rev_slider_16_1_wrapper .hesperiden.tparrows{cursor:pointer;background:rgba(0,0,0,0.5);width:40px;height:40px;position:absolute;display:block;z-index:1000;  border-radius:50%}#rev_slider_16_1_wrapper .hesperiden.tparrows.rs-touchhover{background:#000000}#rev_slider_16_1_wrapper .hesperiden.tparrows:before{font-family:'revicons';font-size:20px;color:#ffffff;display:block;line-height:40px;text-align:center}#rev_slider_16_1_wrapper .hesperiden.tparrows.tp-leftarrow:before{content:'\e82c';  margin-left:-3px}#rev_slider_16_1_wrapper .hesperiden.tparrows.tp-rightarrow:before{content:'\e82d';  margin-right:-3px}
</style>
<script type="text/javascript" id="wd-update-cart-fragments-fix-js-extra">
/* <![CDATA[ */
var wd_cart_fragments_params = {"ajax_url":"\/wp-admin\/admin-ajax.php","wc_ajax_url":"\/?wc-ajax=%%endpoint%%","cart_hash_key":"wc_cart_hash_638b05839896091eee092a42beecb609","fragment_name":"wc_fragments_638b05839896091eee092a42beecb609","request_timeout":"5000"};
/* ]]> */
</script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/themes/woodmart/js/scripts/wc/updateCartFragmentsFix.js?ver=8.2.7" id="wd-update-cart-fragments-fix-js"></script>
<script type="text/javascript" src="//www.mombasacomputers.com/wp-content/plugins/revslider/sr6/assets/js/rbtools.min.js?ver=6.7.40" defer async id="tp-tools-js"></script>
<script type="text/javascript" src="//www.mombasacomputers.com/wp-content/plugins/revslider/sr6/assets/js/rs6.min.js?ver=6.7.40" defer async id="revmin-js"></script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/plugins/woocommerce/assets/js/sourcebuster/sourcebuster.min.js?ver=10.7.0" id="sourcebuster-js-js"></script>
<script type="text/javascript" id="wc-order-attribution-js-extra">
/* <![CDATA[ */
var wc_order_attribution = {"params":{"lifetime":1.0e-5,"session":30,"base64":false,"ajaxurl":"https:\/\/www.mombasacomputers.com\/wp-admin\/admin-ajax.php","prefix":"wc_order_attribution_","allowTracking":true},"fields":{"source_type":"current.typ","referrer":"current_add.rf","utm_campaign":"current.cmp","utm_source":"current.src","utm_medium":"current.mdm","utm_content":"current.cnt","utm_id":"current.id","utm_term":"current.trm","utm_source_platform":"current.plt","utm_creative_format":"current.fmt","utm_marketing_tactic":"current.tct","session_entry":"current_add.ep","session_start_time":"current_add.fd","session_pages":"session.pgs","session_count":"udata.vst","user_agent":"udata.uag"}};
/* ]]> */
</script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/plugins/woocommerce/assets/js/frontend/order-attribution.min.js?ver=10.7.0" id="wc-order-attribution-js"></script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/plugins/js_composer/assets/js/dist/js_composer_front.min.js?ver=8.7.2" id="wpb_composer_front_js-js"></script>
<script type="text/javascript" id="woodmart-theme-js-extra">
/* <![CDATA[ */
var woodmart_settings = {"menu_storage_key":"woodmart_6a44589899a5f5dc97e28a38e69017de","ajax_dropdowns_save":"1","photoswipe_close_on_scroll":"1","woocommerce_ajax_add_to_cart":"yes","variation_gallery_storage_method":"old","elementor_no_gap":"enabled","adding_to_cart":"Processing","added_to_cart":"Product was successfully added to your cart.","continue_shopping":"Continue shopping","view_cart":"View Cart","go_to_checkout":"Checkout","loading":"Loading...","countdown_days":"days","countdown_hours":"hr","countdown_mins":"min","countdown_sec":"sc","cart_url":"https:\/\/www.mombasacomputers.com\/cart\/","ajaxurl":"https:\/\/www.mombasacomputers.com\/wp-admin\/admin-ajax.php","add_to_cart_action":"widget","added_popup":"no","categories_toggle":"yes","enable_popup":"no","popup_delay":"2000","popup_event":"time","popup_scroll":"1000","popup_pages":"0","promo_popup_hide_mobile":"no","product_images_captions":"no","ajax_add_to_cart":"1","all_results":"View all results","zoom_enable":"yes","ajax_scroll":"yes","ajax_scroll_class":".wd-page-content","ajax_scroll_offset":"100","infinit_scroll_offset":"300","product_slider_auto_height":"no","price_filter_action":"click","product_slider_autoplay":"","close":"Close (Esc)","share_fb":"Share on Facebook","pin_it":"Pin it","tweet":"Share on X","download_image":"Download image","off_canvas_column_close_btn_text":"Close","cookies_version":"1","header_banner_version":"1","promo_version":"1","header_banner_close_btn":"yes","header_banner_enabled":"no","whb_header_clone":"\n\t<div class=\"whb-sticky-header whb-clone whb-main-header {{wrapperClasses}}\">\n\t\t<div class=\"{{cloneClass}}\">\n\t\t\t<div class=\"container\">\n\t\t\t\t<div class=\"whb-flex-row whb-general-header-inner\">\n\t\t\t\t\t<div class=\"whb-column whb-col-left whb-visible-lg\">\n\t\t\t\t\t\t{{.site-logo}}\n\t\t\t\t\t<\/div>\n\t\t\t\t\t<div class=\"whb-column whb-col-center whb-visible-lg\">\n\t\t\t\t\t\t{{.wd-header-main-nav}}\n\t\t\t\t\t<\/div>\n\t\t\t\t\t<div class=\"whb-column whb-col-right whb-visible-lg\">\n\t\t\t\t\t\t{{.wd-header-my-account}}\n\t\t\t\t\t\t{{.wd-header-search:not(.wd-header-search-mobile)}}\n\t\t\t\t\t\t{{.wd-header-wishlist}}\n\t\t\t\t\t\t{{.wd-header-compare}}\n\t\t\t\t\t\t{{.wd-header-cart}}\n\t\t\t\t\t\t{{.wd-header-fs-nav}}\n\t\t\t\t\t<\/div>\n\t\t\t\t\t{{.whb-mobile-left}}\n\t\t\t\t\t{{.whb-mobile-center}}\n\t\t\t\t\t{{.whb-mobile-right}}\n\t\t\t\t<\/div>\n\t\t\t<\/div>\n\t\t<\/div>\n\t<\/div>\n","pjax_timeout":"5000","split_nav_fix":"","shop_filters_close":"no","woo_installed":"1","base_hover_mobile_click":"no","centered_gallery_start":"1","quickview_in_popup_fix":"","one_page_menu_offset":"150","hover_width_small":"1","is_multisite":"","current_blog_id":"1","swatches_scroll_top_desktop":"no","swatches_scroll_top_mobile":"no","lazy_loading_offset":"0","add_to_cart_action_timeout":"no","add_to_cart_action_timeout_number":"3","single_product_variations_price":"no","google_map_style_text":"Custom style","quick_shop":"yes","sticky_product_details_offset":"150","sticky_add_to_cart_offset":"250","sticky_product_details_different":"100","preloader_delay":"300","comment_images_upload_size_text":"Some files are too large. Allowed file size is 1 MB.","comment_images_count_text":"You can upload up to 3 images to your review.","single_product_comment_images_required":"no","comment_required_images_error_text":"Image is required.","comment_images_upload_mimes_text":"You are allowed to upload images only in png, jpeg formats.","comment_images_added_count_text":"Added %s image(s)","comment_images_upload_size":"1048576","comment_images_count":"3","search_input_padding":"no","comment_images_upload_mimes":{"jpg|jpeg|jpe":"image\/jpeg","png":"image\/png"},"home_url":"https:\/\/www.mombasacomputers.com\/","shop_url":"https:\/\/www.mombasacomputers.com\/?page_id=23050","age_verify":"no","banner_version_cookie_expires":"60","promo_version_cookie_expires":"7","age_verify_expires":"30","countdown_timezone":"GMT","cart_redirect_after_add":"no","swatches_labels_name":"no","product_categories_placeholder":"Select a category","product_categories_no_results":"No matches found","cart_hash_key":"wc_cart_hash_638b05839896091eee092a42beecb609","fragment_name":"wc_fragments_638b05839896091eee092a42beecb609","photoswipe_template":"<div class=\"pswp\" aria-hidden=\"true\" role=\"dialog\" tabindex=\"-1\"><div class=\"pswp__bg\"><\/div><div class=\"pswp__scroll-wrap\"><div class=\"pswp__container\"><div class=\"pswp__item\"><\/div><div class=\"pswp__item\"><\/div><div class=\"pswp__item\"><\/div><\/div><div class=\"pswp__ui pswp__ui--hidden\"><div class=\"pswp__top-bar\"><div class=\"pswp__counter\"><\/div><button class=\"pswp__button pswp__button--close\" title=\"Close (Esc)\"><\/button> <button class=\"pswp__button pswp__button--share\" title=\"Share\"><\/button> <button class=\"pswp__button pswp__button--fs\" title=\"Toggle fullscreen\"><\/button> <button class=\"pswp__button pswp__button--zoom\" title=\"Zoom in\/out\"><\/button><div class=\"pswp__preloader\"><div class=\"pswp__preloader__icn\"><div class=\"pswp__preloader__cut\"><div class=\"pswp__preloader__donut\"><\/div><\/div><\/div><\/div><\/div><div class=\"pswp__share-modal pswp__share-modal--hidden pswp__single-tap\"><div class=\"pswp__share-tooltip\"><\/div><\/div><button class=\"pswp__button pswp__button--arrow--left\" title=\"Previous (arrow left)\"><\/button> <button class=\"pswp__button pswp__button--arrow--right\" title=\"Next (arrow right)>\"><\/button><div class=\"pswp__caption\"><div class=\"pswp__caption__center\"><\/div><\/div><\/div><\/div><\/div>","load_more_button_page_url":"yes","load_more_button_page_url_opt":"yes","menu_item_hover_to_click_on_responsive":"no","clear_menu_offsets_on_resize":"yes","three_sixty_framerate":"60","three_sixty_prev_next_frames":"5","ajax_search_delay":"300","animated_counter_speed":"3000","site_width":"1660","cookie_secure_param":"1","cookie_path":"\/","theme_dir":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart","slider_distortion_effect":"sliderWithNoise","current_page_builder":"wpb","collapse_footer_widgets":"no","carousel_breakpoints":{"1025":"lg","768.98":"md","0":"sm"},"grid_gallery_control":"arrows","grid_gallery_enable_arrows":"none","ajax_shop":"1","add_to_cart_text":"Add to cart","mobile_navigation_drilldown_back_to":"Back to %s","mobile_navigation_drilldown_back_to_main_menu":"Back to menu","mobile_navigation_drilldown_back_to_categories":"Back to categories","search_history_title":"Search history","search_history_clear_all":"Clear","search_history_items_limit":"5","swiper_prev_slide_msg":"Previous slide","swiper_next_slide_msg":"Next slide","swiper_first_slide_msg":"This is the first slide","swiper_last_slide_msg":"This is the last slide","swiper_pagination_bullet_msg":"Go to slide {{index}}","swiper_slide_label_msg":"{{index}} \/ {{slidesLength}}","tooltip_left_selector":".wd-buttons[class*=\"wd-pos-r\"] .wd-action-btn, .wd-portfolio-btns .portfolio-enlarge","tooltip_top_selector":".wd-tooltip, .wd-buttons:not([class*=\"wd-pos-r\"]) > .wd-action-btn, body:not(.catalog-mode-on):not(.login-see-prices) .wd-hover-base .wd-bottom-actions .wd-action-btn.wd-style-icon, .wd-hover-base .wd-compare-btn, body:not(.logged-in) .wd-review-likes a","ajax_links":".wd-nav-product-cat a, .wd-page-wrapper .widget_product_categories a, .widget_layered_nav_filters a, .woocommerce-widget-layered-nav a, .filters-area:not(.custom-content) a, body.post-type-archive-product:not(.woocommerce-account) .woocommerce-pagination a, body.tax-product_cat:not(.woocommerce-account) .woocommerce-pagination a, .wd-shop-tools a:not([rel=\"v:url\"]), .woodmart-woocommerce-layered-nav a, .woodmart-price-filter a, .wd-clear-filters a, .woodmart-woocommerce-sort-by a, .woocommerce-widget-layered-nav-list a, .wd-widget-stock-status a, .widget_nav_mega_menu a, .wd-products-shop-view a, .wd-products-per-page a, .wd-cat a, body[class*=\"tax-pa_\"] .woocommerce-pagination a, .wd-product-category-filter a, .widget_brand_nav a","wishlist_expanded":"no","wishlist_show_popup":"enable","wishlist_page_nonce":"910f5fc13c","wishlist_fragments_nonce":"3393fd174d","wishlist_remove_notice":"Do you really want to remove these products?","wishlist_hash_name":"woodmart_wishlist_hash_58dad61f85be38973f251f98d1cbbada","wishlist_fragment_name":"woodmart_wishlist_fragments_58dad61f85be38973f251f98d1cbbada","wishlist_save_button_state":"no","is_criteria_enabled":"","summary_criteria_ids":"","review_likes_tooltip":"Please log in to rate reviews.","vimeo_library_url":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/js\/libs\/vimeo-player.min.js","reviews_criteria_rating_required":"no","is_rating_summary_filter_enabled":""};
var woodmart_page_css = {"wd-style-base-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/base.min.css","wd-helpers-wpb-elem-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/helpers-wpb-elem.min.css","wd-revolution-slider-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/int-rev-slider.min.css","wd-wpbakery-base-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/int-wpb-base.min.css","wd-wpbakery-base-deprecated-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/int-wpb-base-deprecated.min.css","wd-int-wordfence-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/int-wordfence.min.css","wd-notices-fixed-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/woo-opt-sticky-notices-old.min.css","wd-woocommerce-base-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/woocommerce-base.min.css","wd-mod-star-rating-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/mod-star-rating.min.css","wd-woocommerce-block-notices-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/woo-mod-block-notices.min.css","wd-wp-blocks-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/wp-blocks.min.css","wd-header-base-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/header-base.min.css","wd-mod-tools-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/mod-tools.min.css","wd-header-elements-base-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/header-el-base.min.css","wd-woo-mod-login-form-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/woo-mod-login-form.min.css","wd-header-my-account-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/header-el-my-account.min.css","wd-header-search-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/header-el-search.min.css","wd-header-cart-side-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/header-el-cart-side.min.css","wd-header-cart-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/header-el-cart.min.css","wd-widget-shopping-cart-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/woo-widget-shopping-cart.min.css","wd-widget-product-list-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/woo-widget-product-list.min.css","wd-header-mobile-nav-dropdown-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/header-el-mobile-nav-dropdown.min.css","wd-header-categories-nav-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/header-el-category-nav.min.css","wd-mod-nav-vertical-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/mod-nav-vertical.min.css","wd-mod-nav-vertical-design-default-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/mod-nav-vertical-design-default.min.css","wd-section-title-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/el-section-title.min.css","wd-mod-highlighted-text-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/mod-highlighted-text.min.css","wd-button-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/el-button.min.css","wd-product-loop-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/woo-product-loop.min.css","wd-product-loop-tiled-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/woo-product-loop-tiled.min.css","wd-woo-mod-swatches-base-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/woo-mod-swatches-base.min.css","wd-bordered-product-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/woo-opt-bordered-product.min.css","wd-swiper-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/lib-swiper.min.css","wd-woo-opt-grid-gallery-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/woo-opt-grid-gallery.min.css","wd-mfp-popup-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/lib-magnific-popup.min.css","wd-swiper-arrows-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/lib-swiper-arrows.min.css","wd-swiper-pagin-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/lib-swiper-pagin.min.css","wd-woo-prod-loop-small-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/woo-prod-loop-small.min.css","wd-banner-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/wpb-el-banner.min.css","wd-banner-style-mask-and-shadow-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/el-banner-style-mask-and-shadow.min.css","wd-banner-hover-zoom-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/el-banner-hover-zoom.min.css","wd-woo-mod-product-labels-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/woo-mod-product-labels.min.css","wd-woo-mod-product-labels-round-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/woo-mod-product-labels-round.min.css","wd-product-loop-list-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/woo-product-loop-list.min.css","wd-woo-mod-add-btn-replace-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/woo-mod-add-btn-replace.min.css","wd-footer-base-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/footer-base.min.css","wd-text-block-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/el-text-block.min.css","wd-list-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/el-list.min.css","wd-el-list-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/el-list-wpb-elem.min.css","wd-scroll-top-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/opt-scrolltotop.min.css","wd-header-search-fullscreen-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/header-el-search-fullscreen-general.min.css","wd-header-search-fullscreen-1-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/header-el-search-fullscreen-1.min.css","wd-wd-search-form-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/wd-search-form.min.css","wd-wd-search-results-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/wd-search-results.min.css","wd-wd-search-dropdown-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/wd-search-dropdown.min.css","wd-header-my-account-sidebar-css":"https:\/\/www.mombasacomputers.com\/wp-content\/themes\/woodmart\/css\/parts\/header-el-my-account-sidebar.min.css"};
var woodmart_variation_gallery_data = [];
/* ]]> */
</script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/themes/woodmart/js/scripts/global/helpers.min.js?ver=8.2.7" id="woodmart-theme-js"></script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/themes/woodmart/js/scripts/wc/woocommerceNotices.min.js?ver=8.2.7" id="wd-woocommerce-notices-js"></script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/themes/woodmart/js/scripts/header/headerBuilder.min.js?ver=8.2.7" id="wd-header-builder-js"></script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/themes/woodmart/js/scripts/wc/loginSidebar.min.js?ver=8.2.7" id="wd-login-sidebar-js"></script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/themes/woodmart/js/scripts/wc/wishlist.min.js?ver=8.2.7" id="wd-wishlist-js"></script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/themes/woodmart/js/scripts/wc/onRemoveFromCart.min.js?ver=8.2.7" id="wd-on-remove-from-cart-js"></script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/themes/woodmart/js/scripts/wc/headerCategoriesMenu.min.js?ver=8.2.7" id="wd-header-categories-menu-js"></script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/themes/woodmart/js/scripts/menu/menuOffsets.min.js?ver=8.2.7" id="wd-menu-offsets-js"></script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/themes/woodmart/js/scripts/menu/menuSetUp.min.js?ver=8.2.7" id="wd-menu-setup-js"></script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/themes/woodmart/js/scripts/wc/quickShop.min.js?ver=8.2.7" id="wd-quick-shop-js"></script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/themes/woodmart/js/scripts/wc/swatchesVariations.min.js?ver=8.2.7" id="wd-swatches-variations-js"></script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/themes/woodmart/js/scripts/wc/addToCartAllTypes.min.js?ver=8.2.7" id="wd-add-to-cart-all-types-js"></script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-includes/js/underscore.min.js?ver=1.13.7" id="underscore-js"></script>
<script type="text/javascript" id="wp-util-js-extra">
/* <![CDATA[ */
var _wpUtilSettings = {"ajax":{"url":"\/wp-admin\/admin-ajax.php"}};
/* ]]> */
</script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-includes/js/wp-util.min.js?ver=a11bf4c3c9a1f863a745f8cd9b8b30d6" id="wp-util-js"></script>
<script type="text/javascript" id="wc-add-to-cart-variation-js-extra">
/* <![CDATA[ */
var wc_add_to_cart_variation_params = {"wc_ajax_url":"\/?wc-ajax=%%endpoint%%","i18n_no_matching_variations_text":"Sorry, no products matched your selection. Please choose a different combination.","i18n_make_a_selection_text":"Please select some product options before adding this product to your cart.","i18n_unavailable_text":"Sorry, this product is unavailable. Please choose a different combination.","i18n_reset_alert_text":"Your selection has been reset. Please select some product options before adding this product to your cart."};
/* ]]> */
</script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/plugins/woocommerce/assets/js/frontend/add-to-cart-variation.min.js?ver=10.7.0" id="wc-add-to-cart-variation-js" defer="defer" data-wp-strategy="defer"></script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-includes/js/imagesloaded.min.js?ver=5.0.0" id="imagesloaded-js"></script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/themes/woodmart/js/libs/swiper.min.js?ver=8.2.7" id="wd-swiper-library-js"></script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/themes/woodmart/js/scripts/global/swiperInit.min.js?ver=8.2.7" id="wd-swiper-carousel-js"></script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/themes/woodmart/js/scripts/wc/imagesGalleryInLoop.min.js?ver=8.2.7" id="wd-image-gallery-in-loop-js"></script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/themes/woodmart/js/scripts/wc/actionAfterAddToCart.min.js?ver=8.2.7" id="wd-action-after-add-to-cart-js"></script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/themes/woodmart/js/libs/magnific-popup.min.js?ver=8.2.7" id="wd-magnific-library-js"></script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/themes/woodmart/js/scripts/wc/productImagesGallery.min.js?ver=8.2.7" id="wd-product-images-gallery-js"></script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/themes/woodmart/js/scripts/wc/quickView.min.js?ver=8.2.7" id="wd-quick-view-js"></script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/themes/woodmart/js/libs/tooltips.min.js?ver=8.2.7" id="wd-tooltips-library-js"></script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/themes/woodmart/js/scripts/global/btnsToolTips.min.js?ver=8.2.7" id="wd-btns-tooltips-js"></script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/themes/woodmart/js/scripts/wc/woocommerceQuantity.min.js?ver=8.2.7" id="wd-woocommerce-quantity-js"></script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/themes/woodmart/js/scripts/global/scrollTop.min.js?ver=8.2.7" id="wd-scroll-top-js"></script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/themes/woodmart/js/scripts/global/searchFullScreen.min.js?ver=8.2.7" id="wd-search-full-screen-js"></script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/themes/woodmart/js/libs/autocomplete.min.js?ver=8.2.7" id="wd-autocomplete-library-js"></script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/themes/woodmart/js/scripts/global/ajaxSearch.min.js?ver=8.2.7" id="wd-ajax-search-js"></script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/themes/woodmart/js/scripts/menu/mobileNavigation.min.js?ver=8.2.7" id="wd-mobile-navigation-js"></script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/themes/woodmart/js/scripts/global/clearSearch.min.js?ver=8.2.7" id="wd-clear-search-js"></script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/themes/woodmart/js/scripts/wc/cartWidget.min.js?ver=8.2.7" id="wd-cart-widget-js"></script>
<script type="text/javascript" id="wc-cart-fragments-js-extra">
/* <![CDATA[ */
var wc_cart_fragments_params = {"ajax_url":"\/wp-admin\/admin-ajax.php","wc_ajax_url":"\/?wc-ajax=%%endpoint%%","cart_hash_key":"wc_cart_hash_638b05839896091eee092a42beecb609","fragment_name":"wc_fragments_638b05839896091eee092a42beecb609","request_timeout":"5000"};
/* ]]> */
</script>
<script type="text/javascript" src="https://www.mombasacomputers.com/wp-content/plugins/woocommerce/assets/js/frontend/cart-fragments.min.js?ver=10.7.0" id="wc-cart-fragments-js" defer="defer" data-wp-strategy="defer"></script>
<script></script><script id="rs-initialisation-scripts">
		var	tpj = jQuery;

		var	revapi16,revapi18;

		if(window.RS_MODULES === undefined) window.RS_MODULES = {};
		if(RS_MODULES.modules === undefined) RS_MODULES.modules = {};
		RS_MODULES.modules["revslider161"] = {once: RS_MODULES.modules["revslider161"]!==undefined ? RS_MODULES.modules["revslider161"].once : undefined, init:function() {
			window.revapi16 = window.revapi16===undefined || window.revapi16===null || window.revapi16.length===0  ? document.getElementById("rev_slider_16_1") : window.revapi16;
			if(window.revapi16 === null || window.revapi16 === undefined || window.revapi16.length==0) { window.revapi16initTry = window.revapi16initTry ===undefined ? 0 : window.revapi16initTry+1; if (window.revapi16initTry<20) requestAnimationFrame(function() {RS_MODULES.modules["revslider161"].init()}); return;}
			window.revapi16 = jQuery(window.revapi16);
			if(window.revapi16.revolution==undefined){ revslider_showDoubleJqueryError("rev_slider_16_1"); return;}
			revapi16.revolutionInit({
					revapi:"revapi16",
					DPR:"dpr",
					duration:"1000ms",
					visibilityLevels:"915,465,778,480",
					gridwidth:915,
					gridheight:465,
					lazyType:"smart",
					perspective:600,
					perspectiveType:"local",
					editorheight:"465,768,960,455",
					responsiveLevels:"915,465,778,480",
					progressBar:{disableProgressBar:true},
					navigation: {
						mouseScrollNavigation:false,
						wheelCallDelay:1000,
						arrows: {
							enable:true,
							style:"hesperiden",
							left: {

							},
							right: {

							}
						}
					},
					viewPort: {
						global:true,
						globalDist:"-200px",
						enable:false,
						visible_area:"20%"
					},
					fallbacks: {
						allowHTML5AutoPlayOnAndroid:true
					},
			});
			
		}} // End of RevInitScript

		if(window.RS_MODULES === undefined) window.RS_MODULES = {};
		if(RS_MODULES.modules === undefined) RS_MODULES.modules = {};
		RS_MODULES.modules["revslider182"] = {once: RS_MODULES.modules["revslider182"]!==undefined ? RS_MODULES.modules["revslider182"].once : undefined, init:function() {
			window.revapi18 = window.revapi18===undefined || window.revapi18===null || window.revapi18.length===0  ? document.getElementById("rev_slider_18_2") : window.revapi18;
			if(window.revapi18 === null || window.revapi18 === undefined || window.revapi18.length==0) { window.revapi18initTry = window.revapi18initTry ===undefined ? 0 : window.revapi18initTry+1; if (window.revapi18initTry<20) requestAnimationFrame(function() {RS_MODULES.modules["revslider182"].init()}); return;}
			window.revapi18 = jQuery(window.revapi18);
			if(window.revapi18.revolution==undefined){ revslider_showDoubleJqueryError("rev_slider_18_2"); return;}
			revapi18.revolutionInit({
					revapi:"revapi18",
					DPR:"dpr",
					duration:"2000ms",
					visibilityLevels:"915,465,778,480",
					gridwidth:800,
					gridheight:533,
					lazyType:"smart",
					perspective:600,
					perspectiveType:"global",
					editorheight:"533,768,960,720",
					responsiveLevels:"915,465,778,480",
					progressBar:{disableProgressBar:true},
					navigation: {
						onHoverStop:false
					},
					viewPort: {
						global:true,
						globalDist:"-200px",
						enable:false
					},
					fallbacks: {
						allowHTML5AutoPlayOnAndroid:true
					},
			});
			
		}} // End of RevInitScript

		if (window.RS_MODULES.checkMinimal!==undefined) { window.RS_MODULES.checkMinimal();};
	</script>
<script defer src="https://static.cloudflareinsights.com/beacon.min.js/v833ccba57c9e4d2798f2e76cebdd09a11778172276447" integrity="sha512-57MDmcccJXYtNnH+ZiBwzC4jb2rvgVCEokYN+L/nLlmO8rfYT/gIpW2A569iJ/3b+0UEasghjuZH/ma3wIs/EQ==" data-cf-beacon='{"version":"2024.11.0","token":"cb9e22eb1e1d4022909b35c7aebff38b","r":1,"server_timing":{"name":{"cfCacheStatus":true,"cfEdge":true,"cfExtPri":true,"cfL4":true,"cfOrigin":true,"cfSpeedBrain":true},"location_startswith":null}}' crossorigin="anonymous"></script>
</body>
</html>

      </div>
    </div>
    <div class="copyright">
      © 2025 Family Tech — Elevating Digital Experiences. All trademarks reserved.
    </div>
  </div>
</footer>

<script>
  // PRODUCT CATALOG (IT products: laptops, desktops, all in ones, mini pcs, workstations, monitors, printers, smartboards, ups, accessories)
  const products = [
    { id: 1, name: "ZenBook Pro 15", category: "Laptop", price: 1499, icon: "fas fa-laptop" },
    { id: 2, name: "WorkStation X9", category: "Workstation", price: 2899, icon: "fas fa-server" },
    { id: 3, name: "All-in-One 27\"", category: "All-in-One", price: 1299, icon: "fas fa-tv" },
    { id: 4, name: "Mini PC Ultra", category: "Mini PC", price: 599, icon: "fas fa-microchip" },
    { id: 5, name: "Desktops Power G5", category: "Desktop", price: 1099, icon: "fas fa-desktop" },
    { id: 6, name: "ProArt 32\" 4K Monitor", category: "Monitor", price: 849, icon: "fas fa-tv" },
    { id: 7, name: "Laser Printer MFP", category: "Printer", price: 379, icon: "fas fa-print" },
    { id: 8, name: "SmartBoard Touch 75\"", category: "Smartboard", price: 2499, icon: "fas fa-chalkboard" },
    { id: 9, name: "UPS 1500VA Backup", category: "UPS", price: 219, icon: "fas fa-battery-full" },
    { id: 10, name: "Wireless Mouse+Keyboard", category: "Accessory", price: 49, icon: "fas fa-keyboard" },
    { id: 11, name: "Gaming Laptop Helios", category: "Laptop", price: 1899, icon: "fas fa-gamepad" },
    { id: 12, name: "USB-C Hub 10-in-1", category: "Accessory", price: 79, icon: "fas fa-plug" },
    { id: 13, name: "Ergonomic Monitor Arm", category: "Accessory", price: 89, icon: "fas fa-cogs" },
    { id: 14, name: "Workstation Z Tower", category: "Workstation", price: 3699, icon: "fas fa-database" },
    { id: 15, name: "Smart Interactive Board", category: "Smartboard", price: 3199, icon: "fas fa-chalkboard-teacher" }
  ];

  // Cart array
  let cart = [];

  // Render all products
  function renderProducts() {
    const grid = document.getElementById('productsGrid');
    if (!grid) return;
    grid.innerHTML = '';
    products.forEach(prod => {
      const card = document.createElement('div');
      card.className = 'product-card';
      card.innerHTML = `
        <div class="product-img">
          <i class="${prod.icon}" style="font-size: 3.8rem;"></i>
        </div>
        <div class="product-info">
          <div class="product-category">${prod.category}</div>
          <div class="product-title">${prod.name}</div>
          <div class="product-price">$${prod.price.toLocaleString()}</div>
          <button class="add-to-cart" data-id="${prod.id}"><i class="fas fa-cart-plus"></i> Add to Cart</button>
        </div>
      `;
      grid.appendChild(card);
    });
    // attach add-to-cart events after rendering
    document.querySelectorAll('.add-to-cart').forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.stopPropagation();
        const id = parseInt(btn.getAttribute('data-id'));
        addToCart(id);
      });
    });
  }

  function addToCart(productId) {
    const product = products.find(p => p.id === productId);
    if (!product) return;
    const existingItem = cart.find(item => item.id === productId);
    if (existingItem) {
      existingItem.qty += 1;
    } else {
      cart.push({ ...product, qty: 1 });
    }
    updateCartUI();
    animateCartIcon();
  }

  function removeFromCart(productId) {
    const index = cart.findIndex(item => item.id === productId);
    if (index !== -1) {
      if (cart[index].qty > 1) {
        cart[index].qty -= 1;
      } else {
        cart.splice(index, 1);
      }
    }
    updateCartUI();
  }

  function updateCartUI() {
    const cartCountSpan = document.getElementById('cartCount');
    const cartItemsDiv = document.getElementById('cartItemsList');
    const cartTotalSpan = document.getElementById('cartTotal');
    let totalItems = 0;
    let totalPrice = 0;
    cart.forEach(item => {
      totalItems += item.qty;
      totalPrice += item.price * item.qty;
    });
    if (cartCountSpan) cartCountSpan.innerText = totalItems;
    if (cartItemsDiv) {
      if (cart.length === 0) {
        cartItemsDiv.innerHTML = '<p style="color:#94a3b8;">🛍️ Your cart is empty. Add some tech!</p>';
      } else {
        cartItemsDiv.innerHTML = '';
        cart.forEach(item => {
          const div = document.createElement('div');
          div.className = 'cart-item';
          div.innerHTML = `
            <div><strong>${item.name}</strong><br>$${item.price} x ${item.qty}</div>
            <div><button class="remove-item" data-id="${item.id}" style="background: #fee2e2; border: none; border-radius: 30px; padding: 5px 12px; cursor:pointer;">Remove</button></div>
          `;
          cartItemsDiv.appendChild(div);
        });
        document.querySelectorAll('.remove-item').forEach(btn => {
          btn.addEventListener('click', (e) => {
            const id = parseInt(btn.getAttribute('data-id'));
            removeFromCart(id);
          });
        });
      }
    }
    if (cartTotalSpan) cartTotalSpan.innerText = `Total: $${totalPrice.toLocaleString()}`;
  }

  function animateCartIcon() {
    const icon = document.querySelector('.cart-icon i');
    if (icon) {
      icon.style.transform = 'scale(1.2)';
      setTimeout(() => { icon.style.transform = 'scale(1)'; }, 200);
    }
  }

  // cart sidebar logic
  const cartIconBtn = document.getElementById('cartIcon');
  const cartOverlay = document.getElementById('cartOverlay');
  const cartSidebar = document.getElementById('cartSidebar');
  const closeCartBtn = document.getElementById('closeCart');

  function openCart() {
    cartOverlay.classList.add('open');
    cartSidebar.classList.add('open');
  }
  function closeCartFn() {
    cartOverlay.classList.remove('open');
    cartSidebar.classList.remove('open');
  }
  if (cartIconBtn) cartIconBtn.addEventListener('click', openCart);
  if (closeCartBtn) closeCartBtn.addEventListener('click', closeCartFn);
  if (cartOverlay) cartOverlay.addEventListener('click', closeCartFn);

  // checkout alert + reset (demo)
  const checkoutBtn = document.getElementById('checkoutBtn');
  if (checkoutBtn) {
    checkoutBtn.addEventListener('click', () => {
      if (cart.length === 0) {
        alert("Your cart is empty. Add amazing IT products first!");
      } else {
        alert(`✅ Thank you for shopping at Family Tech! Total: $${cart.reduce((sum, i) => sum + (i.price * i.qty), 0).toLocaleString()}\n\nOur team will contact you shortly.`);
        // optional: reset cart for demo after "purchase"
        cart = [];
        updateCartUI();
        closeCartFn();
      }
    });
  }

  // smooth scroll to products; add extra SEO schema-like meta (dynamic)
  document.querySelector('.btn').addEventListener('click', (e) => {
    e.preventDefault();
    document.getElementById('products').scrollIntoView({ behavior: 'smooth' });
  });

  // Load product data and attach category filtering? but full grid with all products.
  renderProducts();
  updateCartUI();

  // optional additional rich snippet structured data for Google (basic)
  (function addLDJson() {
    const script = document.createElement('script');
    script.type = 'application/ld+json';
    script.textContent = JSON.stringify({
      "@context": "https://schema.org",
      "@type": "ElectronicsStore",
      "name": "Family Tech",
      "image": "https://familytech.example/logo.png",
      "description": "Best IT products store: laptops, desktops, workstations, monitors, printers, UPS, smartboards, and computer accessories.",
      "address": {
        "@type": "PostalAddress",
        "addressLocality": "San Francisco",
        "addressRegion": "CA"
      },
      "priceRange": "$$",
      "telephone": "+18002349876"
    });
    document.head.appendChild(script);
  })();

  // Make nav links smooth and interactive
  document.querySelectorAll('.nav-links a').forEach(link => {
    link.addEventListener('click', (e) => {
      if(link.getAttribute('href') === '#') e.preventDefault();
      if(link.innerText === 'Shop') document.getElementById('products').scrollIntoView({ behavior: 'smooth' });
      if(link.innerText === 'Home') window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  });
</script>

<!-- Extra elegant toast effect for added charm but not required -->
<style>
  .remove-item:hover {
    background: #fecaca !important;
  }
  button, .add-to-cart {
    cursor: pointer;
  }
  ::-webkit-scrollbar {
    width: 6px;
  }
  ::-webkit-scrollbar-track {
    background: #e2e8f0;
  }
  ::-webkit-scrollbar-thumb {
    background: #3b3bdb;
    border-radius: 10px;
  }
</style>
</body>
</html>