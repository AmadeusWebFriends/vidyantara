<?php
variables([
	'sections-have-files' => true,
]);

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

	echo getThemeSnippet('floating-button');
}

function site_before_render() {
	runFeature('engage'); //needed for floating button
	variable('htmlReplaces', [
		'Vidya' => '<span class="h5 cursive">Vidya Shankar Chakravarthy</span>',
		'VidyAntara' => $name = '<span class="h5 cursive">' . variable('iconName') . '</span>',
		'REFLECT' => '<span class="h5 cursive">REFLECT</span>',
		'Vision' => 'Our vision is to create the best rural home-stay in South India with a spiritual ambience that fosters pluralism.',
		'Mission' => 'Our mission is to provide a peaceful and nurturing environment where families bond and integrate their inner and outer selves while cultivating a deeper understanding of their spiritual path and purpose of life.',
	]);

	if (hasPageParameter('slider'))
		variable('sub-theme', 'slider-only');

	if (variable('node') == 'nourishment')
		variable('skip-container-for-this-page', true);
}
