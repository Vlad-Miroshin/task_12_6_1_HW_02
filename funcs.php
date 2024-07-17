<?php
    //include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'data.php';

// полный список персон
function getItems() {
    //return $example_persons_array;
    return [
        [
            'fullname' => 'Иванов Иван Иванович',
            'job' => 'tester',
        ],
        [
            'fullname' => 'Степанова Наталья Степановна',
            'job' => 'frontend-developer',
        ],
        [
            'fullname' => 'Пащенко Владимир Александрович',
            'job' => 'analyst',
        ],
        [
            'fullname' => 'Громов Александр Иванович',
            'job' => 'fullstack-developer',
        ],
        [
            'fullname' => 'Славин Семён Сергеевич',
            'job' => 'analyst',
        ],
        [
            'fullname' => 'Цой Владимир Антонович',
            'job' => 'frontend-developer',
        ],
        [
            'fullname' => 'Быстрая Юлия Сергеевна',
            'job' => 'PR-manager',
        ],
        [
            'fullname' => 'Шматко Антонина Сергеевна',
            'job' => 'HR-manager',
        ],
        [
            'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
            'job' => 'analyst',
        ],
        [
            'fullname' => 'Бардо Жаклин Фёдоровна',
            'job' => 'android-developer',
        ],
        [
            'fullname' => 'Шварцнегер Арнольд Густавович',
            'job' => 'babysitter',
        ],
    ];    
};

// возвращает массив из 3 элементов: Фамилия, Имя, Отчество
function getPartsFromFullname($fullname) {
    if ($fullname) {
        $items = [];

        $parts = explode(' ', $fullname);
        foreach($parts as $p) {
            if (trim($p)) {
                $items[] = $p;

                if (count($items) === 3)
                    break;
            }
        }

        while (count($items) < 3) {
            $items[] = '';
        }

        return $items;
    } else {
        return ['', '', ''];
    }
};

// возвращает склеенные через пробел элементы полного имени
function getFullnameFromParts($fam = '', $im = '', $ot = '') {
    $res = $fam.' '.$im.' '.$ot;
    return trim($res);
};

// возвращает сокращённое имя
function getShortName($fullname) {
    $parts = getPartsFromFullname($fullname);

    return $parts[1] . ' ' . mb_strtoupper(mb_substr($parts[0], 0, 1)) . '.';
}

// пытается определить пол по элементам имени
function getGenderFromName($fullname) {
    $parts = getPartsFromFullname($fullname);

    $fam = mb_strtolower($parts[0]);
    $im = mb_strtolower($parts[1]);
    $ot = mb_strtolower($parts[2]);

    $g = 0;

    // признаки женского пола
    if (str_ends_with($ot, 'вна')) {
        $g--;
    }
    if (str_ends_with($im, 'а')) {
        $g--;
    }
    if (str_ends_with($fam, 'ва')) {
        $g--;
    }

    // признаки мужского пола
    if (str_ends_with($ot, 'ич')) {
        $g++;
    }
    if (str_ends_with($im, 'й') || str_ends_with($im, 'н')) {
        $g++;
    }
    if (str_ends_with($fam, 'в')) {
        $g++;
    }

    if ($g < 0)
        return -1;
    else if ($g > 0)
        return 1;
    else
        return 0;
};

function getGenderDescription($items) {
    $counters = [];

    $total = 0;
    foreach ($items as $item) {
        $g = getGenderFromName($item['fullname']);

        if (array_key_exists($g, $counters)) {
            $counters[$g] = $counters[$g] + 1;
        } else {
            $counters[$g] = 1;
        }

        $total++;
    }

    $res = [];

    $keys = array_keys($counters);
    foreach ($keys as $key) {
        $res[$key] = ['name' => getGenderName($key), 'percent' => round(($counters[$key] / $total) * 100, 1)];
    };

    return $res;
};

function getGenderName($g) {
    if ($g === 1)
        return 'Мужской';
    else if ($g === -1)
        return 'Женский';
    else
        return 'Не определён';
};

