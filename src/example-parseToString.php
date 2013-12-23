<?php

$str = "坊主がびょうぶに上手に坊主の絵を書いた";

$mecab = new MeCab_Tagger();

$ret = $mecab->parseToString($str);

print_r($ret);

