<?php
/**
 * テーマ初期設定ファイル
 * テーマ作成に共通で必要な処理をまとめている
 */

error_reporting(E_ERROR);

//外部から直接PHPファイルにアクセスされるのを防ぐ
defined('ABSPATH') || exit;

//無効化
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('template_redirect', 'rest_output_link_header', 11);
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('wp_head', 'wp_oembed_add_host_js');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

//WordPressの自動更新を無効にする
add_filter( 'automatic_updater_disabled', '__return_true' );

//管理画面のブロックエディタとフロントの両方に適用
add_action('enqueue_block_assets', function () {
    //Googleフォント設定
    add_action('wp_head', function() {
        echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
        echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
    });
    wp_enqueue_style('theme-googlefonts', 'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap', [], null);
});

//管理画面の全体に適用
add_action('admin_enqueue_scripts', function () {
    wp_enqueue_style('theme-front-block-editor', getFileCacheReset('/assets/css/theme-admin.css'));
});

//フロントの全体に適用
add_action('wp_enqueue_scripts', function () {
    //jquery読み込み
    wp_enqueue_script('jquery');
    //wp_enqueue_script('jquery-script', 'https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js', '', null, true);
    
    //ページトップに戻るボタンのJS読み込み
    wp_enqueue_script('common-script', get_template_directory_uri() . '/assets/js/pagetop-custom-block-pattern-1.js', [], '1.0.0', true);
});

//特定のブロックに対してスタイルシートを適用
function solidseedblockthemeBlockStyles() {
    wp_enqueue_block_style(
        'core/table',
        [
            'handle' => 'custom-table-style',
            'src'    => get_parent_theme_file_uri( 'assets/css/core-table.css' ),
            'path'   => get_parent_theme_file_path( 'assets/css/core-table.css' ),
            'ver'    => wp_get_theme( get_template() )->get( 'Version' ),
        ]
    );
    
    wp_enqueue_block_style(
        'solidseedblocktheme/post-list-custom-block-pattern-1',
        [
            'handle' => 'solidseedblocktheme-post-list-custom-block-pattern-1',
            'src'    => get_parent_theme_file_uri( 'assets/css/post-list-custom-block-pattern-1.css' ),
            'path'   => get_parent_theme_file_path( 'assets/css/post-list-custom-block-pattern-1.css' ),
            'ver'    => wp_get_theme( get_template() )->get( 'Version' ),
        ]
    );
    
    wp_enqueue_block_style(
        'solidseedblocktheme/post-list-custom-block-pattern-2',
        [
            'handle' => 'solidseedblocktheme-post-list-custom-block-pattern-2',
            'src'    => get_parent_theme_file_uri( 'assets/css/post-list-custom-block-pattern-2.css' ),
            'path'   => get_parent_theme_file_path( 'assets/css/post-list-custom-block-pattern-2.css' ),
            'ver'    => wp_get_theme( get_template() )->get( 'Version' ),
        ]
    );
    
    wp_enqueue_block_style(
        'solidseedblocktheme/pagetop-custom-block-pattern-1',
        [
            'handle' => 'solidseedblocktheme-pagetop-custom-block-pattern-1',
            'src'    => get_parent_theme_file_uri( 'assets/css/pagetop-custom-block-pattern-1.css' ),
            'path'   => get_parent_theme_file_path( 'assets/css/pagetop-custom-block-pattern-1.css' ),
            'ver'    => wp_get_theme( get_template() )->get( 'Version' ),
        ]
    );
}
add_action('init', 'solidseedblockthemeBlockStyles');

/**
 * wp_headカスタム
 */
