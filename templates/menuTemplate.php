<style media="screen">
  /* Common styles for all menus */
  .menu {
  line-height: 1;
  margin: 0 auto 3em;
  }

  .menu__list {
  position: relative;
  display: -webkit-flex;
  display: flex;
  -webkit-flex-wrap: wrap;
  flex-wrap: wrap;
  margin: 0;
  padding: 0;
  list-style: none;
  }

  .menu__item {
  display: block;
  margin: 1em 0;
  }

  .menu__link {
  font-size: 1.05em;
  font-weight: bold;
  display: block;
  padding: 1em;
  cursor: pointer;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  -webkit-touch-callout: none;
  -khtml-user-select: none;
  -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
  }

  .menu__link:hover,
  .menu__link:focus {
  outline: none;
  }


  /* Ceres */
  .menu--ceres .menu__item {
  	position: relative;
  }

  .menu--ceres .menu__link {
  	position: relative;
  	min-width: 115px;
  	height: 50px;
  	padding: 1em 1.5em;
  	text-align: center;
  	color: #b5b5b5;
  	-webkit-transition: color 0.3s;
  	transition: color 0.3s;
  }

  .menu--ceres .menu__link:hover,
  .menu--ceres .menu__link:focus {
  	color: #929292;
  }

  .menu--ceres .menu__item--current .menu__link {
  	color: #d94f5c;
  }

  .menu--ceres .menu__item::before,
  .menu--ceres .menu__item::after,
  .menu--ceres .menu__link::after {
  	content: '';
  	position: absolute;
  	bottom: 0;
  	background: #d94f5c;
  }

  .menu--ceres .menu__item::before,
  .menu--ceres .menu__item::after {
  	width: 2px;
  	height: 100%;
  	opacity: 0;
  	-webkit-transform: scale3d(1, 0, 1);
  	transform: scale3d(1, 0, 1);
  	-webkit-transform-origin: 50% 0%;
  	transform-origin: 50% 0%;
  	-webkit-transition: -webkit-transform 0s 0.1s, opacity 0.1s;
  	transition: transform 0s 0.1s, opacity 0.1s;
  }

  .menu--ceres .menu__item::before {
  	left: 0;
  }

  .menu--ceres .menu__item::after {
  	right: 0;
  }

  .menu--ceres .menu__item--current::before,
  .menu--ceres .menu__item--current::after {
  	opacity: 1;
  	-webkit-transform: scale3d(1, 1, 1);
  	transform: scale3d(1, 1, 1);
  	-webkit-transition: -webkit-transform 0.3s;
  	transition: transform 0.3s;
  	-webkit-transition-delay: 0.3s;
  	transition-delay: 0.3s;
  	-webkit-transition-timing-function: cubic-bezier(0.2, 1, 0.3, 1);
  	transition-timing-function: cubic-bezier(0.2, 1, 0.3, 1);
  }

  /* bottom line */
  .menu--ceres .menu__link::after {
  	left: 0;
  	width: 100%;
  	height: 2px;
  	-webkit-transition: -webkit-transform 0.3s;
  	transition: transform 0.3s;
  }

  .menu--ceres .menu__item--current .menu__link::after {
  	-webkit-transform: translate3d(0, -48px, 0);
  	transform: translate3d(0, -48px, 0);
  	-webkit-transition-timing-function: cubic-bezier(0.7, 0, 0.3, 1);
  	transition-timing-function: cubic-bezier(0.7, 0, 0.3, 1);
  }

</style>
<nav class="menu menu--ceres">
  <ul class="menu__list">
    <li class="menu__item menu__item--current"><a href="#" class="menu__link">Home</a></li>
    <li class="menu__item"><a href="#" class="menu__link">Gallery</a></li>
    <li class="menu__item"><a href="#" class="menu__link">Clients</a></li>
    <li class="menu__item"><a href="#" class="menu__link">Shop</a></li>
    <li class="menu__item"><a href="#" class="menu__link">Contact</a></li>
  </ul>
</nav>
<script src="js/classie.js"></script>
<script>
		(function() {
			[].slice.call(document.querySelectorAll('.menu')).forEach(function(menu) {
				var menuItems = menu.querySelectorAll('.menu__link'),
					setCurrent = function(ev) {
						ev.preventDefault();

						var item = ev.target.parentNode; // li

						// return if already current
						if (classie.has(item, 'menu__item--current')) {
							return false;
						}
						// remove current
						classie.remove(menu.querySelector('.menu__item--current'), 'menu__item--current');
						// set current
						classie.add(item, 'menu__item--current');
					};

				[].slice.call(menuItems).forEach(function(el) {
					el.addEventListener('click', setCurrent);
				});
			});

			[].slice.call(document.querySelectorAll('.link-copy')).forEach(function(link) {
				link.setAttribute('data-clipboard-text', location.protocol + '//' + location.host + location.pathname + '#' + link.parentNode.id);
				new Clipboard(link);
				link.addEventListener('click', function() {
					classie.add(link, 'link-copy--animate');
					setTimeout(function() {
						classie.remove(link, 'link-copy--animate');
					}, 300);
				});
			});
		})(window);
</script>
