<?php

class GoogleGenerativeAI
{
    private $apiKey;
    private $model;

    public function __construct($apiKey, $model = "gemini-1.5-flash")
    {
        $this->apiKey = $apiKey;
        $this->model = $model;
    }

    public function generateContent($prompt)
    {
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent?key=" . $this->apiKey;

        $data = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200) {
            $result = json_decode($response, true);
            if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                return $result['candidates'][0]['content']['parts'][0]['text'];
            } else {
                throw new Exception("Unexpected API response structure: " . json_encode($result));
            }
        } else {
            throw new Exception("Error generating content: " . $response);
        }
    }
}

function aica_generate_content()
{
    check_ajax_referer('aica_generate_content', '_ajax_nonce');
    $prompt = sanitize_text_field($_POST['prompt']);
    $api_key = get_option('aica_api_key');

    if (empty($api_key)) {
        wp_send_json_error('API key is missing. Please enter your API key in the plugin settings.');
    }

    try {
        $genAI = new GoogleGenerativeAI($api_key, "gemini-1.5-flash"); // Use the correct model name
        $content = $genAI->generateContent($prompt);
        wp_send_json_success($content);
    } catch (Exception $e) {
        wp_send_json_error('Error: ' . $e->getMessage());
    }
}

add_action('wp_ajax_aica_generate_content', 'aica_generate_content');
add_action('wp_ajax_nopriv_aica_generate_content', 'aica_generate_content'); // For non-logged in users