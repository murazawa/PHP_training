<?php
function checkFile($filename){
  // 拡張子チェック
  if(preg_match('/.csv/', $filename)){
    echo 'データをアップロードします。</br>';
  } else {
    echo '選択したファイルはCSVではありません。<br/>';
  }
}
