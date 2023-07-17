<?php
require(__DIR__."/index.php");
$expr = $argv[1];
echo eval_expr($expr);
