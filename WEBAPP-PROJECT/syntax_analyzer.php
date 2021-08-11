<?php
    /*
    GRAMÁTICA:
        ENTRY       => 'print(' LINE ')' | LINE
        LINE        => EXPR | IGUALDAD
        IGUALDAD    => VAR IGUAL EXPR
        EXPR        => EXPR1 | EXPR2 | EXPR3
        EXPR1       => EXPR OP EXPR
        EXPR2       => ( EXPR )
        EXPR3       => VAR | NUM
    */

    function print_entry(&$tokens_array , $length){
        if($tokens_array[0] === "print" && $tokens_array[2] === "(" && $tokens_array[$length-2] === ")"){
           return true;
        }
        return false;
    }

    function EXPR1(&$tokens_array , $length){
        
        $aux_array= $tokens_array;
        $operator_index = 0;

        for ($i=0,$j=1 ; $i < $length ; $i+=2,$j+=2) { 
            if($aux_array[$j] === "operator"){
                $operator_index = $i;

                $left_array = array_slice( $aux_array , 0 , $operator_index );
                $right_array = array_slice( $aux_array , $operator_index+2 );
                $left_length = count($left_array);
                $right_length = count($right_array);

                if( EXPR( $left_array , $left_length ) && EXPR( $right_array , $right_length ) ){
                    return true;
                }
            }
        }

        return false;
    }

    function EXPR2(&$tokens_array , $length){
        $aux_array = $tokens_array;
        if($tokens_array[0]==='(' && $tokens_array[$length-2] === ')'){
            $temp_array = array_slice($aux_array,2);
            $final_array = array_slice($temp_array,0,-2);
            $final_length = count($final_array);
            return EXPR($final_array , $final_length);
        }else{
            return false;
        }
    }

    function EXPR3(&$tokens_array , $length){
        if(count($tokens_array) == 2 && ($tokens_array[1] === "variable" || $tokens_array[1] === "number") ){
            return true;
        }else{
            return false;
        }
    
    }

    function EXPR(&$tokens_array , $length){
        $array_for_expr1 = $tokens_array;
        $length_for_expr1 = count($array_for_expr1);
        $array_for_expr2 = $tokens_array;
        $length_for_expr2 = count($array_for_expr2);
        $array_for_expr3 = $tokens_array;
        $length_for_expr3 = count($array_for_expr3);
        return (EXPR1($array_for_expr1 , $length_for_expr1) || 
                EXPR2($array_for_expr2 , $length_for_expr2) || 
                EXPR3($array_for_expr3 , $length_for_expr3));
    }

    function IGUALDAD(&$tokens_array){
        //echo "IGUALDAD SCOPE [BEGIN] <br>";
        $aux_array = $tokens_array;
        $length = count($aux_array);
        $only_one_equal = 0;
        $equal_index = 0;

        //Pre-procesar en busca de dos '='
        for($i=0;$i<$length;$i+=2){
            if($aux_array[$i] === '='){
                $only_one_equal += 1;
                $equal_index = $i;
            }
            if($only_one_equal > 1) return false;
        }

        $left_array = array_slice( $aux_array , 0 , $equal_index );
        $right_array = array_slice( $aux_array , $equal_index+2 );
        $left_length = count($left_array);
        $right_length = count($right_array);

        print_token_html($left_array);
        print_token_html($right_array);

        //echo "IGUALDAD SCOPE [END] <br>";
        return (
            $left_length == 2 &&
            $left_array[1] === "variable" &&
            EXPR($right_array , $right_length)
        );
    }

    /*function PRINT_SYNTAX(&$tokens_array , $length){
        $aux_array = $tokens_array;
        
    }*/

    function syntax_analyzer(&$tokens_array){
        $tokens = $tokens_array;
        $length = count($tokens);
        
        $print_counter = 0;
        

        if(print_entry($tokens,$length)){
            array_splice($tokens , 0 , 4);
            $length -= 4;
            array_splice($tokens , $length-2 , 2);
            $length -= 2;
            $print_flag = true;
        }
        
        //print_r($tokens);
        //print_token_html($tokens);
        //echo "<br>";

        $expr_array = $tokens;
        $equal_array = $tokens;

        
        return (EXPR($expr_array , count($expr_array) ) || IGUALDAD($equal_array , count($equal_array)) );
    }
?>