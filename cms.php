<?php
variables([
	'sections-have-files' => true,
	'special-nodes' => [],
]);

function enrichThemeVars($vars, $what) {
	if ($what == 'header' && variable('node') == 'index') {
		$vars['optional-slider'] = getSnippet('spa-slider');
	}

	return $vars;
}

function after_footer_assets() {
	if (variable('node') == 'index') {
		echo getSnippet('slider-footer');
	}
}

function site_before_render() {
	$section = variable('section');
	$node = variable('node');

	if (!$section || $section == $node) return;

	$isSpecial = in_array($node, variable('special-nodes'));
	DEFINE('NODEPATH', SITEPATH . '/' . variable('section') . '/' . $node);
	variables([
		assetKey(NODEASSETS) => fileUrl('assets/nodes/'),
		'nodeSiteName' => humanize($node),
		'nodeSafeName' => $isSpecial ? $section . '-' . $node : 'default',
		'submenu-at-node' => true,
	]);
}
