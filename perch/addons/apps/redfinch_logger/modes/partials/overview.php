<div class="rf-panel-row">

    <div class="rf-logger-panel">
        <strong class="rf-logger-panel__title">
            <?php echo PerchUI::icon('core/user'); ?>
            User
        </strong>
        <span class="rf-logger-panel__property">
            <?php if(is_object($user)) {
                echo $HTML->encode($user->userUsername());
            } else {
                echo $Lang->get('N/A');
            } ?>
        </span>
    </div>

    <div class="rf-logger-panel">
        <strong class="rf-logger-panel__title">
            <?php echo PerchUI::icon('core/o-signs'); ?>
            Type
        </strong>
        <span class="rf-logger-panel__property">
            <?php echo $HTML->encode($event->eventTypeFormatted()); ?>
        </span>
    </div>

    <div class="rf-logger-panel">
        <strong class="rf-logger-panel__title">
            <?php echo PerchUI::icon('core/o-tag'); ?>
            Action
        </strong>
        <span class="rf-logger-panel__property">
            <?php echo $HTML->encode($event->eventActionFormatted()); ?>
        </span>
    </div>

    <div class="rf-logger-panel">
        <strong class="rf-logger-panel__title">
            <?php echo PerchUI::icon('core/o-document'); ?>
            Subject
        </strong>
        <span class="rf-logger-panel__property">
            <?php echo $HTML->encode($event->eventSubjectTitle()); ?>
        </span>
    </div>

</div>

<?php if($event->eventSubjectContent()): ?>
    <?php echo $HTML->heading2('Content'); ?>
    <div class="rf-logger-html">
            <pre><code class="language-markup "><?php echo trim($HTML->encode($event->eventSubjectContent())); ?></code></pre>
    </div>
<?php endif; ?>

<?php if($event->eventSubjectMedia()): ?>
    <?php echo $HTML->heading2('Media'); ?>
    <div class="rf-logger-media">
        <img src="<?php echo $HTML->encode($event->eventSubjectMedia()); ?>" class="rf-logger-media__src" />
    </div>
<?php endif; ?>
