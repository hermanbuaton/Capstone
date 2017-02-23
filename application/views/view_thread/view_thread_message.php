<?php
    // FOR loop start
    foreach ($row as $data) {
?>



<!-- ** Thread Opener START ** -->
<?php 
    if ($data['m_type'] == 0):
?>
    <!-- Thread HEAD -->
    <div class="thread-opener-head" id="thread-opener-head-view">
        <div class="forum-thread-head" id="forum-thread-head-view[<?= $data['m_id']; ?>]">
            <h3><?php echo $data['m_head']; ?></h3>
        </div>
    </div>
    
<?php 
    endif;
?>
<!-- ** Thread Opener END ** -->



<!-- ** Messages START ** -->
<?php 
    if ($data['m_type'] == 0 || 
        $data['m_type'] == 1):
?>
    <div class="forum-message" id="forum-message-view" value="<?= $data['m_id']; ?>">
        <!-- Vote btn & counter -->
        <div class="forum-thread-vote pull-left">
            <form class="forum-thread-vote-form" id="vote-form[<?= $data['m_id']; ?>]" action="">

                <!-- message id -->
                <input class="form-control" type="hidden" name="vote-message" id="vote-message[<?= $data['m_id']; ?>]" value="<?php echo $data['m_id']; ?>" autocomplete="off"></input>

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

        <!-- Message BODY -->
        <div class="forum-thread-body" id="forum-thread-body-view[<?= $data['m_id']; ?>]">
            <?php echo $data['m_body']; ?>
        </div>

    </div>
<?php 
    endif;
?>
<!-- ** Messages END ** -->



<!-- ** Thread Opener START ** -->
<?php 
    if ($data['m_type'] == 0):
?>
    <!-- Thread HEAD -->
    <div class="thread-reply-head" id="thread-reply-head-view">
        <div class="" id="">
            <!-- TODO: Count no. of reply -->
            <h5> # Response</h5>
        </div>
    </div>
    
<?php 
    endif;
?>
<!-- ** Thread Opener END ** -->


<?php
   // FOR loop end
   }
?>