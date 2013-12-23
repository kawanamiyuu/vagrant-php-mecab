<?php
/**
 * Usage:
 * cat data.txt | php example-countMeishi.php {appearances}
 */

// 解析する文章
$sentence = file_get_contents("php://stdin");

// 出現回数のしきい値
// この値以上出現した名詞を集計する
$appearances = $argv[1];

// 名詞を表す品詞ID
//  - 品詞IDの定義
//  - http://mecab.googlecode.com/svn/trunk/mecab/doc/posid.html
$meishiPosIdArr = [];
// $meishiPosIdArr[] = 36; // 名詞 サ変接続
// $meishiPosIdArr[] = 37; // 名詞 ナイ形容詞語幹
$meishiPosIdArr[] = 38; // 名詞 一般
// $meishiPosIdArr[] = 39; // 名詞 引用文字列
// $meishiPosIdArr[] = 40; // 名詞 形容動詞語幹
$meishiPosIdArr[] = 41; // 名詞 固有名詞 一般
$meishiPosIdArr[] = 42; // 名詞 固有名詞 人名 一般
$meishiPosIdArr[] = 43; // 名詞 固有名詞 人名 姓
$meishiPosIdArr[] = 44; // 名詞 固有名詞 人名 名
$meishiPosIdArr[] = 45; // 名詞 固有名詞 組織
$meishiPosIdArr[] = 46; // 名詞 固有名詞 地域 一般
$meishiPosIdArr[] = 47; // 名詞 固有名詞 地域 国
// $meishiPosIdArr[] = 48; // 名詞 数
// $meishiPosIdArr[] = 49; // 名詞 接続詞的
// $meishiPosIdArr[] = 50; // 名詞 接尾 サ変接続
// $meishiPosIdArr[] = 51; // 名詞 接尾 一般
// $meishiPosIdArr[] = 52; // 名詞 接尾 形容動詞語幹
// $meishiPosIdArr[] = 53; // 名詞 接尾 助数詞
// $meishiPosIdArr[] = 54; // 名詞 接尾 助動詞語幹
// $meishiPosIdArr[] = 55; // 名詞 接尾 人名
// $meishiPosIdArr[] = 56; // 名詞 接尾 地域
// $meishiPosIdArr[] = 57; // 名詞 接尾 特殊
// $meishiPosIdArr[] = 58; // 名詞 接尾 副詞可能
// $meishiPosIdArr[] = 59; // 名詞 代名詞 一般
// $meishiPosIdArr[] = 60; // 名詞 代名詞 縮約
// $meishiPosIdArr[] = 61; // 名詞 動詞非自立的
// $meishiPosIdArr[] = 62; // 名詞 特殊 助動詞語幹
// $meishiPosIdArr[] = 63; // 名詞 非自立 一般
// $meishiPosIdArr[] = 64; // 名詞 非自立 形容動詞語幹
// $meishiPosIdArr[] = 65; // 名詞 非自立 助動詞語幹
// $meishiPosIdArr[] = 66; // 名詞 非自立 副詞可能
// $meishiPosIdArr[] = 67; // 名詞 副詞可能

// 抽出した名詞を格納する配列
$meishiArr = [];

// =================================================
// main
// =================================================

$mecab = new MeCab_Tagger();
$nodes = $mecab->parseToNode($sentence);

foreach ($nodes as $node) {
  if ($node->getStat() === MECAB_BOS_NODE || $node->getStat() === MECAB_EOS_NODE) {
    // BOS(文頭), EOS(文末) を表す特殊な形態素
    // ※空文字なので無視する
    continue;
  }

  // 名詞を抽出する
  if (in_array($node->getPosId(), $meishiPosIdArr)) {
    $meishiArr[] = $node->getSurface();
  }
}

// 出現回数をカウント
$retArr = array_count_values($meishiArr);
// $appearances 回以上出現したものに絞り込み
$retArr = array_filter($retArr, function($v) use($appearances) {
  return ($v >= $appearances);
});
// 出現回数の降順（多い順）に並び替え
arsort($retArr, SORT_NUMERIC);

print_r($retArr);
