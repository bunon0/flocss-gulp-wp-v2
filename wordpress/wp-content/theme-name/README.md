## gulpテンプレート - wordpressオリジナルテーマ作成用
<br>

## 1. 主な概要
- 【wordpress】CMS
- 【scss】cssの拡張
- 【jQuery】javascriptのライブラリ
- 【volta】node,npmのversion管理に使っています。
<br>npmとnodeのバーションはpackage.jsonに記載があります。
<br>

## 2. フォーマッターや、構文解析ツール、トランスパイル
- 【eslint】jsのコードの解析
- 【stylelint】cssのコードの解析
- 【prettier】html,css,jsなどの各ファイルを整形
- 【babel】jsのトランスパイル
- 【rollup】jsファイルのバンドル
<br>

## 3. 各ディレクトリ - ファイルの説明
### ```/.vscode/```
vscodeの設定ファイルが入っています。<br>
### ```/dev/```
開発用のディレクトリです。phpファイル以外はここでコーディングをします

【dev配下のディレクトリ】
- ```/dev/node_modules/```
  - インストールしたnodeのpackage郡です。
- ```/dev/assets/```
  - 開発用のアセットファイルを格納するディレクトリです。assets/assetsディレクトリにコンパイルされます。
- ```/dev/assets/css/```
  - 開発用のCSSファイルを格納するディレクトリです。スライダーなどのライブラリファイルを格納する用です。
- ```/dev/assets/images/```
  - 開発用の画像ファイルを格納するディレクトリです。
- ```/dev/assets/js/```
  - 開発用のjsファイルを格納する場所です。
- ```/dev/assets/scss/```
  - 開発用のscssファイルを格納する場所です。cssにコンパイルされます。

【dev配下のファイル】
- ```.browserslistrc```
  - 【jsのトランスパイラbabel】の設定ファイルです。<br>
  gulpでjsファイルをコンパイルする際に、設定に応じた出力方法をしてくれます。IEは設定から外しています。
- ```.eslintignore```
  - eslintでjsの構文解析を除外するファイルを設定します。
- ```.eslintrc.js```
  - 【jsの構文の解析eslint】の設定ファイルです。
- ```.gitignore```
  - gitから除外するファイルを設定します。
- ```.prettierignore```
  - prettierの整形から除外したいファイルを設定します。
- ```.prettierrc.js```
  - フォーマッターprettierの設定ファイルです。
- ```.stylelintrc.js```
  - 【cssの構文解析ツールstylelint】の設定を行うファイルです。
- ```gulpfile.js```
  - 【gulpタスクの設定を行うファイルです。】
- ```package-lock.json```
  - npmでインストールされたpackageの詳細が記載してあるファイルです。
- ```package.json```
  - npmでインストールしたpackageや設定をが出来るファイルです。
<br>

### ```/assets/```
最終的にgulpで開発ファイルを出力するディレクトリです。
<br>

- ```/assets/```
  - 本番環境用のアセットファイルを格納するディレクトリです。
  開発環境のassetsディレクトリがコンパイルされるディレクトリです。
- ```/assets/css/```
  - 本番環境用のcssファイルを格納するディレクトリです。開発環境のassets/cssディレクトリとassets/scssディレクトリのファイルがコンパイルされます。
- ```/assets/images/```
  - 本番環境用の画像ファイルを格納するディレクトリです。開発環境のassets/imagesディレクトリのファイルががコピーされます。
- ```/assets/js/```
  - 本番環境用のjsファイルを格納するディレクトリです。開発環境のassets/jsディレクトリのファイルがコンパイルされます。
<br>

## 4. 利用方法
<span style="color:red;">※</span> 開発は、```/dev/```ディレクトリにて行います。`/`直下のディレクトリだと、gulpが動作しないので注意してください。
<br>

### 各パッケージのインストール
```
npm install
```
package.jsonで設定されている各パッケージをローカルにインストールします。<br>
```/dev/node_modules/```が作成されます。

### ローカルサーバーの起動
```
npm run start
```
コマンド実行時に```/assets/```ディレクトリを削除して、開発環境用で```/dev/```配下のディレクトリやファイルを``/assets/``ディレクトリにコンパイルします。<br>
  ```/dev/assets/```配下のファイルと、```/dev/ejs```ファイルを監視します。変更があればホットリロードを行います。

### 開発環境用にディレクトリ・ファイルをコンパイル
```
npm run dev
```
```/assets/```ディレクトリを削除して、開発環境用で```/dev/```配下のディレクトリやファイルを``/assets/``ディレクトリにコンパイルします。

### 本番環境用にディレクトリ・ファイルをコンパイル
```
npm run build
```
```/assets/```ディレクトリを削除して、本番環境用に```/dev/```配下のディレクトリやファイルを```/assets/```ディレクトリにコンパイルします。
<br>

### 開発環境用と、本番環境用の違い
【開発環境用】
+ css,jsファイルのソースマップを出力して圧縮は行いません。

【本番環境用】
+ css,jsファイルの圧縮を行いソースマップは出力しません。
+ 圧縮しない場合は、```gulpfile.js```の下記部分をコメントアウトしてください。

```
/* ----------------------------
 * gulpタスク - scssのコンパイル
 * ---------------------------- */
const compileSass = done => {
  gulp
    |
    |
    省略
    |
    |
     //本番環境圧縮なしの場合は、コメントアウト
    .pipe(mode.production(cleanCss()))
  done();
};

```
```
/* ----------------------------
 * gulpタスク - jsのコンパイル
 * ---------------------------- */
const compileJs = done => {
  gulp
    |
    |
    省略
    |
    |
    .pipe(mode.production(uglify())) //本番環境圧縮なしの場合は、コメントアウト
  done();
};
```
<br>

## 5. vscodeで必要な拡張機能
```ESLint```
+ jsのコードをチェックして解析を行ってくれるツール

```Stylelint```
+ css,scssのコードをチェックして解析を行ってくれるツール

```Prettier - Code formatter```
+ 各ファイルhtml,css,jsのコードを整形してくれるツール

```EJS language support```
+ vscodeはデフォルトで言語サポートにejsがないので、対応するためのツール