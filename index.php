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

            <table class="content-table">
                <caption aria-label="Начальные значения">Исходные данные. Разбиение. Определения пола. Сокращение имени.</caption>
                <thead>
                    <tr>
                        <th>Полное имя</th>
                        <th>Профессия</th>
                        <th>Фамилия</th>
                        <th>Имя</th>
                        <th>Отчество</th>
                        <th>Пол</th>
                        <th>Сокращение</th>
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
                        <td class="column-center"><?= $gender; ?></td>
                        <td><?= $shortname; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <table class="content-table">
                <caption aria-label="Распределение">Гендерный состав.</caption>
                <thead>
                    <tr>
                        <th>Пол</th>
                        <th>Количество</th>
                        <th>Процент</th>
                    </tr>
                </thead>

                <tbody>
                    <?php 
                        $genders = getGenderDescription(getItems());

                        foreach($genders as $key => $value): 
                    ?>
                    <tr>
                        <td class="column-center"><?= $value['name']; ?></td>
                        <td class="column-center"><?= $value['count']; ?></td>
                        <td class="column-center"><?= $value['percent'] . '%'; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <table class="content-table">
                <caption aria-label="Выбор">Подбор идеальной пары.</caption>
                <thead>
                    <tr>
                        <th>Партнёр 1</th>
                        <th>Партнёр 2</th>
                        <th>Результат</th>
                    </tr>
                </thead>

                <tbody>
                    <?php 
                        $items = getItems();
                        shuffle($items);

                        foreach($items as $item): 
                            $fullname = $item['fullname'];
                            $parts = getPartsFromFullname($fullname);

                            $cmp = getPerfectPartner($parts[0], $parts[1], $parts[2], $items);
                    ?>
                    <tr>
                        <td><?= $cmp['short_1'] . ' ' . getGenderSym($cmp['gender_1']); ?></td>
                        <td><?= $cmp['short_2'] . ' ' . getGenderSym($cmp['gender_2']); ?></td>

                        <?php if ($cmp['success']): ?>
                            <td><?= '♡ Идеально на ' . $cmp['percent'] . '%  ♡'; ?></td>
                        <?php else: ?>
                            <td><?= $cmp['comment']; ?></td>
                        <?php endif; ?>
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