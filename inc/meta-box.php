<?php
// Add a meta box to the post editor
function aica_add_meta_box()
{
    add_meta_box(
        'aica_meta_box',          // ID
        'AI Content Assistant',   // Title
        'aica_meta_box_callback', // Callback
        'post',                   // Post type
        'normal',                 // Context
        'high'                    // Priority
    );
}
add_action('add_meta_boxes', 'aica_add_meta_box');

// Meta box content
function aica_meta_box_callback($post)
{
?>
    <textarea id="aica_prompt" rows="5" style="width: 100%;" placeholder="Enter your prompt here..."></textarea>
    <button id="aica_generate" class="button button-primary">Generate Content</button>
    <div id="aica_result" style="margin-top: 20px;"></div>
<?php
}
