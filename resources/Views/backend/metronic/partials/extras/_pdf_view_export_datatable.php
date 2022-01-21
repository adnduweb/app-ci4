<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Génération PDF : <?= $controller; ?> - <?= base_url(); ?></title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
  <div class="container mt-5">

  <h2 style="height:20px">Génération PDF : <?= $controller; ?></h2>

    <table class="table">
      <thead>
        <tr>
        <?php $r = 0; foreach ($header as $field){ ?>
            <th><?= $field; ?></td>
          <?php $r++; } ?>   
        </tr>
      </thead>
      <tbody>
          <?php $i = 0; foreach ($data as $d){ ?>
              <tr>
              <?php $r = 0; foreach ($header as $field){ ?>
                <td><?= $d[$field]; ?></td>
               <?php $r++; } ?>   
            </tr>
          <?php $i++; } ?>    
      </tbody>
    </table>
  </div>
</body>

</html>