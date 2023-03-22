<?php
$categories = dischdev()->nav();
$newerPosts = false;
$olderPosts = false;
$post = false;

$categories[] = [
    'anchor' => 'kontakt',
    'icon' => 'envelope',
    'id' => 999999,
    'name' => 'Kontakt',
    'single' => 0,
];

$categories = array_chunk($categories, ceil(count($categories) * .5));

if($this->getTemplateId() != 1 && class_exists('Url\Url') && Url\Url::resolveCurrent()) {
    $manager = Url\Url::resolveCurrent();

    $post = rex_yform_manager_table::get('dd_post')->query()->findId($manager->getDatasetId());

    $newerPosts = dd_post()->newer($post->getValue('id'));
    $olderPosts = dd_post()->older($post->getValue('id'));
}
?>

<nav id="dd-nav-primary-wrapper" class="dd-nav-primary-wrapper">
    <ul id="dd-nav-primary-left" class="dd-nav-primary dd-nav-primary-left">
        <?php
        if($olderPosts) {
            $olderPosts = $olderPosts[0];
            ?>

            <li>
                <a class="dd-icon" href="<?php echo rex_getUrl('', '', ['post_id' => $olderPosts['id']]); ?>" title="Älterer Beitrag" data-tooltip="true">
                    <?php echo file_get_contents('theme/public/assets/frontend/new/images/icon-arrow-left.svg'); ?>
                </a>
            </li>

            <?php
        } else if(!$post && array_key_exists(0, $categories)) {
            dd_part()->nav($categories[0]);
        }
        ?>
    </ul>

    <ul id="dd-nav-primary-right" class="dd-nav-primary dd-nav-primary-right">
        <?php
        if($newerPosts) {
            $newerPosts = $newerPosts[0];
            ?>

            <li>
                <a class="dd-icon" href="<?php echo rex_getUrl('', '', ['post_id' => $newerPosts['id']]); ?>" title="Neuerer Beitrag" data-tooltip="true">
                    <?php echo file_get_contents('theme/public/assets/frontend/new/images/icon-arrow-right.svg'); ?>
                </a>
            </li>

            <?php
        } else if(!$post && array_key_exists(1, $categories)) {
            dd_part()->nav($categories[1]);
        }
        ?>
    </ul>
</nav>
