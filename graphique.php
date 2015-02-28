<?php
include 'sql.php';
include 'head.php';

$limit = isset($_GET['limit'])? htmlspecialchars($_GET['limit']): 20;

/*generate_image($interval,$interval_type);

?>

</section>
<img src='images/graphique.png' alt='graphique' />
<p>Si l'image est plus grande que votre écran, nous vous recommandons de l'ouvrir dans un nouvel onglet.</p>

<?php
*/
?>
<script src = "statics/scripts/highcharts/js/highcharts.js"></script>
<script src = "statics/scripts/highcharts/js/modules/exporting.js"></script>


<?php

highchart($limit);

?>
<div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
</section>

<?php

include 'footer.php';
?>
