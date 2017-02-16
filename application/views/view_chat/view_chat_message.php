<!-- ** Messages here ** -->
<!-- ** Change div CLASS & ID in view_chat_footer script ** -->

<!--
<div class="thread-message" id="main-chat-view-msg">
-->
    <!-- Vote btn & counter -->
    <div class="thread-message-vote pull-left">
        <form class="thread-message-vote-form" id="vote-form[<?= $m_id; ?>]" action="">
            
            <!-- message id -->
            <input class="form-control" type="hidden" name="vote-message" id="vote-message[<?= $m_id; ?>]" value="<?php echo $m_id; ?>" autocomplete="off"></input>
                
            <!-- vote value : +1 | -1 -->
            <input class="form-control thread-message-vote-val" type="hidden" name="vote-value" id="vote-value[<?= $m_id; ?>]" value="" autocomplete="off"></input>
            
            <!-- vote button -->
            <!-- default display: + -->
            <button class="form-control thread-message-vote-btn" id="vote-input[<?= $m_id; ?>]" value="<?= $m_id; ?>" >+</button>
            
            <!-- vote counter -->
            <div class="thread-message-vote-count" id="vote-count[<?= $m_id; ?>]">
                0
            </div>
            
        </form>
    </div>

    <!-- Thread HEAD -->
    <div class="thread-message-head" id="thread-message-head[<?= $m_id; ?>]">
        <?php echo $m_head; ?>
    </div>

<!--
</div>
-->