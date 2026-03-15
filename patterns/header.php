<?php
//外部から直接 PHP ファイルにアクセスされるのを防ぐ
defined('ABSPATH') || exit;

/**
 * Title: デフォルトヘッダー
 * Slug: solidseedblocktheme/header
 * Categories: header
 * Description: デフォルトヘッダー
 */
?>

<!-- wp:group {"tagName":"header","className":"global-header","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"1rem","right":"1rem"},"margin":{"top":"0rem","bottom":"1rem"}}}} -->
<header class="wp-block-group global-header" style="margin-top:0rem;margin-bottom:1rem;padding-top:var(--wp--preset--spacing--40);padding-right:1rem;padding-bottom:var(--wp--preset--spacing--40);padding-left:1rem">
<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group">
<!-- wp:site-logo {"width":200,"shouldSyncIcon":false} /-->
<!-- wp:navigation {"ref":298,"icon":"menu","className":"global-nav-main"} /-->
</div>
<!-- /wp:group -->
</header>
<!-- /wp:group -->