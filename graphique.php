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
highchart($interval, $interval_type);

include 'footer.php';
?>
