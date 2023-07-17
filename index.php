<?php

// principale fonction de l'evalexpr alogorithme
function eval_expr($expr)
{
    // variable de résultat
    $result = "";
    // tableau des nombres et opérateurs
    $data = array();

    $subexpr = array();

    $calc = false;

    $sub_result = null;

    $data = create_array_with_float($expr);

    for ($i = 0; $i < count($data); $i++) {

        if ($data[$i] === "(") {
            $calc = true;
        }

        if ($data[$i] === ")" && $calc === true) {
            $calc = false;
            $sub_result = calc_subexpr($subexpr);
            $result .= $sub_result;
        }

        if ($calc === true) {
            array_push($subexpr, $data[$i]);
        } elseif($calc === false && $data[$i] !== ")") {
            $result .= $data[$i];
        }
    }

    if (array_search(")",str_split($result)) !== false || array_search("(",str_split($result)) !== false) {
        eval_expr($result);
    }

    $sub_result = calc_subexpr(create_array_with_float($result));

    return $sub_result==""?$result."\n":$sub_result."\n";
}

function create_array_with_float($str){
    $array1 = str_split($str);
    $array_with_float = array();
    $number = null;
    for ($i=0; $i < count($array1); $i++) { 
        if (($array1[$i]!=="%"&&$array1[$i]!=="+")&&($array1[$i]!=="-"&&$array1[$i]!=="/")&&($array1[$i]!=="*"&&$array1[$i]!=="("&&$array1[$i]!==")")) {
            $number.=$array1[$i];
            if ($i==count($array1)-1) {
                array_push($array_with_float,$array1[$i]);
            }
        }else{
            array_push($array_with_float,$number);
            array_push($array_with_float,$array1[$i]);
            $number = null;
        }
    }

    return $array_with_float;
}

function calc_subexpr($subexpr)
{
    $sub_result = null;
    for ($i = 0; $i < count($subexpr); $i++) {
        switch ($subexpr[$i]) {
            case '+':
                $sub_result = $sub_result === null?$subexpr[$i - 1] + $subexpr[$i + 1]:$sub_result + $subexpr[$i+1];
                $i++;
                break;
            case '-':
                $sub_result = $sub_result === null?$subexpr[$i - 1] - $subexpr[$i + 1]:$sub_result - $subexpr[$i+1];
                $i++;
                break;
            case '/':
                $sub_result = $sub_result === null?$subexpr[$i - 1] / $subexpr[$i + 1]:$sub_result / $subexpr[$i+1];
                $i++;
                break;
            case '*':
                $sub_result = $sub_result === null?$subexpr[$i - 1] * $subexpr[$i + 1]:$sub_result * $subexpr[$i+1];
                $i++;
                break;
            case '%':
                $sub_result = $sub_result === null?$subexpr[$i - 1] % $subexpr[$i + 1]:$sub_result % $subexpr[$i+1];
                $i++;
                break;
            default:
                break;
        }
        
    }

    return $sub_result;
}