add_action('wp_head', function() {
    //titleタグを出力する、All in One SEOなどのプラグインで表示する場合は削除する
    $title = wp_get_document_title();
    //echo '<title>' . esc_attr($title) . '</title>';
    
    //metaタグのdescriptionを出力する、All in One SEOなどのプラグインで表示する場合は削除する
    if (is_home() || is_front_page() || is_single() || is_page()) {
        // フロントページや単一の投稿や固定ページの場合
        if (has_excerpt()) {
            // 投稿やページに抜粋がある場合はそれを使用
            $description = get_the_excerpt();
        } else {
            // 抜粋がない場合は投稿内容の一部を使用
            // pタグの内容を表示する
            $description = get_the_content();
            $description = do_shortcode($description);
            preg_match_all('/<p\b[^>]*>(.*?)<\/p>/i', $description, $matches);
            $matches_data = '';
            if(isset($matches[0])){
                foreach($matches[0] as $v){
                    $matches_data .= $v;
                }
            }
            $description = $matches_data;
            
            // pタグの内容が無ければ全体から取得
            if(empty($description)){
                $description = wp_trim_words(do_shortcode(get_the_content()), 120);
            }
            
            $description = wp_trim_words($description, 120);
        }
    } elseif (is_category()) {
        // カテゴリーページの場合
        $description = strip_tags(category_description());
    } elseif (is_tag()) {
        // タグページの場合
        $description = strip_tags(tag_description());
    } elseif (is_author()) {
        // 著者ページの場合
        $description = get_the_author_meta('description');
    } else {
        // それ以外のページ
        $description = get_bloginfo('description');
    }
    echo '<meta name="description" content="' . esc_attr($description) . '">';
    
    //metaタグを出力する
    echo '<meta property="og:locale" content="' . esc_attr(get_locale()) . '">';
    echo '<meta property="og:site_name" content="' . esc_attr(get_bloginfo('name')) . '">';
    echo '<meta property="og:type" content="website">';
    echo '<meta property="og:title" content="' . esc_attr($title) . '">';
    echo '<meta property="og:url" content="' . esc_url(home_url($_SERVER['REQUEST_URI'])) . '">';
    if (is_single() || is_page()) {
        echo '<meta property="article:published_time" content="' . esc_attr(get_the_date('c')) . '">';
        echo '<meta property="article:modified_time" content="' . esc_attr(get_the_modified_date('c')) . '">';
    }
    echo '<meta name="twitter:card" content="summary_large_image">';
    echo '<meta name="twitter:title" content="' . esc_attr($title) . '">';
    
    //minifyしたstyle.min.cssをheadに出力する
    echo '<style type="text/css">' . file_get_contents(get_template_directory() . '/style.min.css') . '</style>';
    
    //フォーム以外のページのGoogle reCAPTCHAバッジ非表示
    //if(!is_page('inquiry')){
    //    echo '<style type="text/css">.grecaptcha-badge{display:none;}</style>';
    //}
});

//カスタムメニュー追加
add_action('init', function(){
    register_nav_menus([
        'global-nav-main' => 'グローバルメインメニュー',
        //'global-nav-sub1' => 'グローバルサブ1メニュー',
        //'header-nav' => 'ヘッダーメニュー',
        'footer-nav-main' => 'フッターメインメニュー',
        //'footer-nav-sub1' => 'フッターサブ1メニュー',
        //'footer-nav-sub2' => 'フッターサブ2メニュー',
        //'top-nav' => 'トップメニュー',
        //'left-nav' => '左メニュー',
        //'test-nav' => 'テストメニュー',
    ]);
});

/**
 * wp_nav_menuのwalkerに設定する1層のaタグを削除するクラス
 */
class CustomWalkerNavMenuTopLevelChange extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        if ($depth == 0) {
            $output .= '<li class="' . implode(' ', $item->classes) . '">';
            $output .= '<span>' . $item->title . '</span>';
        } else {
            parent::start_el($output, $item, $depth, $args, $id);
        }
    }
}

/**
 * メニューにある投稿を変更
 */
