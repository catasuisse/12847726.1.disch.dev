<?php

$data = rex_file::get($this->getPath('JOURNAL.md'));

[$toc, $content] = rex_markdown::factory()->parseWithToc($data);

$fragment = new rex_fragment();
$fragment->setVar('content', $content, false);
$fragment->setVar('toc', $toc, false);

$content = $fragment->parse('core/page/docs.php');

$fragment = new rex_fragment();
$fragment->setVar('body', $content, false);
$fragment->setVar('title', 'Beiträge', false);

echo rex_view::title('Beiträge');
echo $fragment->parse('core/page/section.php');
