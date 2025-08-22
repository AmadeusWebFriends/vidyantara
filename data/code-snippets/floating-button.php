<?php
runFeature('popup-helper');
$start = variable('node') == 'nourishment123' ? ['food'] : [];
return returnLine('## %VidyAntara%') . NEWLINE . getPopupTabs(DEFAULTTABS, $start);
