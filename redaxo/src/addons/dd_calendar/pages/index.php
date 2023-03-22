<?php

$data = rex_file::get($this->getPath('CALENDAR.md'));

[$toc, $content] = rex_markdown::factory()->parseWithToc($data);

$fragment = new rex_fragment();
$fragment->setVar('content', $content, false);
$fragment->setVar('toc', $toc, false);

$content = $fragment->parse('core/page/docs.php');

$fragment = new rex_fragment();
$fragment->setVar('body', $content, false);
$fragment->setVar('title', 'Kalender', false);

echo rex_view::title('Kalender');
echo $fragment->parse('core/page/section.php');
