<?php

// *****

$homeVars = [
	'about-text' => 'SOMETHING HERE',
	'cta-w-100-link' => '#todo',
	'cta-w-100' => 'apply for the unique VidyAntara member[friend]ship',
	'suggestions-text' => 'MORE IN THIS SPACE',
];

// *****

$itemTemplate = disk_file_get_contents(SITEPATH . '/data/templates/feature.html');
$sheet = getSheet('features', false);
$items = [];

foreach ($sheet->rows as $item) {
	$item = rowToObject($item, $sheet);
	$item['link'] = pageUrl($item['link']);
	$items[] = replaceItems($itemTemplate, $item, '%');
}

$homeVars['featureHtml'] = implode(NEWLINES2, $items);

// *****

$itemTemplate = disk_file_get_contents(SITEPATH . '/data/templates/suggestion.html');
$sheet = getSheet('suggestions', 'ix');

foreach ($sheet->group as $ix => $rows) {
	$homeVars['suggestion-' . $ix] = $sheet->getValue($rows[0], 'group');
	$items = [];
	foreach ($rows as $item) {
		$item = rowToObject($item, $sheet);
		$item['link'] = pageUrl($item['link']);
		$items[] = replaceItems($itemTemplate, $item, '%');
	}
	$homeVars['suggestions-' . $ix] = implode(NEWLINES2, $items);;
}

// *****

$itemTemplate = disk_file_get_contents(SITEPATH . '/data/templates/home.html');

echo replaceItems($itemTemplate, $homeVars, '%');
