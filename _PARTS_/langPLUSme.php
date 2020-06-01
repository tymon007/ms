<?php
global $me;
$me = new Me($_SESSION['login']);
global $arrayLang;
$arrayLang = parse_ini_file('LangLib/' . $me->lang . ".ini", true);
