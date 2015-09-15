<?php
include_once 'ViewDescriptor.php';
?>
    <!DOCTYPE html>
    <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=utf-8">
            <title><?= $vd->getTitolo() ?></title>
            <link rel="shortcut icon" type="image/x-icon" href="../immagini/fitness.png">
            <meta name="description" content="Pagina gestione login dei due ruoli">
            <link href="../css/layout.css" rel="stylesheet" type="text/css" media="screen"> 
            <?php
            foreach ($vd->getScripts() as $script) {
                ?>
                <script type="text/javascript" src="<?= $script ?>"></script>
                <?php
            }
            ?>
        </head>
        <body>
            <div id="pagina">
                <header>
                    <div class="social">
                        <ul>
                            <li id="facebook"><a href="https://www.facebook.com">facebook</a></li>
                            <li id="twitter"><a href="https://twitter.com/">twitter</a></li>
                        </ul>
                    </div>
                    <div id="header">
                        <div id="logo">
                            <h1>BsB center the Temple of Fitness</h1>
                        </div>
                        <select class="menu">
                            <?php
                            $Menu1 = $vd->getMenu();
                            require "$Menu1";
                            ?>
                        </select>
                        <div id="menu">
                            <?php
                            $menu = $vd->getMenu();
                            require "$menu";
                            ?>
                        </div>
                    </div>
                </header>
                <div id="sidebar1">
                    <ul>
                        <li id="categorie">
                            <?php
                           $left = $vd->getLeftBar();
                           require "$left";
                            ?>
                        </li>
                        <li id="esterno">
                            <h2>Vedi anche</h2>
                            <ul>
                                <li><a href="http://www.musclenutrition.com/products/proteine.html" target="_blank" > Muscle Nutrition </a></li>
                                <li><a href="http://www.fitness-bosi.it/index.php?cPath=46" target="_blank" > Fitness </a></li>
                                <li><a href="http://crossfit-italia.com/" target="_blank"> CrossFit Italia </a></li>
                                <li><a href="http://www.federnuoto.it/discipline/nuoto.html" target="_blank" > Nuoto </a></li>
                                <li><a href="http://sport.shopalike.it/sport-da-combattimento-boxe/" target="_blank" > Box attrezzi </a></li>
                                <li><a href="http://www.federdanza.it/" target="_blank"> Danza </a></li>
                            </ul>
                        </li>

                    </ul>
                </div>

                <div id="sidebar2">
                    <?php
                    $right = $vd->getRightBar();
                    require "$right";
                    ?>
                </div>
                <div id="content">
                    <?php
                    $content = $vd->getContent();
                    require "$content";
                    ?>
                </div>
                <a id ="segnalibro">
                <footer>
                    <div id="footer">
                        <hr>
                            <b>BsB center the Temple of Fitness</b>
                            <br><br>
                                <p class="contatti">
                                    <b> Tel: </b>  0781 60 958 <br>
                                    <b> Cell: </b> 123 4568 125 <br>
                                    <b> E-mail: </b> bsbfitness@hotmail.it <br><br>
                                </p>
                    </div>
                </footer>
                </a>
            </div>
        </body>
    </html>
 




