<?php include_once('includes/header.php');

$magazines = array(
    array(
        'title' => 'Cycle World',
        'link' => 'https://www.amazon.com/gp/product/B002PXVYD2',
        'img' => 'https://images-na.ssl-images-amazon.com/images/I/71OsAsgkRpL._SL1024_.jpg'
    ),
    array(
        'title' => 'Flying',
        'link' => 'https://www.amazon.com/gp/product/B002G551F6',
        'img' => 'https://images-na.ssl-images-amazon.com/images/I/71dTSH9Ib8L._SL1024_.jpg'
    ),
    array(
        'title' => 'Outdoor Life',
        'link' => 'https://www.amazon.com/gp/product/B002CT512O',
        'img' => 'https://images-na.ssl-images-amazon.com/images/I/71RfFoJ3XnL._SL1024_.jpg'
    ),
    array(
        'title' => 'Popular Science',
        'link' => 'https://www.amazon.com/gp/product/B002CT515Q',
        'img' => 'https://images-na.ssl-images-amazon.com/images/I/61mYJCuKuML._SL1024_.jpg'
    ),
);

for ($i=0; $i < count($magazines); $i++) {
    $magazine = $magazines[$i];
    $even = $i % 2 == 0;

    // if even start a new row
    if ($even) {
        echo '<div class="row">';
        echo '<div class="magazine col-lg-5 col-lg-offset-1 col-md-5 col-md-offset-1 col-sm-5 col-sm-offset-1 col-xs-5 col-xs-offset-1">';
    } else {
        echo '<div class="magazine col-lg-5 col-md-5 col-sm-5 col-xs-5">';
    }

    // Magazine panel header
    echo '<div class="panel-heading"><div>';
    echo "<span>{$magazine['title']}</span>";
    echo "<a class='btn btn-warning' href='{$magazine['link']}'>Buy Now</a>";
    echo '</div></div>';

    // Magazine panel body
    echo '<div class="panel-body">';
    echo "<img class='img-responsive' src='{$magazine['img']}'>";
    echo '</div>';
    echo '</div>';

    // if odd end the row
    if (!$even) {
        echo '</div>';
    }
}

include_once('includes/footer.html');
?>
