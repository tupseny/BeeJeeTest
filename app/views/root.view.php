<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Главная</title>
    <?php
    include ROOT_DIR . '/scripts.php';
    include ROOT_DIR . '/styles.php';


    $isLogged = isset($_COOKIE['token']) and $_COOKIE['token'] and isset($_COOKIE['user_id']) and is_numeric($_COOKIE['user_id']) ? true : false;
    ?>
</head>
<body>


<div class="pt-5 px-5 mx-5">
    <?php include VIEWS_DIR . '/include/nav-bar.php'; ?>

    <div class="py-2" id="content">
        <?php include VIEWS_DIR . '/' . $content_view; ?>
    </div>
</div>

<script>
    console.log('PHP: ' + '<?=phpversion()?>');
</script>

<?php
include_once ROOT_DIR . '/scripts/root.script.php';
include_once ROOT_DIR . '/scripts/alert.script.php';
include_once ROOT_DIR . '/scripts/navbar.script.php';

if ($this->script_file){
    $script_path = ROOT_DIR . '/scripts/' . $this->script_file;
    if (file_exists($script_path)){
        include_once $script_path;
    }
}
?>
<style>
    <?php
    if ($this->style_file){
        $style_path = ROOT_DIR . '/styles/' . $this->style_file;
        if (file_exists($style_path)){
            include_once $style_path;
        }
    }
 ?>
</style>

</body>

</html>`