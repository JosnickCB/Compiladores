<?php
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
            echo eval($string_var.';');
            //eval("( echo 5;)");
        }
        
    }
?>