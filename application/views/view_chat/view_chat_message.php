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
            <button class="form-control forum-thread-vote-input" id="vote-input[<?= $data['m_id']; ?>]" value="<?= $data['m_id']; ?>" >+</button>
            
            <!-- vote counter -->
            <div class="forum-thread-vote-count" id="vote-count[<?= $data['m_id']; ?>]">
                <?php echo ($data['vote'] !== null ? $data['vote'] : "0"); ?>
            </div>
            
        </form>
    </div>

    <!-- Thread HEAD -->
    <div class="forum-thread-head" id="forum-thread-head-view[<?= $data['m_id']; ?>]">
        <?php echo $data['m_head']; ?>
    </div>

</div>

<?php
   // FOR loop end
   }
?>