<?php
    // FOR loop start
    foreach ($row as $data) {
?>

<!-- ** Messages here ** -->
<!-- ** Change div CLASS & ID in view_chat_footer script ** -->

<div class="forum-message" id="forum-message-view[<?= $data['m_id']; ?>]" value="<?= $data['m_id']; ?>">
    <!-- Vote btn & counter -->
    <div class="forum-thread-vote pull-left">
        
        
        <!-- Vote form -->
        <form class="forum-thread-vote-form" id="vote-form[<?= $data['m_id']; ?>]" action="">
            
            <!-- message id -->
            <input class="form-control forum-thread-vote-message" type="hidden" name="vote-message" id="vote-message[<?= $data['m_id']; ?>]" value="<?php echo $data['m_id']; ?>" autocomplete="off"></input>
                
            <!-- vote value : +1 | -1 -->
            <input class="form-control forum-thread-vote-value" type="hidden" name="vote-value" id="vote-value[<?= $data['m_id']; ?>]" value="" autocomplete="off"></input>
            
            <!-- vote button -->
            <button class="btn btn-default form-control forum-thread-vote-input <?php echo ($data['user_vote'] > 0 ? 'forum-social-control' : 'forum-social-control-fade'); ?>" type="submit" id="vote-input[<?= $data['m_id']; ?>]" value="<?= $data['m_id']; ?>" >
                <span class="forum-social-content" id="vote-text[<?= $data['m_id']; ?>]">
                    <i class="fa fa-plus-square"></i>
                </span>
                <span class="forum-thread-vote-count forum-social-content" id="vote-count[<?= $data['m_id']; ?>]">
                    <?php echo ($data['sum_vote'] !== null ? $data['sum_vote'] : "0"); ?>
                </span>
            </button>
            
        </form>
        
        
        <!-- Raise Hand Form -->
        <form class="forum-thread-hand-form" id="hand-form[<?= $data['m_id']; ?>]" action="">
            
            <!-- message id -->
            <input class="form-control forum-thread-hand-message" type="hidden" name="hand-message" id="hand-message[<?= $data['m_id']; ?>]" value="<?php echo $data['m_id']; ?>" autocomplete="off"></input>
                
            <!-- vote value : +1 | -1 -->
            <input class="form-control forum-thread-hand-value" type="hidden" name="hand-value" id="hand-value[<?= $data['m_id']; ?>]" value="" autocomplete="off"></input>
            
            <!-- raise hand button -->
            <button class="btn btn-default form-control forum-thread-hand-input <?php echo ($data['user_hand'] > 0 ? 'forum-social-control' : 'forum-social-control-fade'); ?>" type="submit" id="hand-input[<?= $data['m_id']; ?>]" value="<?= $data['m_id']; ?>" >
                <span class="forum-social-content" id="hand-text[<?= $data['m_id']; ?>]">
                    <i class="fa fa-hand-paper-o"></i>
                </span>
                <span class="forum-thread-hand-count forum-social-content" id="hand-count[<?= $data['m_id']; ?>]">
                    <?php echo ($data['sum_hand'] !== null ? $data['sum_hand'] : "0"); ?>
                </span>
            </button>
            
        </form>
        
        
    </div>

    <!-- Thread HEAD -->
    <div class="forum-thread-head" id="forum-thread-head-view[<?= $data['m_id']; ?>]">
        <?php echo $data['m_head']; ?>
    </div>
    
    <!-- Thread BODY -->
    <div class="forum-thread-body hidden" id="forum-thread-body-view[<?= $data['m_id']; ?>]">
        <?php echo $data['m_body']; ?>
    </div>
    
    <!-- Thread LABEL -->
    <div class="forum-thread-label" id="forum-thread-label-view[<?= $data['m_id']; ?>]">
        <?php
            $labels = $data['labels'];
            foreach ($labels AS $label) {
        ?>
            <span class="badge forum-thread-label-badge">
                <?= $label['label']; ?>
            </span>
        <?php
            }
        ?>
    </div>
    
</div>

<?php
   // FOR loop end
   }
?>