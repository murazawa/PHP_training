<?php

function h($string){
  return htmlspecialchars($string, ENT_QUOTES, 'utf-8');
}
