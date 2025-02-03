jQuery(document).ready(function($) {
    $('#aica_generate').click(function() {
        var prompt = $('#aica_prompt').val();
        var data = {
            action: 'aica_generate_content',
            prompt: prompt,
            _ajax_nonce: aica_vars.nonce // Nonce for security
        };
        $.post(aica_vars.ajaxurl, data, function(response) {
            if (response.success) {
                $('#aica_result').html(response.data);
            } else {
                $('#aica_result').html('Error: ' + response.data);
            }
        });
    });
});