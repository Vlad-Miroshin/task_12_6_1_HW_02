<?php
    require dirname(__FILE__) . DIRECTORY_SEPARATOR . 'funcs.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">    
    <title>Учебное задание 12.6.1 Практика (HW-02)</title>
</head>
<body>
    <header>
        <h1 aria-label="Учебное задание">Учебное задание 12.6.1 Практика (HW-02)</h1>
    </header>

    <main>
        <div class="databox">

            <h2 aria-label="Начальные значения">Исходные данные. Разбиение. Определения пола. Сокращение имени.</h2>
            <table class="content-table">
                <thead>
                    <tr>
                        <th>fullname</th>
                        <th>job</th>
                        <th>surname</th>
                        <th>firstName</th>
                        <th>patronymic</th>
                        <th>gender</th>
                        <th>shortName</th>
                    </tr>
                </thead>

                <tbody>
                    <?php 
                        $items = getItems();

                        foreach($items as $item): 

                            $fullname = $item['fullname'];
                            $parts = getPartsFromFullname($fullname);
                            $gender = getGenderFromName($fullname);
                            $shortname = getShortName($fullname);
                    ?>
                    <tr>
                        <td><?= $fullname; ?></td>
                        <td><?= $item['job']; ?></td>
                        <td><?= $parts[0]; ?></td>
                        <td><?= $parts[1]; ?></td>
                        <td><?= $parts[2]; ?></td>
                        <td><?= $gender; ?></td>
                        <td><?= $shortname; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h2 aria-label="По и возраст">Половозрастной состав</h2>
            <table class="content-table">
                <thead>
                    <tr>
                        <th>Пол</th>
                        <th>Процент</th>
                    </tr>
                </thead>

                <tbody>
                    <?php 
                        $genders = getGenderDescription(getItems());

                        foreach($genders as $key => $value): 
                    ?>
                    <tr>
                        <td><?= $value['name']; ?></td>
                        <td><?= $value['percent'] . '%'; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
        </div>

        <div class="footer">
            <div class="copyright">
                &copy;&nbsp;<a href="https://github.com/Vlad-Miroshin">Владислав Мирошин</a>, 2024. Поток PHPPRO_22 <a href="https://skillfactory.ru/">Skillfactory</a>.
            </div>
        </div>

    </main>

</body>
</html>