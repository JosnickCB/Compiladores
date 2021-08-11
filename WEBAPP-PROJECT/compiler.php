<?php
    include 'convert_to_php.php';
    include 'tokenizer.php';
    include 'lexical_analyzer.php';
    include 'syntax_analyzer.php';
    include 'code_generator.php';

    function print_token_html($arr){
        $length = count($arr);
        for($i=0,$j=1;$i<$length;$i+=2,$j+=2){
            echo "[".$arr[$i]."]:{".$arr[$j]."}<br>";
        }
    }
    $lines = array();

    convert_to_php($lines);

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