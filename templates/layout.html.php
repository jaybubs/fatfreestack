<!DOCTYPE html>
<html lang="en">
  <head>

    <!-- Basic Page Needs -->
    <meta charset="utf-8">
    <title>Your page title here :)</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- FONT -->
    <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/normalize.css">
    <link rel="stylesheet" href="../assets/css/jjframework.css">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../assets/images/favicon.png">

  </head>
    <body>

        <?php include 'header.html.php'; ?>

        <banner>
<!-- replace with flexible output -->

          <div class="banner-text">
            <h2>Banner text</h2>
          </div>
        </banner>

        <article>
<!-- this should also be replaceable -->

          <container>
            <card class="main">
              <card class="item">
                <h3>
                  this layout is now included 
                </h3>
              </card>
            </card>
          </container>

        <container>
          <card class="main">
          
          <p>
            Here goes $output:.</br>
            <?=$output?>
            <?=var_dump($output)?>
          </p>

          </card>
        <container>
        </article>
        <?php include 'footer.html.php'; ?>
    </body>
</html>

