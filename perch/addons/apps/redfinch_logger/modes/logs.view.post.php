<?php

// Title
echo $HTML->title_panel([
    'heading' => $Lang->get('Details'),
], $CurrentUser);

// Smart bar
$Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

$Smartbar->add_item([
    'active' => $activeSection === 'default',
    'title'  => 'Latest',
    'link'   => '/addons/apps/redfinch_logger/view/?id=' . $event->id(),
    'icon' => 'core/document'
]);

if(PerchUtil::count($history)) {
    $Smartbar->add_item([
        'active' => $activeSection === 'history',
        'title'  => 'History',
        'link'   => '/addons/apps/redfinch_logger/view/?id=' . $event->id() . '&section=history',
        'icon'   => 'core/clock'
    ]);
}

echo $Smartbar->render();

?>

<?php if($activeSection === 'default'): ?>

    <div class="rf-panel-row">

        <div class="rf-logger-panel">
            <strong class="rf-logger-panel__title">
                <?php echo PerchUI::icon('core/user'); ?>
                User
            </strong>
            <span class="rf-logger-panel__property">
                <?php echo $HTML->encode($user->userUsername()); ?>
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
            <code>
                <?php echo $HTML->encode($event->eventSubjectContent()); ?>
            </code>
        </div>
    <?php endif; ?>

    <?php if($event->eventSubjectMedia()): ?>
        <?php echo $HTML->heading2('Media'); ?>
        <div class="rf-logger-media">
            <img src="<?php echo $HTML->encode($event->eventSubjectMedia()); ?>" class="rf-logger-media__src" />
        </div>
    <?php endif; ?>

<?php endif; ?>

<?php if($activeSection === 'history') {
    echo $HTML->heading2('History');

    if(PerchUtil::count($history)) {
        foreach($history as $index => $revision) {
            $current_revision = $revision;
            $previous_revision = isset($history[$index + 1]) ? $history[$index + 1] : false;

            $this_html = $Template->render($revision->to_array());
            $prev_html = $previous_revision ? $Template->render($previous_revision->to_array()) : '';

            if($this_html !== $prev_html) {
                echo '<div class="rf-logger-changelog">';
                    echo '<h4 class="rf-logger-changelog__title">' . $revision->eventTriggered() . '</h4>';
                    echo '<div class="rf-logger-html rf-logger-html--embedded">';
                        echo '<code>';
                            echo html_diff($prev_html, $this_html);
                        echo '</code>';
                    echo '</div>';
                echo '</div>';
            }
        }
    }

} ?>
