<?php
    // FOR loop start
    foreach ($row as $data) {
?>

<!-- ** Messages here ** -->
<!-- ** Change div CLASS & ID in view_chat_footer script ** -->

<div class="social-item" id="social-item-view" value="<?= $data['u_id']; ?>">
    
    
    <!-- Select btn -->
    <div class="social-item-select pull-right">
        
        <!-- Vote form -->
        <form class="social-item-select-form" id="select-form[<?= $data['u_id']; ?>]" action="">
            
            <!-- message id -->
            <input class="form-control social-item-select-message" type="hidden" name="select-message" id="select-message[<?= $data['u_id']; ?>]" value="<?= $data['m_id']; ?>" autocomplete="off"></input>
                
            <!-- vote value : +1 | -1 -->
            <input class="form-control social-item-select-user" type="hidden" name="select-user" id="select-user[<?= $data['u_id']; ?>]" value="<?= $data['u_id']; ?>" autocomplete="off"></input>
            
            <!-- vote button -->
            <button class="btn btn-default form-control forum-thread-vote-input" type="submit" id="select-input[<?= $data['u_id']; ?>]">
                <span class="forum-social-content" id="vote-text[<?= $data['m_id']; ?>]">
                    <i class="fa fa-user"></i>
                </span>
                <span class="forum-thread-vote-count forum-social-content" id="vote-count[<?= $data['m_id']; ?>]">
                    Select
                </span>
            </button>
            
        </form>
        
    </div>
    
    
    <!-- Thread HEAD -->
    <div class="social-item-content">
        <span class="social-item-name" id="social-item-name-view[<?= $data['m_id']; ?>]">
            <?php echo $data['u_name']; ?>
        </span>

        <!-- Thread BODY -->
        <span class="social-item-score hidden" id="social-item-score-view[<?= $data['m_id']; ?>]">
            <?php echo $data['u_score']; ?>
        </span>
    </div>
    
</div>

<?php
   // FOR loop end
   }
?>