<?php

if(PerchUtil::count($history)) {
    foreach($history as $index => $revision) {
        $current_revision = $revision;
        $previous_revision = isset($history[$index + 1]) ? $history[$index + 1] : false;

        $this_html = $Template->render($revision->to_array());
        $prev_html = $previous_revision ? $Template->render($previous_revision->to_array()) : '';

        if($this_html !== $prev_html) {
            echo '<div class="rf-logger-changelog">';
            echo '<h4 class="rf-logger-changelog__title">' . $revision->eventTriggeredFormatted() . '</h4>';
            echo '<div class="rf-logger-html rf-logger-html--embedded">';
            echo '<pre><code class="language-markup">' . html_diff($prev_html, $this_html) . '</code></pre>';
            echo '</div>';
            echo '</div>';
        }
    }

    if ($Paging->enabled()) echo '<div class="inner">' . $HTML->paging($Paging) . '</div>';
}
