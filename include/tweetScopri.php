<?php
    /*creo uno script per creare i tweet, utilizzando ogni volta l'implementazione con html. L'obiettivo è quello di creare delle
    classi che creano il tweet utilizzando i float e i clear in CSS */
    ?>
    <div class="pattern">
        <div class="tweet">
            <div class="parte_tweet">
                <span class="titolo_grassetto">Username</span><p class="username_scopri"><?php
                echo $fetched_username;
                ?></p>
            </div>
            <div class="parte_tweet">
                <span class="titolo_grassetto">Data</span><p><?php
                echo $fetched_data;
                ?></p>
            </div>
            <div class="parte_tweet">
                <span class="titolo_grassetto">Testo</span><p><?php
                echo $fetched_testo;
                ?></p>
            </div>
        </div>
    </div>
    <?php
?> 