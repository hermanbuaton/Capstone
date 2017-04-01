<?php
    // FOR loop start
    foreach ($row as $data) {
?>

<!-- ** Messages here ** -->
<!-- ** Change div CLASS & ID in view_chat_footer script ** -->

<div class="forum-message" id="forum-message-view" value="<?= $data['m_id']; ?>">
    <!-- Vote btn & counter -->
    <div class="forum-thread-vote pull-left">
        <form class="forum-thread-vote-form" id="vote-form[<?= $data['m_id']; ?>]" action="">
            
            <!-- message id -->
            <input class="form-control forum-thread-vote-message" type="hidden" name="vote-message" id="vote-message[<?= $data['m_id']; ?>]" value="<?php echo $data['m_id']; ?>" autocomplete="off"></input>
                
            <!-- vote value : +1 | -1 -->
            <input class="form-control forum-thread-vote-value" type="hidden" name="vote-value" id="vote-value[<?= $data['m_id']; ?>]" value="" autocomplete="off"></input>
            
            <!-- vote button -->
            <!-- default display: + -->
            <button class="btn btn-default form-control forum-thread-vote-input <?php echo ($data['user_vote'] > 0 ? 'forum-social-control' : 'forum-social-control-fade'); ?>" type="submit" id="vote-input[<?= $data['m_id']; ?>]" value="<?= $data['m_id']; ?>" >
                <span class="" id="vote-text[<?= $data['m_id']; ?>]">
                    <i class="fa fa-plus-square"></i>
                </span>
                <span class="forum-thread-vote-count" id="vote-count[<?= $data['m_id']; ?>]">
                    <?php echo ($data['sum_vote'] !== null ? $data['sum_vote'] : "0"); ?>
                </span>
            </button>
            
            <!--
            <button class="form-control btn-info forum-thread-vote-input" id="vote-input[<?= $data['m_id']; ?>]" value="<?= $data['m_id']; ?>" >+</button>
            
            <div class="forum-thread-vote-count" id="vote-count[<?= $data['m_id']; ?>]">
                <?php echo ($data['sum_vote'] !== null ? $data['sum_vote'] : "0"); ?>
            </div>
            -->
            
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