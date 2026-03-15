# yobottheme1

WordPress ブロックテーマ `yobottheme1` の構成、各ファイルの責務、運用方針をまとめた README です。  
このテーマは、今後新規テーマを作成するときに再利用できる初期テンプレートとして扱うことを前提にしています。

## ルート直下ファイル

| ファイル | 役割 |
| --- | --- |
| `index.php` | 記述がなくても WordPress がテーマとして認識するために必要な最小ファイルです。ディレクトリリスティングを防ぐ目的もあります。 |
| `functions.php` | テーマ独自の機能やプラグイン連携のフック処理を定義する入口です。現状は `init.php` を読み込みます。 |
| `init.php` | 今後新規テーマを作成する時に共通で利用できる初期化処理をまとめるファイルです。CSS/JS の読み込み、ブロック向けスタイル設定、`cssMinify()` による `style.min.css` 生成などを担当します。 |
| `theme.json` | ブロックエディターの設定、ブロックの既定スタイル、レイアウト幅、フォントサイズなどを定義します。 |
| `style.css` | テーマのメタデータを記載するためのファイルです。テーマ名、作者、バージョンなどを記述し、原則としてスタイルは書きません。 |
| `style.min.css` | `assets/css` 内の必要な CSS を minify した成果物です。サイトアクセス時に `cssMinify()` で自動生成されます。 |
| `screenshot.png` | 管理画面の「外観 > テーマ」で表示されるテーマサムネイルです。 |

## ディレクトリ構成

| ディレクトリ | 役割 |
| --- | --- |
| `assets/` | 画像、JavaScript、CSS などの静的アセットを格納します。 |
| `assets/css/` | CSS ファイルを格納します。 |
| `assets/js/` | JavaScript ファイルを格納します。 |
| `assets/images/` | 画像ファイルを格納します。基本的には管理画面のメディアに保存し、テンプレートで完結する場合のみ使用します。 |
| `assets/fonts/` | フォントファイルを格納します。格納場所として用意していますが、現行テンプレートでは `Noto Sans JP` を URL から読み込んでいます。 |
| `patterns/` | ブロックパターンのファイルを格納します。専用 CSS や JavaScript は `assets/css/` または `assets/js/` に分離します。 |
| `templates/` | 投稿画面でテンプレートとして選択できるファイルを格納します。管理画面の「外観 > エディター > テンプレート」で管理できます。 |
| `parts/` | ヘッダーやフッターなどテンプレートで使用するパーツを格納します。管理画面の「外観 > エディター > パターン」で管理できます。 |
| `spec/` | このテーマのベースライン仕様書を格納します。 |

## assets 配下のファイル

### CSS

| ファイル | 役割 |
| --- | --- |
| `assets/css/theme-front.css` | フロント画面のみに適用するスタイルです。ブロックに依存しないレイアウト調整に使います。 |
| `assets/css/theme-admin.css` | 管理画面のみに適用するスタイルです。プラグインの広告など、管理画面上で不要な表示を制御する用途を想定します。 |
| `assets/css/core-table.css` | WordPress 既存ブロックのテーブルスタイルを定義します。 |
| `assets/css/pagetop-custom-block-pattern-1.css` | ページトップボタンのブロックパターン用スタイルです。 |
| `assets/css/post-list-custom-block-pattern-1.css` | 投稿一覧でタイトルと詳細リンクのみを表示し、本文を出さないパターン用スタイルです。 |
| `assets/css/post-list-custom-block-pattern-2.css` | 投稿一覧で本文コンテンツをそのまま表示するパターン用スタイルです。 |

### JavaScript

| ファイル | 役割 |
| --- | --- |
| `assets/js/pagetop-custom-block-pattern-1.js` | ページトップボタンのブロックパターン用 JavaScript です。 |

## patterns / templates / parts の対応

### ブロックパターン

