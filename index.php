<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Test task</title>
		<link rel="stylesheet" href="style/style.css">
</head>
<body>
    <main class="main">
        <form action="/app/server.php" method="POST" enctype="multipart/form-data" class="form">
            <label for="img" class="label">Загрузка фото</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="15728640">
            <input type="file" name="photo" id="img">
            <input type="submit" value="Отпрвить фото" class="btn">
        </form>
    </main>
</body>
</html>

