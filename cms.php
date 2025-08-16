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
}

function site_before_render() {
	variable('htmlReplaces', [
		'VidyAntara' => /*_iconLink(getLogoOrIcon('icon', 'site')) .*/ ' <span class="h5 cursive">' . variable('iconName') . '</span>',
	]);

	if (hasPageParameter('slider'))
		variable('sub-theme', 'slider-only');

	$node = variable('node');
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