function changePostMenuLabel(){
    global $menu;
    global $submenu;
    
    // メニュー名の変更
    $menu[5][0] = 'お知らせ';
    
    // サブメニュー名の変更
    $submenu['edit.php'][5][0] = 'お知らせ一覧';
    $submenu['edit.php'][10][0] = '新しいお知らせ';
    $submenu['edit.php'][16][0] = 'タグ';
    
    // ポストラベルの変更
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'お知らせ';
    $labels->singular_name = 'お知らせ';
    $labels->add_new = '新しいお知らせ';
    $labels->add_new_item = '新しいお知らせを追加';
    $labels->edit_item = 'お知らせを編集';
    $labels->new_item = '新しいお知らせ';
    $labels->view_item = 'お知らせを表示';
    $labels->search_items = 'お知らせを検索';
    $labels->not_found = 'お知らせが見つかりません';
    $labels->not_found_in_trash = 'ゴミ箱にお知らせが見つかりません';
    $labels->all_items = 'すべてのお知らせ';
    $labels->menu_name = 'お知らせ';
    $labels->name_admin_bar = 'お知らせ';
}
add_action('admin_menu', 'changePostMenuLabel');
add_action('init', 'changePostMenuLabel');

/**
 * ウィジェット設定
 */
add_action('widgets_init', function(){
    register_sidebar([
        'name' => '共通フッター',
        'id' => 'common-footer',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
    ]);
});

//ウィジェットのタイトルを非表示
add_filter('widget_title', function () {
    return;
});

