<?php
include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'data.php';

// полный список персон
function getItems() {
    // возвращаем клон массива, чтобы не влиять на исходный
    global $example_persons_array;
    return array_replace([], $example_persons_array);
};

// возвращает массив из 3 элементов: Фамилия, Имя, Отчество
function getPartsFromFullname($fullname) {
    if ($fullname) {
        $items = [];

        $parts = explode(' ', $fullname);

        // используем первые три слова (вдруг их больше?)
        // также, подавляем повторяющиеся разделители
        foreach($parts as $p) {
            if (trim($p)) {
                $items[] = mb_convert_case($p, MB_CASE_TITLE);

                if (count($items) === 3)
                    break;
            }
        }

        // если слов менее трёх - добираем
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
    $res = $fam . ' ' . $im . ' ' . $ot;
    return trim($res);
};

// возвращает сокращённое имя
function getShortName($fullname) {
    $parts = getPartsFromFullname($fullname);

    return $parts[1] . ' ' . mb_substr($parts[0], 0, 1) . '.';
}

// пытается определить пол по элементам имени
function getGenderFromName($fullname) {
    $parts = getPartsFromFullname($fullname);

    $fam = $parts[0];
    $im = $parts[1];
    $ot = $parts[2];

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

// Возвращает данные гендерного распределения
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
        $res[$key] = [
            'name' => getGenderName($key), 
            'count' => $counters[$key],
            'percent' => round(($counters[$key] / $total) * 100, 1)
        ];
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

function getGenderSym($g) {
    if ($g === 1)
        return '♂';
    else if ($g === -1)
        return '♀';
    else
        return '';
}

// Подбор идеальной пары
function getPerfectPartner($fam, $im, $ot, $items) {

    $res = [
        'gender_1' => 0,
        'short_1' => '',
        'gender_2' => 0,
        'short_2' => '',
        'percent' => 0,
        'success' => false,
        'comment' => '',
    ];

    $fullname = getFullnameFromParts($fam, $im, $ot);
    $g1 = getGenderFromName($fullname);

    $res['gender_1'] = $g1;
    $res['short_1'] = getShortName($fullname);

    // для неопределённого пола невозможно выбрать противоположный,
    // поэтому такие варианты исключаем
    if ($g1 === 0) {
        $res['comment'] = 'Невозможен подбор пары для неопределённого пола';
    } else {
        $attempt = 0;
        $partner = null;
        $max_attempt = count($items) * 2;

        do {
            
            $rnd_key = array_rand($items);
            $partner = $items[$rnd_key];
    
            $g2 = getGenderFromName($partner['fullname']);

            if (++$attempt > $max_attempt) {
                $partner = null;
                break;
            }
    
        } while ($g2 === 0 || $g2 === $g1 || $fullname === $partner['fullname']);

        if ($partner) {
            $res['gender_2'] = $g2;
            $res['short_2'] = getShortName($partner['fullname']);
            $res['percent'] = round(rand(5000, 10000) / 100, 2);
            $res['success'] = true;
        } else {
            $res['comment'] = 'Не удалось подобрать идеальную пару';
        }
    }

    return $res;
}