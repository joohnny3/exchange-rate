<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <script>
        (async function apiData() {
            const res = await fetch('./api_data.php', {
                method: 'get'
            });
            const response = await res.json();
            console.log(response);
        })()
    </script>
</body>

</html>