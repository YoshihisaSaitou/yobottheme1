# 設計

## 文書化方針

- この仕様書群は `yobottheme1` のベースライン構成を表す
- 実装変更ではなく、既存構成の責務と運用方針を明文化する
- 説明対象は、ファイル構成、読み込み関係、命名規則、レイアウト基準とする

## ファイル構成の整理

### ルート直下

- `index.php`
  - WordPress が有効テーマとして認識するための最小ファイル
  - ディレクトリリスティング防止の意味を持つ
- `functions.php`
  - テーマ独自処理の入口
  - 現状は `init.php` を読み込む
- `init.php`
  - 共通初期化処理を定義する
  - 管理画面用 CSS、フロント用 JS、ブロックスタイル、Google Fonts、`style.min.css` 生成を扱う
- `theme.json`
  - ブロックエディター設定、幅、余白、フォント、既定スタイルを管理する
- `style.css`
  - テーマメタデータ専用
- `style.min.css`
  - フロント用 CSS の minify 結果
- `screenshot.png`
  - テーマ一覧用サムネイル

### ディレクトリ

- `assets/`
  - 静的アセット格納先
- `assets/css/`
  - フロント用、管理画面用、ブロック別スタイルを格納
- `assets/js/`
  - パターンや画面挙動に必要な JavaScript を格納
- `assets/images/`
  - テンプレート内で完結する画像のみ格納
- `assets/fonts/`
  - フォントファイルの格納場所
  - 現行テーマでは `Noto Sans JP` を URL から読み込む
- `patterns/`
  - ブロックパターン本体を格納
- `templates/`
  - 選択可能なテンプレートを格納
- `parts/`
  - テンプレート部品を格納

### 主要アセット

- `assets/css/theme-front.css`
  - フロント画面のみに適用する全体スタイル
- `assets/css/theme-admin.css`
  - 管理画面のみに適用するスタイル
- `assets/css/core-table.css`
  - 既存テーブルブロック向けスタイル
- `assets/css/pagetop-custom-block-pattern-1.css`
  - ページトップボタン用スタイル
- `assets/css/post-list-custom-block-pattern-1.css`
  - 本文を表示しない投稿一覧パターン用スタイル
- `assets/css/post-list-custom-block-pattern-2.css`
  - 本文を表示する投稿一覧パターン用スタイル
- `assets/js/pagetop-custom-block-pattern-1.js`
  - ページトップボタン用 JavaScript

## 読み込み設計

### PHP の入口

- `functions.php` から `init.php` を読み込む
- 共通で再利用するテーマ処理は `init.php` に集約する

### CSS / JS の読み込み

- 管理画面用 CSS は `assets/css/theme-admin.css` を読み込む
- フロント用 JavaScript は `assets/js/pagetop-custom-block-pattern-1.js` を読み込む
- ブロックスタイルは `wp_enqueue_block_style()` を用いて個別に読み込む
  - `core/table`
  - `post-list-custom-block-pattern-1`
  - `post-list-custom-block-pattern-2`
  - `pagetop-custom-block-pattern-1`

### style.min.css の生成

- `cssMinify()` は `style.min.css` を自動生成する
- 対象は次のフロント用 CSS とする
  - `assets/css/theme-front.css`
  - `assets/css/pagetop-custom-block-pattern-1.css`
  - `assets/css/post-list-custom-block-pattern-1.css`
  - `assets/css/post-list-custom-block-pattern-2.css`
- 管理画面専用の `assets/css/theme-admin.css` は対象外とする
- 生成した `style.min.css` はフロントにインライン出力される前提で扱う

## テンプレート / パーツ / パターンの関係

### templates

- `templates/index.html`
  - `parts/header.html`
  - `parts/footer.html`
  - `patterns/pagetop-custom-block-pattern-1.php`
- `templates/404.html`
  - `parts/header.html`
  - `parts/footer.html`
  - `patterns/hidden-404.php`
- `templates/lp.html`
  - ヘッダーとフッターを読み込まない LP 用テンプレート
  - 管理画面の「外観 > エディター > テンプレート」で扱う対象

### parts

- `parts/header.html` は `patterns/header.php` を呼び出す
- `parts/footer.html` は `patterns/footer.php` を呼び出す
- `parts/sidebar.html` は現状未使用だが、将来の拡張用に保持する
- `parts/` は管理画面の「外観 > エディター > パターン」で扱う対象

### patterns

- `patterns/header.php` はヘッダーコンテンツ
- `patterns/footer.php` はフッターコンテンツ
- `patterns/hidden-404.php` は 404 コンテンツ
- `patterns/pagetop-custom-block-pattern-1.php` はページトップボタンのコンテンツ
- `patterns/post-list-custom-block-pattern-1.php` は本文なしの投稿一覧パターン
- `patterns/post-list-custom-block-pattern-2.php` は本文表示ありの投稿一覧パターン

## 命名規則

- ブロックパターン関連ファイルは `ブロックパターン名-custom-block-pattern-ナンバー` とする
- CSS / JavaScript を追加する場合は、対応するパターンと同名ベースで作成する
- 例
  - `pagetop-custom-block-pattern-1.php`
  - `pagetop-custom-block-pattern-1.css`
  - `pagetop-custom-block-pattern-1.js`

## レイアウト設計

- 基本単位は `rem` とし、フォントサイズ変更への追従性を確保する
- 他のサイズ指定も原則 `rem` を優先する
- アクセシビリティを損なわない範囲では、レイアウト都合による他単位の利用を許容する
- コンテンツ幅は通常 `960px`、幅広 `1440px` を基本値とする
- 幅広は全幅では広すぎるケースに使用する
- 本文系フォントサイズは原則 `1rem`
- スマホ時の文字サイズは `theme.json` の fluid typography と `clamp()` を前提にする
- ブロック余白は基本的に `margin-top: 1rem`、`margin-bottom: 1rem` の運用を維持する
- ただし WordPress デフォルト CSS の `margin-block-start` / `margin-block-end` の影響で見え方が変わる可能性がある

## theme.json の位置付け

- ブロックエディター設定の中心となる設定ファイル
- レイアウト幅、タイポグラフィ、余白、カラー、ボーダーなどの既定値を管理する
- `Noto Sans JP` を既定フォントファミリーとして扱う
