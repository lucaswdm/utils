<?php
  
  function validacao()
  {
  
  }
  
  
  if(!validacao()) geraErro("X");
  
  function geraErro($erro)
  {
      header('HTTP/1.1 500 Internal Server Error', true, 500);
      echo $erro;
      exit;
  }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello World! Site Title</title>
  </head>
  <body>
    <h1><?php echo $STATUS; ?></h1>
  </body>
</html>
