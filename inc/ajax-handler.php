<?php
function aica_generate_content()
{
    check_ajax_referer('aica_generate_content', '_ajax_nonce');
    $prompt = sanitize_text_field($_POST['prompt']);
    $api_key = get_option('aica_api_key');

    if (empty($api_key)) {
        wp_send_json_error('API key is missing. Please enter your OpenAI API key in the plugin settings.');
    }
    $response = wp_remote_post('https://api.openai.com/v1/completions', array(
        'headers' => array(
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $api_key // Include the API key in the headers
        ),
        'body' => json_encode(array(
            'model' => 'text-davinci-003', // or 'gpt-4'
            'prompt' => $prompt,
            'max_tokens' => 500,
            'temperature' => 0.7
        ))
    ));

    if (is_wp_error($response)) {
        wp_send_json_error('Error connecting to OpenAI: ' . $response->get_error_message());
    }

    // Parse the API response
    $body = json_decode($response['body'], true);
    if (isset($body['choices'][0]['text'])) {
        $content = $body['choices'][0]['text'];
        wp_send_json_success($content);
    } else {
        wp_send_json_error('Error: Unable to generate content. Please check your API key and prompt.');
    }
}
add_action('wp_ajax_aica_generate_content', 'aica_generate_content');
