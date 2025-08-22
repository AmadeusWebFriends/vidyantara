<?php
variables([
	'sections-have-files' => true,
	'special-nodes' => [],
	'sliders-on' => ['index', 'relief-foundation'],
]);

function enrichThemeVars($vars, $what) {
	$node = variable('node');
	if ($what == 'header' && in_array($node, variable('sliders-on'))) {
		$suffix = $node == 'index' ? '' : '-' . $node;
		$sheet = getSheet('slider' . $suffix, false);
		$items = [];
		foreach ($sheet->rows as $row)
			$items[$row[0]] = $sheet->getValue($row, 'value');
		$vars['optional-slider'] = replaceItems(getSnippet('spa-slider'), $items, '%');

		includeThemeManager();
		$vars['optional-page-css'] = CanvasTheme::HeadCssFor('spa', $vars['optional-page-css']);
	}

	return $vars;
}

function after_footer_assets() {
	if (in_array(variable('node'), variable('sliders-on'))) {
		echo getSnippet('slider-footer');
	}
	echo getThemeSnippet('floating-button');
}

function site_before_render() {
	runFeature('engage'); //needed for floating button
	variable('htmlReplaces', [
		'Vidya' => '<span class="h5 cursive">Vidya Shankar Chakravarthy</span>',
		'VidyAntara' => '<span class="h5 cursive">' . variable('iconName') . '</span>',
		'REFLECT' => '<span class="h5 cursive">REFLECT</span>',
		'Vision' => 'To create the best rural home-stay in South India with a spiritual ambience that fosters pluralism.',
		'Mission' => 'To provide a peaceful and nurturing environment where families bond and integrate their inner and outer selves while cultivating a deeper understanding of their spiritual path and purpose of life.',
	]);

	if (hasPageParameter('slider'))
		variable('sub-theme', 'slider-only');

	$node = variable('node');

	if ($node == 'nourishment')
		variable('skip-container-for-this-page', true);

	//if ($node == 'us') variable('sub-theme', 'modern-blog');

	$section = variable('section');
	$node = variable('node');

	if (!$section || $section == $node) return;

	$isSpecial = in_array($node, variable('special-nodes'));
	$nodeFolder = SITEPATH . '/' . variable('section') . '/' . $node;
	if (!disk_is_dir($nodeFolder)) return; //allows heterogeny

	DEFINE('NODEPATH', $nodeFolder);
	variables([
		assetKey(NODEASSETS) => fileUrl('assets/nodes/'),
		'nodeSiteName' => humanize($node),
		'nodeSafeName' => $isSpecial ? $section . '-' . $node : 'default',
		'submenu-at-node' => true,
		'nodes-have-files' => true,
	]);
}