//テーマがアクティベート（有効化）された直後に実行
add_action('after_switch_theme', function(){
    //「アップロードしたファイルを年月ベースのフォルダーに整理」するオプションをデフォルトでオフにする
    update_option('uploads_use_yearmonth_folders', 0);
    
    //ホームページ設定変数
    $home_page_slug = 'home';
    $home_page_id = 0;
    
    //初期固定ページを作成しグローバルナビケーションに設定する
    $global_nav_default_pages = [
        $home_page_slug => [
            'title' => 'ホーム',
            'content' => ''
        ],
        'company' => [
            'title' => '企業情報',
            'content' => ''
        ],
        'business' => [
            'title' => '事業内容',
            'content' => ''
        ],
        'recruit' => [
            'title' => '採用情報',
            'content' => ''
        ],
        'access' => [
            'title' => 'アクセス',
            'content' => ''
        ],
        'news' => [
            'title' => 'お知らせ',
            'content' => ''
        ],
        'inquiry' => [
            'title' => 'お問い合わせ',
            'content' => ''
        ],
    ];
    
    //作成したページのIDを保存する配列
    $global_nav_page_ids = [];
    
    //ページ作成
    $global_nav_menu_order = 1;
    foreach ($global_nav_default_pages as $slug => $page) {
        //同じスラッグを持つページが存在しない場合にのみ作成
        if (!$page_obj = get_page_by_path($slug)) {
            $page_id = wp_insert_post([
                'post_title' => $page['title'],
                'post_content' => $page['content'],
                'post_status' => 'publish',
                'post_type' => 'page',
                'post_name' => $slug,
                'menu_order' => $global_nav_menu_order,
            ]);
            
            $global_nav_page_ids[] = $page_id;
            
            if($home_page_slug == $slug){
                $home_page_id = $page_id;
            }
        } else {
            $global_nav_page_ids[] = $page_obj->ID;
            
            if($home_page_slug == $slug){
                $home_page_id = $page_obj->ID;
            }
        }
        
        $global_nav_menu_order++;
    }
    
    //フロントページの表示を固定ページに設定
    if($home_page_id !== 0){
        update_option('show_on_front', 'page');
        update_option('page_on_front', $home_page_id);
    }
    
    //メニューの場所がglobal-nav-mainとして登録されているか確認
    $global_nav_menu_name = 'global-nav-main';
    $global_nav_menu_exists = wp_get_nav_menu_object($global_nav_menu_name);
    
    //メニューが存在しない場合は作成
    if (!$global_nav_menu_exists) {
        $global_nav_menu_id = wp_create_nav_menu($global_nav_menu_name);
    } else {
        $global_nav_menu_id = $global_nav_menu_exists->term_id;
    }
    
    //ページをメニューに追加
    foreach ($global_nav_page_ids as $page_id) {
        //メニュー項目を取得
        $menu_items = wp_get_nav_menu_items($global_nav_menu_id);
        
        //メニューアイテムをループして、指定したページIDが存在するか確認
        $is_page_in_menu = false;
        if($menu_items){
            foreach ($menu_items as $menu_item) {
                if ($menu_item->object_id == $page_id && $menu_item->object == 'page') {
                    //ページが既にメニューに追加されている場合
                    $is_page_in_menu = true;
                }
            }
        }
        
        if(!$is_page_in_menu){
            //ページがメニューに追加されていない場合、メニューに追加
            wp_update_nav_menu_item($global_nav_menu_id, 0, [
                'menu-item-object-id' => $page_id,
                'menu-item-object' => 'page',
                'menu-item-type' => 'post_type',
                'menu-item-status' => 'publish'
            ]);
        }
    }
    
    //メニューをテーマの場所に割り当てる
    $global_nav_locations = get_theme_mod('nav_menu_locations');
    $global_nav_locations[$global_nav_menu_name] = $global_nav_menu_id;
    set_theme_mod('nav_menu_locations', $global_nav_locations);
    
    //フッターナビゲーションに設定する
    $footer_nav_default_pages = [
        'privacy-policy'
    ];
    
    //ページのIDを保存する配列
    $footer_nav_page_ids = [];
    
    //スラッグがあるページのIDを取得
    foreach ($footer_nav_default_pages as $slug) {
        if ($page_obj = get_page_by_path($slug)) {
            $footer_nav_page_ids[] = $page_obj->ID;
        }
    }
    
    //メニューの場所がfooter-nav-mainとして登録されているか確認
    $footer_nav_menu_name = 'footer-nav-main';
    $footer_nav_menu_exists = wp_get_nav_menu_object($footer_nav_menu_name);
    
    //メニューが存在しない場合は作成
    if(!$footer_nav_menu_exists){
        $footer_nav_menu_id = wp_create_nav_menu($footer_nav_menu_name);
    } else {
        $footer_nav_menu_id = $footer_nav_menu_exists->term_id;
    }
    
    //ページをメニューに追加
    foreach ($footer_nav_page_ids as $page_id) {
        //メニュー項目を取得
        $menu_items = wp_get_nav_menu_items($footer_nav_menu_id);
        
        //メニューアイテムをループして、指定したページIDが存在するか確認
        $is_page_in_menu = false;
        if($menu_items){
            foreach ($menu_items as $menu_item) {
                if ($menu_item->object_id == $page_id && $menu_item->object == 'page') {
                    //ページが既にメニューに追加されている場合
                    $is_page_in_menu = true;
                }
            }
        }
        
        if(!$is_page_in_menu){
            //ページがメニューに追加されていない場合、メニューに追加
            wp_update_nav_menu_item($footer_nav_menu_id, 0, [
                'menu-item-object-id' => $page_id,
                'menu-item-object' => 'page',
                'menu-item-type' => 'post_type',
                'menu-item-status' => 'publish'
            ]);
        }
    }
    
    //メニューをテーマの場所に割り当てる
    $footer_nav_locations = get_theme_mod('nav_menu_locations');
    $footer_nav_locations[$footer_nav_menu_name] = $footer_nav_menu_id;
    set_theme_mod('nav_menu_locations', $footer_nav_locations);
    
    //パーマリンクを変更する
    if (get_option('permalink_structure') != '/news/%post_id%/') {
        global $wp_rewrite;
        $wp_rewrite->set_permalink_structure('/news/%post_id%/');
        flush_rewrite_rules();
    }
});

/**
 * Minify
 * CSSのみ対応で簡易的なMinify。
 * フロントの全体に適用。
 */
