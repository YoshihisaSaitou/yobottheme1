<?php
//外部から直接 PHP ファイルにアクセスされるのを防ぐ
defined('ABSPATH') || exit;

/**
 * Title: デフォルトフッター
 * Slug: yobot01theme/footer
 * Categories: footer
 * Description: デフォルトフッター
 */
?>

<!-- wp:group {"tagName":"footer","style":{"elements":{"link":{"color":{"text":"var:preset|color|white"}}},"spacing":{"margin":{"top":"0rem","bottom":"0rem"},"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"1rem","right":"1rem"}}},"backgroundColor":"main-1","textColor":"white"} -->
<footer class="wp-block-group has-white-color has-main-1-background-color has-text-color has-background has-link-color" style="margin-top:0rem;margin-bottom:0rem;padding-top:var(--wp--preset--spacing--40);padding-right:1rem;padding-bottom:var(--wp--preset--spacing--40);padding-left:1rem"><!-- wp:navigation {"ref":302,"overlayMenu":"never","style":{"typography":{"fontSize":"0.75rem"},"spacing":{"blockGap":"1rem"}},"layout":{"type":"flex","justifyContent":"center"}} /-->
<!-- wp:paragraph {"align":"center","className":"copyright","style":{"typography":{"fontSize":"0.75rem"},"spacing":{"margin":{"top":"0.4375rem"}}}} -->
<p class="has-text-align-center copyright" style="margin-top:0.4375rem;font-size:0.75rem">Copyright © Test Co.,Ltd. All Rights Reserved.</p>
<!-- /wp:paragraph -->
</footer>
<!-- /wp:group -->