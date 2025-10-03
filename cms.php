<?php
variables([
	'sections-have-files' => true,
	'no-page-menu' => true,
	'no-seo-info' => true,
	'no-search' => true,
	'salutation' => 'VidyAntara folks',
	'social' => [
		//[ 'type' => 'linkedin', 'url' => 'https://www.linkedin.com/in/vidya-shankar-1453ab49/', 'name' => 'Vidya' ],
	],
	'footer-variation' => 'no-widget',
	'quotes-display-count' => 5,
]);

//if (variable('live')) variable('under-construction', true);

function after_menu() {
	_headerMenuItem(replaceHtml('<img src="%site-assets%relief-foundation-icon.png" height="40" />'), 'https://relieffoundation.in/', true);
}

function enrichThemeVars($vars, $what) {
	if ($what == 'header' && nodeIs(SITEHOME)) {
		$sheet = getSheet('slider', false);
		$items = [];
		foreach ($sheet->rows as $row)
			$items[$row[0]] = $sheet->getValue($row, 'value');
		$vars['optional-slider'] = replaceHtml(replaceItems(getSnippet('spa-slider'), $items, '%'));
		includeThemeManager();
		$vars['optional-page-css'] = CanvasTheme::HeadCssFor('spa', $vars['optional-page-css']);
	}

	return $vars;
}

function after_footer_assets() {
	if (nodeIs(SITEHOME))
		echo getSnippet('slider-footer');

	//echo getThemeSnippet('floating-button');
}

function site_before_render() {
	runFeature('engage'); //needed for floating button
	variable('htmlReplaces', [
		'Vidya' => '<span class="h5 cursive">Vidya Shankar Chakravarthy</span>',
		'VidyAntara' => '<span class="h5 cursive">' . variable('name') . '</span>',
		'REFLECT' => '<span class="h5 cursive">REFLECT</span>',
		'Vision' => 'we aspire to create the best rural home-stay in South India with a spiritual ambience that fosters pluralism.',
		'Mission' => 'our aim is to provide a peaceful and nurturing environment where families bond and integrate their inner and outer selves while cultivating a deeper understanding of their spiritual path and purpose of life.',
	]);

	if (hasPageParameter('slider'))
		variable('sub-theme', 'slider-only');

	if (variable('node') == 'food')
		variable('skip-container-for-this-page', true);
}