function cssMinify(){
    //テンプレートのパス取得
    $template_directory = get_template_directory();
    
    //minifyするファイルリスト
    $file_list = [
        '/assets/css/theme-front.css',
        '/assets/css/pagetop-custom-block-pattern-1.css',
        '/assets/css/post-list-custom-block-pattern-1.css',
        '/assets/css/post-list-custom-block-pattern-2.css',
    ];
    
    //置換文字リスト
    $replace_search = [
        '  ',
        "\n",
        "\r"
    ];
    
    //style.min.cssを空にする
    file_put_contents($template_directory . '/style.min.css', '');
    foreach($file_list as $v){
        if(file_exists($template_directory . $v)){
            //ファイルの内容を取得する
            $contents = file_get_contents($template_directory . $v);
            
            //置換文字リストの文字を置換する
            $contents = str_replace($replace_search, '', $contents);
            
            // /*と*/に囲まれた部分にマッチするパターンを置換する
            $pattern = '/\/\*.*?\*\//'; 
            $contents = preg_replace($pattern, '', $contents);
            
            //style.min.cssに追記する
            file_put_contents($template_directory . '/style.min.css', $contents, FILE_APPEND);
        }
    }
}
cssMinify();

/**
 * パンくずリスト取得
 * All in One SEOなどのプラグインを使用しない場合に使用する
 */
