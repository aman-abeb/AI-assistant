document.addEventListener('DOMContentLoaded', function() {
    // Ensure the button and input elements exist
    const generateButton = document.getElementById('aica_generate');
    const promptInput = document.getElementById('aica_prompt');
    const resultContainer = document.getElementById('aica_result');

    if (!generateButton || !promptInput || !resultContainer) {
        console.error('Required elements not found in the DOM.');
        return;
    }

    generateButton.addEventListener('click', function() {
        const prompt = promptInput.value.trim();

        // Validate the prompt
        if (!prompt) {
            resultContainer.innerHTML = '<p style="color: red;">Please enter a prompt.</p>';
            return;
        }

        // Prepare the FormData
        const data = new FormData();
        data.append('action', 'aica_generate_content');
        data.append('prompt', prompt);
        data.append('_ajax_nonce', aica_vars.nonce);

        // Show loading state
        resultContainer.innerHTML = '<p>Generating content... Please wait.</p>';

        // Send the AJAX request
        fetch(aica_vars.ajaxurl, {
            method: 'POST',
            body: data
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.statusText);
            }
            return response.json();
        })
        .then(response => {
            if (response.success) {
                resultContainer.innerHTML = response.data;
            } else {
                resultContainer.innerHTML = '<p style="color: red;">Error: ' + response.data + '</p>';
            }
        })
        .catch(error => {
            console.error('AJAX request failed:', error);
            resultContainer.innerHTML = '<p style="color: red;">AJAX request failed: ' + error.message + '</p>';
        });
    });
});