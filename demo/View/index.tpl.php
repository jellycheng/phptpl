<?php
    CjsPhptpl\PhpTpl::getInstance()->display("header");

?>

<?php

echo 'index' . PHP_EOL;
?>
<?php echo $api_url;?>
<?php
    CjsPhptpl\PhpTpl::getInstance()->display("footer");
?>