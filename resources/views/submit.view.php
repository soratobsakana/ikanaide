<?php
    require('app/controllers/anime.php');
?>

<form action="app/controllers/submit.php" method="POST" class="submit-form">
    <div class="submit-form_title">Edit or add information to the database. A moderator will review it and inform you about any possible changes. Thanks for the effort!</div>

    <?php
        // Este foreach introduce en dos arrays las columnas y valores que quiero mostrar en la página de submit.view.php (provenientes del array $animeInfo del controlador 'anime.php').
        // Su propósito es printear el HTML de abajo (mediante un for) tantas veces como valores quiero en el array de $animeForm.
        foreach ($animeInfo as $key => $value) {
            if (!($key == 'members' || $key == 'favorited' || $key == 'anime_id')) {
                if (strpos($key, '_') > 0) {
                    $key = str_replace('_', ' ', $key);
                }
                $animeForm[] = $key;
                if (!($key === 'cover' || $key === 'header')) {
                    $animeFormValues[] = $value;
                } else {
                    // Añado el string 'image' al array para hacer usarlo en un condicional después. El objetivo es usar un placeholder en el input de las imagenes y no el por defecto, que sería un value=ruta de la imagen en el sistema.
                    $animeFormValues[] = 'image';
                }
            }
        }

        for ($i=0;$i<count($animeForm);$i++) {
            ?>
            <div class="submit-form_wrapper box">
                <label for="<?=$animeForm[$i]?>"><?=$animeForm[$i]?></label>
                <?php
                    if ($animeFormValues[$i] !== 'image') {
                        ?><input type="text" name="<?=$animeForm[$i]?>" id="<?=$animeForm[$i]?>" value="<?=$animeFormValues[$i]?>"><?php
                    } else {
                        ?><input type="text" name="<?=$animeForm[$i]?>" id="<?=$animeForm[$i]?>" placeholder="Please provide a link for your image."><?php
                    }
                ?>

            </div>
            <?php
        }
    ?>

    <input class="box" type="submit" value="Submit the entry" name="submit">
</form>