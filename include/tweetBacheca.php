<?php
    /*creo uno script per creare i tweet, utilizzando ogni volta l'implementazione con html. L'obiettivo è quello di creare delle
    classi che creano il tweet utilizzando i float e i clear in CSS */
    ?>
    <div>
        <div class="tweet_bacheca">
            <div class="parte_tweet_bacheca">
                <span class="titolo_grassetto_bacheca">Username</span><p><?php
                echo $fetched_username;
                ?></p>
            </div>
            <div class="parte_tweet_bacheca">
                <span class="titolo_grassetto_bacheca">Data</span><p><?php
                echo $fetched_data;
                ?></p>
            </div>
            <div class="parte_tweet_bacheca">
                <span class="titolo_grassetto_bacheca">Testo</span><p><?php
                echo $fetched_testo;
                ?></p>
            </div>
        </div>
    </div>
    <?php
?> 