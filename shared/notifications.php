<?php
                    if(isset($_SESSION['errors'])):
                        foreach($_SESSION['errors'] as $error):
                    ?>
                     <div class="alert alert-danger">
                      <?= $error?>
                     </div>
                  
                    <?php endforeach; 
                    unset($_SESSION['errors']);
                endif;?>


<?php 
            if(isset($_SESSION['success'])):
            ?>
            <div class="alert alert-success h-10 d-flex justify-content-center align-items-center mb-5">
                <?= $_SESSION['success'];?>
                <?php unset($_SESSION['success']); ?>
            </div>
            <?php endif;?>