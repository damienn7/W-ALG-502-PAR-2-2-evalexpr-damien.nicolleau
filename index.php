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

    $data_array = @create_array_with_float($expr);

    $data = $data_array[0];

    $decimals = $data_array[1];

    // var_dump($data);
    for ($i = 0; $i < count($data); $i++) {

        if ($data[$i] === "(") {
            $calc = true;
        }

        if ($data[$i] === ")" && $calc === true) {
            $calc = false;
            $sub_result = @calc_subexpr($subexpr);
            $result .= $sub_result;
        }

        if ($calc === true) {
            array_push($subexpr, $data[$i]);
        } elseif($calc === false && $data[$i] !== ")") {
            $result .= $data[$i];
        }
    }

    if (array_search(")",str_split($result)) !== false || array_search("(",str_split($result)) !== false) {
        @eval_expr($result);
    }

    // echo "result : ".$result."\nsub_result : ".$sub_result."\n";
    $sub_result = @calc_subexpr(create_array_with_float($result)[0],true);

    if ($sub_result===true) {
        @eval_expr($result);
    }

    return (double) $sub_result==""?$result."\n":$sub_result."\n";
}

function create_array_with_float($str){
    $array1 = str_split($str);
    $array_with_float = array();
    $number = null;
    $j=0;
    for ($i=0; $i < count($array1); $i++) { 
        if (($array1[$i]!=="%"&&$array1[$i]!=="+")&&($array1[$i]!=="-"&&$array1[$i]!=="/")&&($array1[$i]!=="*"&&$array1[$i]!=="("&&$array1[$i]!==")")) {
            $number.=$array1[$i];
            if ($array1[$i-1]===".") {
                $j++;
            }
            if ($i==count($array1)-1) {
                // echo $number;
                // echo "number : ".$number."\narray i : ".$array1[$i]."\n";
                $last_number = $number;
                array_push($array_with_float,$last_number);
            }
        }else{
            array_push($array_with_float,$number);
            array_push($array_with_float,$array1[$i]);
            $number = null;
        }
    }

    // var_dump($array_with_float);

    return [$array_with_float,$j];
}

function calc_subexpr($subexpr,$check=false)
{
    
    $last_calc = null;
    $sub_result = null;
    if ($check===false) {
        
        for ($i = 0; $i < count($subexpr); $i++) {
            switch ($subexpr[$i]) {
                case '+':
                    if ($subexpr[$i+2]==="/"||$subexpr[$i+2]==="%"||$subexpr[$i+2]==="*") {
                        $last_calc .= '+'.$subexpr[$i-1];
                        // echo "subexxxxpr".$subexpr[$i-1]."\n last_calc : ".$last_calc."\n";
                        $sub_result= null;
                }else{
                    $sub_result = $sub_result === null?$subexpr[$i - 1] + $subexpr[$i + 1]:$sub_result + $subexpr[$i+1];
                }
                $i++;
                break;
            case '-':
                $sub_result = $sub_result === null?$subexpr[$i - 1] - $subexpr[$i + 1]:$sub_result - $subexpr[$i+1];
                $i++;
                break;
            case '/':
                $sub_result = $sub_result === null?$subexpr[$i - 1] / $subexpr[$i + 1]:$sub_result / $subexpr[$i+1];
                // echo "last : ".$subexpr[$i - 1]."\n";
                // echo "sub_result : ".$sub_result."\n";
                // echo "next : ".$subexpr[$i + 1]."\n";
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
    if ($last_calc!== null) {
        $sub_result.= $last_calc;
        // echo "sub_result : ".$sub_result."\n";
        $sub_result=@calc_subexpr(create_array_with_float($sub_result)[0]);
        // echo "sub_result : ".$sub_result."\n";
    }
    return $sub_result;
}else{
    foreach ($subexpr as $key => $value) {
        if (!is_numeric($value)&&$value!=".") {
            // echo "value : ".$value;
            return @calc_subexpr($subexpr);
        }
    }
}


}
