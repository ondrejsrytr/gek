<?php
define('ROOT', "/3w/users/g/gek.wz.cz/web/");
include_once ROOT . "classes/User.php";
include ROOT . "session.php";
?>
<!doctype html>
<html lang="cs">

<head>
    <title>Hlavní stránka</title>
    <?php
    include ROOT . "layout/head.php";
    ?>
</head>

<body>
    <?php
    include ROOT . "layout/navbar.php";
    ?>


<main>
    <nav class="navbar navbar-expand-lg navbar-light mt-3">
        <div class="container">
            <a class="navbar-brand">Članky</a>

            <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
                <ul class="navbar-nav ml-auto">

                    <select class="custom-select">
                        <option>podle abecedy</option>
                        <option>od nejnovějších</option>
                        <option>od nejstarších</option>
                    </select>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container" id="articles">
    </div>
</main>

    <?php
    include ROOT . "layout/footer.php";
    ?>
<script>
    let articles = '';

    for (let i = 0; i < 9; i++) {
        articles += `
        ${i % 3 == 0 ? '<div class="row mt-4 mb-4">' : ''}
          <div class="col-sm">
            <div class="card">
              <img class="card-img-top" src="https://ca-times.brightspotcdn.com/dims4/default/423fc28/2147483647/strip/true/crop/958x539+1+0/resize/1200x675!/quality/90/?url=https%3A%2F%2Fcalifornia-times-brightspot.s3.amazonaws.com%2Fc9%2F98%2Ffa3b0cb001e3541c5818a89cd5cc%2Fla-1475087498-snap-photo" alt="Card image cap">
              <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
              </div>
            </div>
          </div>
        ${i % 3 == 2 ? '</div>' : ''}
      `;
    }

    $("#articles").append(articles);
</script>
</body>

</html>