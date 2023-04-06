<?php
$categories = dischdev()->nav();
$newerPosts = false;
$olderPosts = false;
$post = false;

if($this->getTemplateId() != 1 && class_exists('Url\Url') && Url\Url::resolveCurrent()) {
    $manager = Url\Url::resolveCurrent();

    $post = rex_yform_manager_table::get('dd_post')->query()->findId($manager->getDatasetId());

    $newerPosts = dd_post()->newer($post->getValue('id'));
    $olderPosts = dd_post()->older($post->getValue('id'));
}
?>

<nav id="dd-nav-primary-wrapper" class="dd-nav-primary-wrapper">
    <ul id="dd-nav-primary" class="dd-nav-primary">
        <?php dd_part()->nav($categories); ?>
    </ul>
</nav>

<div id="dd-nav-toggler" class="dd-nav-toggler">
    <div id="dd-nav-toggler-icon" class="dd-nav-toggler-icon"></div>
</div>
