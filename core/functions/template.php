<?php

  function template_path()
  {
    $chunks = array(
      realpath(''),
      'template',
      THEME_TEMPLATE
    );
    return  implode(DIRECTORY_SEPARATOR, $chunks);
  }
  function get_header()
  {
    $path_file = template_path() . DIRECTORY_SEPARATOR . 'header.php';
    if (file_exists($path_file)) {
      include($path_file);
    }
  }

  function get_footer()
  {
    $path_file = template_path() . DIRECTORY_SEPARATOR . 'footer.php';
    if (file_exists($path_file)) {
      include($path_file);
    }
  }