`patterns/` の命名規則は `ブロックパターン名-custom-block-pattern-ナンバー` を基本とします。  
例: `pagetop-custom-block-pattern-1.php` / `pagetop-custom-block-pattern-1.css` / `pagetop-custom-block-pattern-1.js`

| ファイル | 役割 |
| --- | --- |
| `patterns/header.php` | ヘッダーのコンテンツを記述したパターンです。 |
| `patterns/footer.php` | フッターのコンテンツを記述したパターンです。 |
| `patterns/hidden-404.php` | 404 ページで表示するコンテンツを記述したパターンです。 |
| `patterns/pagetop-custom-block-pattern-1.php` | ページトップボタンのコンテンツを記述します。 |
| `patterns/post-list-custom-block-pattern-1.php` | タイトルと詳細リンクのみを表示する投稿一覧パターンです。 |
| `patterns/post-list-custom-block-pattern-2.php` | 投稿本文コンテンツをそのまま表示する投稿一覧パターンです。 |

### テンプレート

| ファイル | 役割 |
| --- | --- |
| `templates/index.html` | デフォルトテンプレートです。`parts/header.html`、`parts/footer.html`、`patterns/pagetop-custom-block-pattern-1.php` を読み込みます。 |
| `templates/lp.html` | ヘッダーとフッターを持たない LP 用テンプレートです。 |
| `templates/404.html` | ページが見つからない時のテンプレートです。`parts/header.html` と `parts/footer.html` を読み込みます。 |

### パーツ

| ファイル | 役割 |
| --- | --- |
| `parts/header.html` | `patterns/header.php` を読み込むヘッダーパーツです。 |
| `parts/footer.html` | `patterns/footer.php` を読み込むフッターパーツです。 |
| `parts/sidebar.html` | サイドバー用パーツです。現状は使用していません。 |

## 読み込みと生成の方針

- `functions.php` から `init.php` を読み込み、テーマ共通処理を集約します。
- `init.php` では管理画面用 CSS として `assets/css/theme-admin.css` を読み込みます。
- `init.php` ではフロント向け JavaScript として `assets/js/pagetop-custom-block-pattern-1.js` を読み込みます。
- `init.php` では Google Fonts から `Noto Sans JP` を読み込みます。
- `cssMinify()` は `style.min.css` を自動生成します。
- `cssMinify()` の対象は必要なフロント用 CSS のみです。管理画面専用の `assets/css/theme-admin.css` は含めません。
- `style.min.css` はインラインでフロントに出力される想定です。

## 全体レイアウト方針

- ウェブアクセシビリティを考慮し、ブラウザの基準フォント変更に追従できるよう、基本単位は `rem` を使用します。
- レイアウト崩れを防ぐため、余白やサイズ指定も `rem` を優先します。
- ただしアクセシビリティを損なわない範囲で、レイアウト都合により他の単位を使うことは許容します。
- 本文系の基本フォントサイズは `1rem` です。見出しは `theme.json` 側の設定を使います。
- `line-height` の影響で見た目上 16px より大きく見えることは許容します。
- スマホ時の文字サイズは `theme.json` の fluid typography と `clamp()` による既定縮小に従います。
- コンテンツ幅は通常 `960px`、幅広 `1440px` を基準とします。
- 幅広は「通常より広くしたいが、全幅では広すぎる」ケースで利用します。
- 幅の基準値は変更可能ですが、基本はこの値を使い、変更時は共有または報告を前提とします。
- 各ブロックの余白は、原則として `margin-top: 1rem`、`margin-bottom: 1rem` の運用を維持します。
- WordPress のデフォルト CSS が `margin-block-start` / `margin-block-end` を適用するため、意図した余白が反映されない場合があることに注意します。

## 運用メモ

- `style.css` はテーマ情報専用とし、スタイルを書かない方針にします。
- パターンごとの CSS / JS は、パターン本体と同じ名前を使って対応関係が分かるようにします。
- 新規テーマ作成時の再利用を前提に、共通処理は `init.php` に集約します。