add_shortcode('breadcrumblist', 'getBreadcrumbList');
function getBreadcrumbList($wp_obj = null, $link_list = [])
{
    //トップページでは何も出力しない
    if ((is_home() || is_front_page()) && empty($link_list)) {
        return false;
    }

    //表示するテキストのbrタグを空白にし、タグを削除する
    $text_process = function ($dt) {
        $dt = str_replace(['<br>', '<br />'], ' ', $dt);
        $dt = strip_tags($dt);
        return $dt;
    };
    
    //キーワード検索の値取得
    $fw = get_query_var('fw', '');

    $connector = '<span class="connector">›</span>';

    $html = '<div class="breadcrumb">';
    $html .= '<a href="/" title="' . get_bloginfo('name') . '">ホーム</a>';

    //現在のwpオブジェクト取得
    $wp_obj = $wp_obj ?: get_queried_object();
    //print_r($wp_obj);

    //シングルまたはカテゴリまたはタグのURLを取得
    $url = '';
    if (is_category()) {
        $url = get_category_link($wp_obj->term_id);
    } else if (is_tag()) {
        $url = get_tag_link($wp_obj->term_id);
    } else if (is_archive()) {
        $url = get_tag_link($wp_obj->term_id);
    }

    if (!empty($link_list)) {
        foreach ($link_list as $k => $v) {
            if (!empty($v['url'])) {
                $html .= $connector . '<a href="' . $v['url'] . '">' . $text_process($v['title']) . '</a>';
            } else {
                $html .= $connector . '<span>' . $text_process($v['title']) . '</span>';
            }
        }
    } else if (is_attachment()) {
        //添付ファイルページ ( $wp_obj : WP_Post )、添付ファイルページでは is_single() も true になるので先に分岐
        $html .= $connector . '<span>' . $text_process($wp_obj->post_title) . '</span>';
    } else if (is_single()) {
        //投稿ページ
        //カスタム投稿タイプかどうか
        if ($wp_obj->post_type !== 'post') {
            $url = get_post_type_archive_link($wp_obj->post_type);
            if (empty($url)) {
                $page_path = str_replace('/' . $wp_obj->ID . '/', '', substr($_SERVER['REQUEST_URI'], 1));
                $page = get_page_by_path($page_path);
                if (!empty($page)) {
                    $url = esc_url(get_permalink($page->ID));
                }
            }

            //投稿タイプのオブジェクト取得
            $post_type_obj = get_post_type_object($wp_obj->post_type);
            if (!empty($post_type_obj)) {
                //カスタム投稿タイプの親を取得
                $slug_list = explode('/', $post_type_obj->rewrite['slug']);
                if (!empty($slug_list)) {
                    foreach ($slug_list as $slk => $slv) {
                        if ($slv == $post_type_obj->name) {
                            break;
                        } else {
                            $post_type_obj_tmp = get_post_type_object($slv);
                            if (!empty($post_type_obj_tmp)) {
                                $url_tmp = esc_url(get_permalink(get_page_by_title($post_type_obj_tmp->label, OBJECT, 'page')));
                                $html .= $connector . '<a href="' . $url_tmp . '">' . $text_process($post_type_obj_tmp->label) . '</a>';
                            }
                        }
                    }
                }

                //カスタム投稿タイプ名の表示
                $html .= $connector . '<a href="' . $url . '">' . $text_process($post_type_obj->label) . '</a>';
            }
        } else {
            //デフォルト投稿の場合
            //スラッグが 'news' の固定ページ情報を取得
            $news_page = get_page_by_path('news');
            if ($news_page) {
                $url = '/news/';
                $html .= $connector . '<a href="' . $url . '">' . $text_process($news_page->post_title) . '</a>';
            }
        }

        //投稿自身の表示
        $html .= $connector . '<span>' . $text_process($wp_obj->post_title) . '</span>';
    } else if (is_page()) {
        //固定ページ
        //親ページがあれば順番に表示
        if ($wp_obj->post_parent !== 0) {
            $parent_array = array_reverse(get_post_ancestors($wp_obj->ID));
            foreach ($parent_array as $parent_id) {
                $html .= $connector . '<a href="' . get_permalink($parent_id) . '">' . $text_process(get_the_title($parent_id)) . '</a>';
            }
        }

        //クエリからタームIDを取得
        $term_query = get_query_var('term', 0);

        //投稿自身の表示
        if (!empty($term_query)) {
            $html .= $connector . '<a href="' . get_permalink($wp_obj->ID) . '">' . $text_process($wp_obj->post_title) . '</a>';

            $term_info = get_term($term_query);
            if (!empty($term_info)) {
                $html .= $connector . '<span>' . $text_process($term_info->name) . '</span>';
            }
        } else if(!empty($fw)) {
            //キーワード検索
            $html .= $connector . '<a href="' . get_permalink($wp_obj->ID) . '">' . $text_process($wp_obj->post_title) . '</a>';
            $html .= $connector . '<span>' . esc_html($fw) . '</span>';
        } else {
            $html .= $connector . '<span>' . $text_process($wp_obj->post_title) . '</span>';
        }
    } else if (is_post_type_archive()) {
        //投稿タイプアーカイブページ
        $html .= '<span>' . $text_process($connector . $wp_obj->label) . '</span>';
    } else if (is_date()) {
        //日付アーカイブ
        $year = get_query_var('year');
        $month = get_query_var('monthnum');
        $day = get_query_var('day');

        if ($day !== 0) {
            $html .= $connector . '<a href="' . get_year_link($year) . '">' . $year . '年</a>';
            $html .= $connector . '<a href="' . get_month_link($year, $month) . '">' . $month . '月</a>';
            $html .= $connector . '<span>' . $day . '日' . '</span>';
        } else if ($month !== 0) {
            $html .= $connector . '<a href="' . get_year_link($year) . '">' . $year . '年</a>';
            $html .= $connector . '<span>' . $month . '月' . '</span>';
        } else {
            $html .= $connector . '<span>' . $year . '年' . '<span>';
        }
    } else if (is_author()) {
        //投稿者アーカイブ
        $html .= '<span>' . $connector . $wp_obj->display_name . 'の執筆記事' . '<span>';
    } else if (is_archive()) {
        //タームアーカイブ
        //親ページがあれば順番に表示
        if ($wp_obj->parent !== 0) {
            $parent_array = array_reverse(get_ancestors($wp_obj->term_id, $wp_obj->taxonomy));
            foreach ($parent_array as $parent_id) {
                $parent_term = get_term($parent_id, $tax_name);
                $html .= $connector . '<a href="' . get_term_link($parent_id, $tax_name) . '">' . $parent_term->name . '</a>';
            }
        }

        //ターム自身の表示
        $html .= $connector . '<span>' . $wp_obj->name . '</span>';
    } else if (is_search()) {
        //検索結果ページ
        $html .= $connector . '<span>' . '「' . get_search_query() . '」で検索した結果' . '<span>';
    } else if (is_404()) {
        //404ページ
        $html .= $connector . '<span>' . 'お探しの記事は見つかりませんでした。' . '<span>';
    } else {
        //その他のページ（無いと思うが一応）
        $html .= $connector . '<span>' . $text_process(get_the_title()) . '<span>';
    }

    $html .= '</div>';

    return $html;
}

