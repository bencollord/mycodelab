<?php

$this->stylesheets = [CSS_PATH . 'bootstrap.min.css',
                      CSS_PATH . 'bootstrap-theme.min.css'];
$this->scripts     = [JS_PATH . 'jquery.min.js',
                      JS_PATH . 'bootstrap.min.js'];

?>

<!DOCTYPE html>
<html>
  <head>
    <title><?=$this->title;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php foreach($this->stylesheets as $stylesheet): ?>
    <link href="<?=$stylesheet;?>" rel="stylesheet" type="text/css" />
  <?php endforeach; ?>
  </head>
  <body>
    
    <?php if($header): ?>
      <header>
        <?php print $header; ?>
      </header>
    <?php endif; ?>

    <?php if($content): ?>
      <main>
        <?php print $content; ?>
      </main>
    <?php endif; ?>

    <?php if($footer): ?>
      <footer>
        <?php print $footer; ?>
      </footer>
    <?php endif; ?>
    
  <?php foreach($this->scripts as $script): ?>
    <script src="<?=$script;?>" type="text/javascript"></script>
  <?php endforeach; ?>
  </body>
</html>