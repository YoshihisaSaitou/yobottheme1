<?php
//外部から直接 PHP ファイルにアクセスされるのを防ぐ
defined('ABSPATH') || exit;

/**
 * Title: コンテンツに投稿内容をそのまま表示
 * Slug: yobot01theme/post-list-custom-block-pattern-2
 * Categories: query
 * Description: コンテンツに投稿内容をそのまま表示
 */
?>

<!-- wp:query {"queryId":1,"query":{"perPage":"50","pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"metadata":{"categories":["posts"],"patternName":"default-category/post-list-custom-block-pattern-2","name":"Post list custom block pattern 1"},"className":"post-list-custom-block-pattern-2","layout":{"type":"default"}} -->
<div class="wp-block-query post-list-custom-block-pattern-2"><!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"0","right":"0","bottom":"0","left":"0"},"margin":{"top":"0","bottom":"var:preset|spacing|50"},"blockGap":"0"}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignfull" style="margin-top:0;margin-bottom:var(--wp--preset--spacing--50);padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:post-template {"align":"full","style":{"typography":{"textTransform":"none"},"spacing":{"blockGap":"0"}},"layout":{"type":"default"}} -->
<!-- wp:group {"style":{"spacing":{"blockGap":"8px","padding":{"bottom":"0"},"margin":{"top":"0","bottom":"var:preset|spacing|50"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:var(--wp--preset--spacing--50);padding-bottom:0"><!-- wp:columns {"style":{"spacing":{"padding":{"top":"0","bottom":"8px","left":"0","right":"0"},"margin":{"top":"0","bottom":"0"},"blockGap":{"top":"0","left":"0"}},"border":{"bottom":{"width":"1px"}}}} -->
<div class="wp-block-columns" style="border-bottom-width:1px;margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:8px;padding-left:0"><!-- wp:column {"width":"193px","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"blockGap":"0"}}} -->
<div class="wp-block-column" style="padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;flex-basis:193px"><!-- wp:post-date {"textAlign":"left","format":"Y年n月j日","style":{"spacing":{"margin":{"top":"0","right":"0","bottom":"0","left":"0"},"padding":{"top":"0","bottom":"0","left":"0","right":"0"}},"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}},"typography":{"letterSpacing":"1px","fontSize":"1rem","fontStyle":"normal","fontWeight":"600"}},"textColor":"contrast"} /--></div>
<!-- /wp:column -->
<!-- wp:column {"width":"100%"} -->
<div class="wp-block-column" style="flex-basis:100%"><!-- wp:post-title {"style":{"typography":{"fontSize":"1rem","fontStyle":"normal","fontWeight":"bold"},"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}},"spacing":{"padding":{"top":"0"},"margin":{"top":"0","bottom":"0","left":"0","right":"0"}}},"textColor":"contrast"} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
<!-- wp:post-content /--></div>
<!-- /wp:group -->
<!-- /wp:post-template --></div>
<!-- /wp:group -->
<!-- wp:group {"style":{"spacing":{"padding":{"top":"0","bottom":"var:preset|spacing|50","right":"0","left":"0"},"margin":{"top":"0","bottom":"0"},"blockGap":"0"}},"layout":{"type":"default"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:var(--wp--preset--spacing--50);padding-left:0"><!-- wp:query-pagination {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<!-- wp:query-pagination-previous {"style":{"typography":{"fontSize":"1rem","fontStyle":"normal","fontWeight":"600","textTransform":"uppercase","letterSpacing":"1px"}}} /-->
<!-- wp:query-pagination-next {"style":{"typography":{"fontSize":"1rem","fontStyle":"normal","fontWeight":"600","textTransform":"uppercase","letterSpacing":"1px"}}} /-->
<!-- /wp:query-pagination --></div>
<!-- /wp:group --></div>
<!-- /wp:query -->