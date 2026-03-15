# 受け入れ条件

## README

- `README.md` にテーマ概要が記載されていること
- `README.md` にルート直下ファイルの用途が記載されていること
- `README.md` に `assets/`、`patterns/`、`templates/`、`parts/` の用途が記載されていること
- `README.md` に各 CSS / JavaScript / パターン / テンプレート / パーツの対応関係が記載されていること
- `README.md` に `parts/sidebar.html` が現状未使用であることが記載されていること

## 実装整合

- `functions.php` が `init.php` の入口であることが記載されていること
- `init.php` の `cssMinify()` が `style.min.css` を生成することが記載されていること
- `cssMinify()` の対象方針と `assets/css/theme-admin.css` 除外方針が記載されていること
- `theme.json` がブロックエディター設定と既定スタイルを担うことが記載されていること

## レイアウト基準

- `rem` を基本単位とする方針が記載されていること
- 通常幅 `960px`、幅広 `1440px` が記載されていること
- 本文系フォントサイズ `1rem` の方針が記載されていること
- スマホ時の文字サイズが `theme.json` の fluid typography に従うことが記載されていること
- ブロック余白の基本運用が記載されていること

## 仕様書群

- `spec/requirements.md` に目的、対象読者、要件、制約、非ゴールが記載されていること
- `spec/design.md` に構成、読み込み設計、命名規則、レイアウト方針が記載されていること
- `spec/tasks.md` に実行可能なタスクが整理されていること
- すべての文書が日本語で統一されていること
- 文書内容が現行ファイル構成と矛盾しないこと
