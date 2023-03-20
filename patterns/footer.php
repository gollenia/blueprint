<?php

/**
* Title: A Pattern Title
* Slug: contexis/footer
* Description: A human-friendly description.
* Viewport Width: 1024
* Categories: comma, separated, values
* Keywords: comma, separated, values
* Block Types: widget
* Inserter: yes
*/
?>
<footer class="footer">
	<div class="content content grid grid--gap-12 md:grid--columns-2 xl:grid--columns-3">
	<?php 
	dynamic_sidebar('footer_area');
?>
	</div>

</footer>
<div class="bottom">
	<div class="bottom__text"> 
		<div class="text-xs mr-2 hidden md:block"><?php _e("This website is protected by reCaptcha. See the", "ctx-theme") ?> <a href="https://policies.google.com/privacy">{{ __("Privacy Policy", "ctx-theme") }}</a> {{ __("aswell as the", "ctx-theme") }} <a href="https://policies.google.com/terms">{{ __("Terms of Service", "ctx-theme") }}</a>.</div>
		<div class="text-xs mr-2 hidden md:block"><span>© kids-team</span></div>
		<div class="text-xs mr-2"><a id="openCookiesDialog" href="#/"><?php _e("Privacy settings", "ctx-theme") ?></a></div>
		<div class="text-xs mr-2"><a href="/impressum"><?php _e("Imprint", "ctx-theme") ?></a></div>
		<div class="text-xs mr-2"><a href="/datenschutzerklaerung"><?php _e("Data protection", "ctx-theme") ?></a></div>
		<div class="bottom__logo"><figure><?php 
			$logo = get_theme_mod( 'custom_logo', '' );
			if(!empty($logo)) {
				include( $logo ); 
			}
		?></figure></div>
	</div>
</div>

