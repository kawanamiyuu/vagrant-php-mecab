<?php

$str = "坊主がびょうぶに上手に坊主の絵を書いた";

$mecab = new MeCab_Tagger();

$nodes = $mecab->parseToNode($str);

foreach ($nodes as $node) {
  print_r($node->toArray());
}
