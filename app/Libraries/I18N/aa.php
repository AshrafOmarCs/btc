 <?php
    error_reporting(E_STRICT);
$time_start = microtime(true);

require 'Arabic.php';
$Arabic = new I18N_Arabic('Numbers');

$number = 801928.05;
    $text   = $Arabic->money2str($number, 'SAR', 'ar');

    echo "<p dir=ltr align=center>$number<br />$text</p>";
?>