/**
 * ページネーション
 * 投稿一覧表示ブロックを使用せず、投稿一覧のページ遷移を番号で行い場合に使用する
 */
/*//クエリのページネーション名
define('QUERY_STRING_PAGINATION_NAME', 'pg');
function getPagination($total, $prev_next = true, $prev_text = '', $next_text = '')
{
    $current = max(1, get_query_var(QUERY_STRING_PAGINATION_NAME));
    $tmp = 999999999;
    $result = '';

    if ($total >= 2) {
        $result .= '<div class="pagination__info">';
        $result .= $current . 'ページ（全' . $total . 'ページ）';
        $result .= '</div>';

        $result .= '<div class="pagination">';
        $result .= '<a class="page-numbers first" href="?pg=1"><span class="pagination__screen-reader-text">最初のページ</span></a>';
        $result .= paginate_links([
            //'base'=>'%_%',
            'format' => '?' . QUERY_STRING_PAGINATION_NAME . '=%#%',
            //'format'=>'?paged=%#%',
            //page/1/の場合
            //'base'=>str_replace($tmp, '%#%', esc_url(get_pagenum_link($tmp))),
            //'format'=>get_pagenum_link('/page/%#%'),
            'current' => $current,
            'total' => $total,
            'prev_next' => $prev_next,
            'prev_text' => $prev_text,
            'next_text' => $next_text,
            'before_page_number' => '<span class="pagination__screen-reader-text">ページ</span>', //スクリーン読み上げ機能の利用者がリンクの用途を理解できるように、番号付きリンクへコンテキストを追加
        ]);
        $result .= '<a class="page-numbers last" href="?pg=' . $total . '"><span class="pagination__screen-reader-text">最後のページ</span></a>';
        $result .= '</div>';
    }
    return $result;
}*/

/**
 * カスタムメニューをショートコードで取得
 */
add_shortcode('custom_menu', 'getCustomMenu');
function getCustomMenu($atts)
{
    extract(shortcode_atts(array(
        'name' => '',
    ), $atts));

    return wp_nav_menu(array('theme_location' => $name, 'echo' => false));
}

/**
 * ファイルの更新日時のタイムスタンプでキャッシュリセットしたURLを取得
 */
function getFileCacheReset($file_name)
{
    return get_template_directory_uri() . $file_name . '?' . filemtime(get_template_directory() . $file_name);
}

/**
 * HTMLから特定の部分を削除する
 */
if(is_admin() === false){
    add_action('after_setup_theme', function(){
        ob_start(function ($buffer_html) {
            //デフォルトに設定されている一部のCSSを削除する
            //.is-layout-constrained > *を削除する、これがあるとmargin-block-startとmargin-block-endが設定され任意で設定したmargin-topとmargin-bottomが反映されない
            $buffer_html = preg_replace('/\.is-layout-constrained\s*>\s*\*{.*?}/', '', $buffer_html);
            
            return $buffer_html;
        });
    }, 10000);  //第2引数は優先順位(デフォルト10, 大きいほど後にまわされる)
}

/**
 * デフォルトサイトマップ（wp-sitemap.xml）
 */
//特定のプロバイダー処理
add_filter('wp_sitemaps_add_provider', function($provider, $name) {
    //ユーザーを表示しない
    return ($name == 'users') ? false : $provider;
}, 10, 2);

//投稿タイプの除外
//add_filter ('wp_sitemaps_post_types', function($post_types){
//    unset( $post_types['post'] ); // 投稿
//    unset( $post_types['page'] ); // 固定ページ
//    unset( $post_types['カスタム投稿タイプ'] ); // カスタム投稿タイプ
//    return $post_types;
//});

//表示内容をカスタマイズ
//add_filter( 'wp_sitemaps_posts_entry', function( $entry, $post ) {
//    $entry['lastmod'] = get_the_modified_time('c', $post);
//    return $entry;
//}, 10, 2);
