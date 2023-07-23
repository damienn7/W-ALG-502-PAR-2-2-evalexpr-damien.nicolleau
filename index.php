<?php

// principale fonction de l'evalexpr alogorithme
function eval_expr($expr)
{
    // condition pour que l'array soit initialisé ou mis à jour avec la récursivité de la fonction

    $numbers = array();
    $array = str_split(str_replace(" ", "", $expr));
    $res = "";
    $operators = array();
    $operators_values = array('-', '+', '/', '*', '%');
    $number = "";
    $counter = 0;
    $count = false;
    foreach ($array as $key => $value) {
        if ($value === "(") {
            $count = true;
            array_push($operators, $value);
        }

        if ($count === true) {
            $counter++;
        }

        if ($value === ")") {
            $count = false;
            $res = 0;
            $prev = $numbers[count($numbers) - 2];
            $last = $numbers[count($numbers) - 1];
            array_push($numbers, array_pop($operators));
            $opera = $numbers[count($numbers) - 1];
            switch ($opera) {
                case '+':
                    $res = intval($prev) + intval($last);
                    $numbers[count($numbers) - 3] = "";
                    $numbers[count($numbers) - 2] = "";
                    $numbers[count($numbers) - 1] = "";
                    $arrays = update_array($numbers, $operators);
                    $numbers = $arrays[0];
                    $operators = $arrays[1];
                    array_push($numbers, $res);
                    break;
                case '-':
                    $res = intval($prev) - intval($last);
                    $numbers[count($numbers) - 3] = "";
                    $numbers[count($numbers) - 2] = "";
                    $numbers[count($numbers) - 1] = "";
                    $arrays = update_array($numbers, $operators);
                    $numbers = $arrays[0];
                    $operators = $arrays[1];
                    array_push($numbers, $res);
                    break;
                case '*':
                    $res = intval($prev) * intval($last);
                    $numbers[count($numbers) - 3] = "";
                    $numbers[count($numbers) - 2] = "";
                    $numbers[count($numbers) - 1] = "";
                    $arrays = update_array($numbers, $operators);
                    $numbers = $arrays[0];
                    $operators = $arrays[1];
                    array_push($numbers, $res);
                    break;
                case '/':
                    $res = intval($prev) / intval($last);
                    $numbers[count($numbers) - 3] = "";
                    $numbers[count($numbers) - 2] = "";
                    $numbers[count($numbers) - 1] = "";
                    $arrays = update_array($numbers, $operators);
                    $numbers = $arrays[0];
                    $operators = $arrays[1];
                    array_push($numbers, $res);
                    break;
                case '%':
                    $res = intval($prev) % intval($last);
                    $numbers[count($numbers) - 3] = "";
                    $numbers[count($numbers) - 2] = "";
                    $numbers[count($numbers) - 1] = "";

                    $arrays = update_array($numbers, $operators);
                    $numbers = $arrays[0];
                    $operators = $arrays[1];
                    array_push($numbers, $res);
                    break;
                case '(':
                    array_pop($numbers);
                    array_push($numbers, $res);
                    break;
                default:

                    break;
            }
            $counter = 0;
        }

        if (is_numeric($value) && is_numeric($array[$key + 1])) {
            $number .= $value;
        }

        if (in_array($value, $operators_values)) {
            array_push($operators, $value);
        }

        if (is_numeric($value) && !is_numeric($array[$key + 1])) {
            if ($number !== "") {
                $number .= $value;
                array_push($numbers, $number);
            } else {
                array_push($numbers, $value);
            }
            $number = "";
        }
    }

    $i = 0;
    while ($i < count($numbers) + 1) {
        if (count($numbers) > 2 && $numbers[count($numbers) - 1] <= -1) {
            $pop_negative = array_pop($numbers);
            array_unshift($numbers, $pop_negative);
            $operators = array_reverse($operators);
        }
        $prev = $numbers[count($numbers) - 2];
        $last = $numbers[count($numbers) - 1];
        array_push($numbers, $operators[count($operators) - 1]);
        $opera = $numbers[count($numbers) - 1];

        $res = 0;
        switch ($opera) {
            case '+':
                $res = intval($prev) + intval($last);
                if (count($numbers) > 2) {
                    $numbers[count($numbers) - 3] = "";
                }
                $numbers[count($numbers) - 2] = "";
                $numbers[count($numbers) - 1] = "";
                $arrays = update_array($numbers, $operators);
                $numbers = $arrays[0];
                $operators = $arrays[1];
                array_push($numbers, $res);
                break;
            case '-':
                $res = intval($prev) - intval($last);
                if (count($numbers) > 2) {
                    $numbers[count($numbers) - 3] = "";
                }
                $numbers[count($numbers) - 2] = "";
                $numbers[count($numbers) - 1] = "";
                $arrays = update_array($numbers, $operators);
                $numbers = $arrays[0];
                $operators = $arrays[1];
                array_push($numbers, $res);
                break;
            case '*':
                $res = intval($prev) * intval($last);
                if (count($numbers) > 2) {
                    $numbers[count($numbers) - 3] = "";
                }
                $numbers[count($numbers) - 2] = "";
                $numbers[count($numbers) - 1] = "";
                $arrays = update_array($numbers, $operators);
                $numbers = $arrays[0];
                $operators = $arrays[1];
                array_push($numbers, $res);
                break;
            case '/':
                $res = intval($prev) / intval($last);
                if (count($numbers) > 2) {
                    $numbers[count($numbers) - 3] = "";
                }
                $numbers[count($numbers) - 2] = "";
                $numbers[count($numbers) - 1] = "";
                $arrays = update_array($numbers, $operators);
                $numbers = $arrays[0];
                $operators = $arrays[1];
                array_push($numbers, $res);
                break;
            case '%':
                $res = intval($prev) % intval($last);
                if (count($numbers) > 2) {
                    $numbers[count($numbers) - 3] = "";
                }
                $numbers[count($numbers) - 2] = "";
                $numbers[count($numbers) - 1] = "";
                $arrays = update_array($numbers, $operators);
                $numbers = $arrays[0];
                $operators = $arrays[1];
                array_push($numbers, $res);
                break;
            case '(':
                array_pop($numbers);
                array_push($numbers, $res);
                break;
            default:

                break;
        }
        $i++;
    }
    return "$res\n";
}

function update_array($numbers, $operators)
{
    $array1 = [];
    $array2 = [];

    foreach ($numbers as $key => $value) {
        if ($value != NULL || $value != "") {
            array_push($array1, $value);
        }
    }

    foreach ($operators as $key => $value) {
        if ($key !== count($operators) - 1 && $value !== "(") {
            array_push($array2, $value);
        }
    }

    return [$array1, $array2];
}
