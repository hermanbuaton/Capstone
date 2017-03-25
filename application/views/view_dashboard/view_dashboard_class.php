<?php
    // FOR loop start
    foreach ($row as $data) {
?>

<!-- Panel START -->
<div class="panel panel-default">

    <div class="panel-heading" data-toggle="collapse" data-parent="#dashboard-class-list" href="#dashboard-class-panel-<?= $data['class_id']; ?>">
        <div class="pull-right">
            <i class="fa fa-caret-down"></i>
        </div>
        <h4 class="panel-title">
            <a href="#dashboard-class-panel-<?= $data['class_id']; ?>" data-toggle="collapse" data-parent="#dashboard-class-list">
                <!-- TODO: Class Code -->
                <?= $data['course_code'] . ' - ' . $data['class_code'] . 
                    ' (' . $data['sem_name'] . ')'; ?>
            </a>
        </h4>
    </div>

    <div class="panel-collapse collapse" id="dashboard-class-panel-<?= $data['class_id']; ?>">
    <div class="lect-panel panel-body">
        <div class="lect-list-head">
            <div class="pull-right">
            <form class="lect-create-toggle">
                <!-- Class id -->
                <input class="form-control respond-control" type="hidden" name="lect-create-id" id="lect-create-id" value="<?= $data['class_id']; ?>" autocomplete="off"></input>
                <!-- Class name -->
                <input class="form-control respond-control" type="hidden" name="lect-create-name" id="lect-create-name" value="<?= $data['course_code'] . ' - ' . $data['class_code'] . ' (' . $data['sem_name'] . ')'; ?>" autocomplete="off"></input>
                <!-- button -->
                <button type="submit" class="btn btn-primary lect-create-btn">
                    <small>+ Session</small>
                </button>
            </form>
            </div>
            <h5>
                <i class="fa fa-fw fa-briefcase"></i>
                Lectures
            </h5>
        </div>

        <div class="lect-list list-group">

            <!-- Sessions -->
            <?php 
                $lecture = $data['lecture'];
                
                if (sizeOf($lecture) == 0) {
            ?>
                
                <!-- A message to tell user there are 0 lect -->
                <h5 style="text-align: center; margin-top: 15px; margin-bottom: 15px;">
                    There is no lecture yet.
                </h5>
                
            <?php
                } else {
                    foreach ($lecture as $item) {
            ?>
                
                <!-- A message to tell user there are 0 lect -->
                <!-- TODO: Link to /Chat -->
                <a href="<?php echo base_url('Chat/' . $item['lect_ref']); ?>" class="lect-item list-group-item" id="dashboard-lect-item-<?= $item['lect_id']; ?>">
                    <span class="badge"><?= $item['lect_start']; ?></span>
                    <i class="fa fa-fw fa-book"></i>
                    <?= $item['lect_name']; ?>
                </a>
                
            <?php 
                    }
                }
            ?>

        </div>
    </div>
    </div>

</div>
<!-- Panel END -->

<?php
   // FOR loop end
   }
?>