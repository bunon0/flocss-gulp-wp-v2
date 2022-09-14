<?php

/* ----------------------------
 * テーマに関する設定
 * ---------------------------- */
function add_setup()
{
  add_theme_support("automatic-feed-links"); // 投稿とコメントのRSSフィードのリンクを有効化
  add_theme_support("title-tag"); // headのタイトルタグ自動生成
  add_theme_support(
    // WordPressコアから出力されるHTMLタグをHTML5のフォーマットにする
    "html5",
    array(
      "search-form",
      "comment-form",
      "comment-list",
      "gallery",
      "caption",
    )
  );
}
add_action("after_setup_theme", "add_setup");

/* ----------------------------
* サムネイルに関する設定
* ---------------------------- */
function add_setup_thumbnails()
{
  add_theme_support("post-thumbnails"); // アイキャッチ画像を有効化
  add_image_size("", 1280, 788, true); // 独自画像サイズの追加
}
add_action("after_setup_theme", "add_setup_thumbnails");

/* ----------------------------
 * scriptファイルやstylesheetの読み込み
 * ---------------------------- */
function add_scripts()
{
  $theme_info = wp_get_theme();
  // $theme_info->get("Version")はstyle.cssで記述したテーマversionと合わせる
  wp_enqueue_style("main-style", get_theme_file_uri("/assets/css/style.css"), ["swiper-style"], $theme_info->get("Version"));
  wp_enqueue_script("main-script", get_theme_file_uri("/assets/js/main.js"), ["jquery", "swiper-script"], $theme_info->get("Version"));
}
add_action("wp_enqueue_scripts", "add_scripts");


/* ----------------------------
 * デフォルトの投稿というラベルを変更
 * ---------------------------- */
function change_post_menu_label()
{
  global $menu;
  global $submenu;
  $name = '制作事例';
  $menu[5][0] = $name;
  $submenu['edit.php'][5][0] = $name . '一覧';
  $submenu['edit.php'][10][0] = '新しい' . $name;
}
function change_post_object_label()
{
  global $wp_post_types;
  $name = '制作事例';
  $labels = &$wp_post_types['post']->labels;
  $labels->name = $name;
  $labels->singular_name = $name;
  $labels->add_new = _x('追加', $name);
  $labels->add_new_item = $name . 'の新規追加';
  $labels->edit_item = $name . 'の編集';
  $labels->new_item = '新規' . $name;
  $labels->view_item = $name . 'を表示';
  $labels->search_items = $name . 'を検索';
  $labels->not_found = $name . 'が見つかりませんでした';
  $labels->not_found_in_trash = 'ゴミ箱に' . $name . 'は見つかりませんでした';
}
add_action('init', 'change_post_object_label');
add_action('admin_menu', 'change_post_menu_label');

/* ----------------------------
* プラグイン【All-in-One WP Migration】- 除外するするファイルを設定
* ---------------------------- */
function migration_exclude_filters($exclude_filters)
{
  $theme_name = esc_html(get_template());
  $exclude_filters = [
    "{$theme_name}/dev",
    ".vscode"
  ];
  return $exclude_filters;
}
add_filter('ai1wm_exclude_themes_from_export', "migration_exclude_filters");

/* ----------------------------
* プラグイン【BackWPup】- 管理画面の除外するファイルを追加（管理画面上で追加されるよ）
* ---------------------------- */
function backwpup_exclude_filters($fileExtensions)
{
  $theme_name = esc_html(get_template()); //現在適用されているテーマの名前を取得
  return $fileExtensions . ",/wp-content/db.php,/wp-content/themes/{$theme_name}/dev,/wp-content/db.php,/wp-content/.vscode";
}
add_filter('backwpup_file_exclude', "backwpup_exclude_filters");

/* ----------------------------
* ContactForm7で送信ボタンをクリックしたら別ベージに遷移する
* ---------------------------- */
function add_origin_thanks_page()
{
  $thanks = home_url('/thanks/');
  //  const thanksPage = {formのID: '{ページスラッグ}',};
  echo <<< EOC
      <script>
        const thanksPage = {
          158: '{$thanks}',
        };
      document.addEventListener( 'wpcf7mailsent', function( event ) {
        location = thanksPage[event.detail.contactFormId];
      }, false );
      </script>
      EOC;
}
add_action('wp_footer', 'add_origin_thanks_page');
