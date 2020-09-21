const results = document.querySelector('.results');

results.addEventListener('click', () => {
    results.select();
});

document.addEventListener('dragover', e => {
    e.preventDefault();
});

document.addEventListener('drop', e => {
    e.preventDefault();

    const file = e.dataTransfer.files[0];
    const reader = new FileReader();

    reader.addEventListener('load', e => {
        e.preventDefault();

        try {
            results.innerHTML = `data:${file.type};base64,${btoa(
                e.target.result
            )}`;
            results.select();
        } catch (error) {
            const http = new XMLHttpRequest();

            if (file.size >> 20 < 1) {
                http.onreadystatechange = function (http) {
                    results.innerHTML = `data:${file.type};base64,${http.target.responseText}`;
                    results.select();
                };

                http.open('POST', 'encode.php');
                http.setRequestHeader(
                    'Content-Type',
                    'application/x-www-form-urlencoded'
                );
                http.send(file);
            } else {
                alert(
                    'There was an error encoding the file locally.\n\nThe file is too large (over 1MB) to upload to the server for encoding.'
                );
            }
        }
    });

    reader.readAsText(file);

    results.innerHTML = '';
});
