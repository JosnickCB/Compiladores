<?php
    function convert_to_php(&$initial){
        $i = 0;
        while (true) {
            if(isset($_POST[$i])){
                array_push($initial,$_POST[$i]);
                $i++;
            }else{
                break;
            }
        }
    }
    function print_token_html($arr){
        $length = count($arr);
        for($i=0,$j=1;$i<$length;$i+=2,$j+=2){
            echo "[".$arr[$i]."]:{".$arr[$j]."}<br>";
        }
    }
    $lines = array();

    convert_to_php($lines);
    echo "[BEGIN] CONTENIDO INICIAL ENTRANTE <br>";
    print_r($lines);
    echo "<br>[END] CONTENIDO INICIAL ENTRANTE <br>";
    function isNumber($char){
        $regex = '/[0-9]/';
        if(preg_match($regex,$char)){
            return true;
        }
        return false;
    }

    function isLetter($char){
        $regex = '/[a-z]|[A-Z]/';
        if(preg_match($regex,$char)){
            return true;
        }
        return false;
    }

    function isEqualToken($char){
        return $char === '=';
    }

    function isOperatorToken($char){
        $regex = '/\+|\-|\*|\//';
        return(preg_match($regex,$char));
    }

    function isGroupToken($char){
        $regex = '/\(|\)/';
        return(preg_match($regex,$char));
    }

    function isPrintToken($word,$opener){
        return($word === "print" && $opener === '(');
    }

    function isNumberToken($word){
        return(preg_match('/\d+/',$word));
    }

    function isVariableToken($word){
        return(preg_match('/\w*/',$word));
    }
    
    function tokenize($character){
        if( isNumber($character) ){
            return "number";
        }elseif (isLetter($character)) {
            return "variable";
        }elseif (isEqualToken($character)) {
            return "equal";
        }elseif (isOperatorToken($character)) {
            return "operator";
        }elseif (isGroupToken($character)) {
            return ($character==='(')?"open_group":"close_group";
        }elseif($character === ' '){
            return "space";
        }else{
            echo "Tokenize Fatal Error";
            return "ERROR";
        }
    }

    function lexical_analyzer(&$line_input){
        echo "<br>[BEGIN] ANÁLISIS LÉXICO POR LINEA<br>";
        echo "STRING A ANALIZAR = ".$line_input."<br>";
        $tokens = array();
        $temp_token = "";
        $temp_type = "";
        $length = strlen($line_input);

        for ($i = 0; $i < $length; $i++) {
            $actual_char = tokenize($line_input[$i]);
            //echo "ACTUAL TYPE = ".$actual_char."<br>";

            if ($temp_type === "" && $temp_token === "") {
                if ($actual_char === "number" || $actual_char === "variable") {
                    $temp_token .= $line_input[$i];
                    $temp_type = $actual_char;
                } else {
                    //array_push( $tokens , $temp_token );
                    //array_push( $tokens , $temp_type );
                    $temp_token = "";
                    $temp_type = "";
                    array_push($tokens, $line_input[$i]);
                    array_push($tokens, $actual_char);
                }
            } else {
                if ($temp_type === "variable") {
                    if ($actual_char === "variable" || $actual_char === "number") {
                        $temp_token .= $line_input[$i];
                    } else {
                        array_push($tokens,
                            $temp_token
                        );
                        array_push($tokens, $temp_type);
                        $temp_token = "";
                        $temp_type = "";
                        array_push($tokens, $line_input[$i]);
                        array_push($tokens, $actual_char);
                    }
                } elseif ($temp_type === "number") {
                    if ($actual_char === "number") {
                        $temp_token .= $line_input[$i];
                        $temp_type = $actual_char;
                    } else {
                        array_push($tokens, $temp_token);
                        array_push($tokens,
                            $temp_type
                        );
                        array_push($tokens, $line_input[$i]);
                        array_push($tokens, $actual_char);

                        $temp_token = "";
                        $temp_type = "";
                        //array_push( $tokens , $line_input[$i] );
                        //array_push( $tokens , $actual_char );
                    }
                } else {
                    array_push($tokens, $temp_token);
                    array_push($tokens, $temp_type);
                    array_push($tokens,$line_input[$i]);
                    array_push($tokens, $actual_char);
                    $temp_token = "";
                    $temp_type = "";
                }
            }
        }
        if($temp_token <> "" || $temp_type <> ""){
            array_push( $tokens , $temp_token);
            array_push( $tokens , $temp_type);
        }
        echo "[END] ANÁLISIS LÉXICO POR LINEA <br>";
        return $tokens;
    }

    function run_lexical_analyzer(&$line_content){
        //echo "+-----+<br>";
        //print_r($line_content);
        //echo "<br>";
        echo "<br>[BEGIN] ANALIZADOR LEXICO<br>";
        $tokens = Array();
        
        $length = count($line_content);
        for($i=0;$i<$length;$i++){
            /*echo "<-----><br>";
            print_r($line_content[$i]);
            echo "<br>";
            echo "<-----><br>";*/
            $aux_content = $line_content[$i];
            
            $aux = preg_replace('/\s+/', '', $aux_content);
            //echo "LEXICAL = ";
            //print_r($aux);
            //$aux_array = lexical_analyzer($line_content[$i]);
            $aux_array = lexical_analyzer($aux);
            $sub_length = count($aux_array);
            for($j=0;$j<$sub_length;$j++){
                array_push( $tokens , $aux_array[$j]);
            }
        }
        echo "<br>[END] ANALIZADOR LEXICO<br>";
        return $tokens;
    }

    function print_entry(&$tokens_array , $length){
        if($tokens_array[0] === "print" && $tokens_array[2] === "(" && $tokens_array[$length-2] === ")"){
            echo "<br> >>> PRINT TOKEN ENCONTRADO<br>";
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
                    echo ">>> EXPR1 ENCONTRADA<br>";
                    print_token_html($tokens_array);
                    echo "<br>";
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
            echo ">>> EXPR2 ENCONTRADA<br>";
            print_token_html($final_array);
            echo "<br>";
            return EXPR($final_array , $final_length);
        }else{
            return false;
        }
    }

    function EXPR3(&$tokens_array , $length){
        if(count($tokens_array) == 2 && ($tokens_array[1] === "variable" || $tokens_array[1] === "number") ){
            echo ">>> EXPR3 ENCONTRADA<br>";
            print_token_html($tokens_array);
            echo "<br>";
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

        //print_token_html($left_array);
        //print_token_html($right_array);

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

        echo ">>> ANALIZADOR SINTÁCTICO LANZADO <br>";
        $flag_expr = EXPR($expr_array , count($expr_array) );
        $flag_equl = IGUALDAD($equal_array , count($equal_array));
        if($flag_expr) echo "<br>+++ EXPRESION ENCONTRADA<br>";
        if($flag_equl) echo "<br>+++ IGUALDAS ENCONTRADA<br>";
        return ( $flag_expr|| $flag_equl);
    }

    function generate_code (&$tokens){
        $length = count($tokens);
        $printable_flag = false;
        $show_flag = true;
        $string_flag = false;
        $number_flag = false;
        $instruction = Array();
        for($i=0,$j=1;$i<$length;$i+=2,$j+=2){
            if($string_flag && $number_flag){
                echo "ERROR OPERACION DE DIFERENTES TIPOS DE DATOS<br>";
                $show_flag = false;
                break;
            }
            if(($tokens[$j] === "variable" || $tokens[$j] === "number") && $tokens[$i] <> "print"){
                //echo $tokens[$i]." es variable o numero<br>";
                if(isNumberToken($tokens[$i])){
                    //echo $tokens[$i]." es numero<br>";
                    $number_flag = true;
                    array_push($instruction,$tokens[$i]);
                }elseif(isVariableToken($tokens[$i])){
                    $string_flag = true;
                    array_push($instruction,$tokens[$i]);
                }
            }elseif($tokens[$i] === "print"){
                array_push($instruction,"echo");
                $printable_flag = true;
            }else{
                array_push($instruction,$tokens[$i]);
            }
        }
        //print_r($instruction);
        $string_var = "";
        if( $number_flag && !$string_flag ){
            for($i=0;$i<count($instruction);$i++){
                $string_var .= $instruction[$i];
            }
        }

        if (!$number_flag && $string_flag ) {
            for($i=0;$i<count($instruction);$i++){
                if(($instruction[$i] === "echo" || isGroupToken($instruction[$i]) ) ){
                    $string_var .= $instruction[$i];
                    
                }elseif(isOperatorToken( $instruction[$i])){
                    if($instruction[$i] === '+'){
                        $string_var .= '.';
                    }else{
                        $printable_flag = false;
                        break;
                    }
                    
                }else{
                    $string_var .= '"'.$instruction[$i].'"';
                }
            }
        }
        

        if($show_flag && $printable_flag){
            //echo "FINAL INSTRUCTION ";
            //print_r($instruction);
            
            //exec(" echo ".$string_var.";");
            //echo $string_var.";";
            echo "<h1>";
            echo eval($string_var.';');
            echo "</h1>";
            //eval("( echo 5;)");
        }
        
    }

    //MAIN()---------------------------------------------------------------------------------
    $tokens = run_lexical_analyzer($lines);
    //print_r($tokens);
    //print_token_html($tokens);
    //echo "<br>";
    if(syntax_analyzer($tokens)){
        //echo "ACEPTADO TMR :'v<br>";
        generate_code($tokens);
    }else{
        echo "ERROR EN SINTAXIS <br>";
    }
?>