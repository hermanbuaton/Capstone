<?php
    // FOR loop start
    foreach ($row as $data) {
?>

<!-- ** Messages here ** -->
<!-- ** Change div CLASS & ID in view_chat_footer script ** -->

<div class="poll-item" id="poll-item-view" value="<?= $data['m_id']; ?>">
    
    
    <!-- RIGHT hand side -->
    <div class="social-item-content pull-right">
        <span class="badge">
            <?php 
                if ($data['m_type'] == MESSAGE_TYPE_POLL_START) {
                    echo "Started " . $data['m_time'];
                }
                elseif ($data['m_type'] == MESSAGE_TYPE_POLL_STOP) {
                    echo "Ended " . $data['m_time'];
                }
                elseif ($data['m_type'] == MESSAGE_TYPE_POLL_SAVE) {
                    echo "Not yet started";
                }
            ?>
        </span>
    </div>
    
    
    <!-- LEFT hand side -->
    <div class="social-item-content">
        <!-- ICON -->
        <span class="poll-item-status" id="poll-item-status-view[<?= $data['m_id']; ?>]" value="<?php echo ($data['u_vote'] == null ? 0 : $data['u_vote']); ?>">
            <div class="poll-item-status-value hidden" value="<?php echo ($data['u_vote'] == null ? 0 : $data['u_vote']); ?>"></div>
            <i class="fa <?php echo ($data['u_vote'] > 0 ? 'fa-check' : 'fa-arrow-circle-right'); ?>"></i>
        </span>

        <!-- Thread BODY -->
        <span class="poll-item-body" id="poll-item-body-view[<?= $data['m_id']; ?>]">
            <?= $data['m_body']; ?>
        </span>
    </div>
    
    
</div>

<?php
   // FOR loop end
   }
?>