<?php

$conn = new PDO("odbc:lionne");

$query = $conn->query('SELECT NOM, PRENOM,  FROM CYCLISTE ORDER BY NOM');

?>
<table>
	<tr>
		<th>Nom</th>
		<th>Prénom</th>
	</tr>
<?php

foreach($query->fetchAll(PDO::FETCH_OBJ) as $cycliste)
{
    ?>
    <tr>
        <td><?= $cycliste->NOM ?></td>
        <td><?= $cycliste->PRENOM ?></td>
    </tr>
    <?php
}

?>
</table>