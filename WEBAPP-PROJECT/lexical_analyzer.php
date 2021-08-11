<?php
    //include 'tokenizer.php';
    /*
    Estructura de tokens:
    [ <token1> , token_type1 , <token2> , token_type2 ... <tokenN> , token_typeN ]
    +--0---+ , +----1----+ , +--2---+ , +----3----+ ... +(N-1)-+ , +----N----+  

    Nombre de tokens:
        (       : open_grouper
        )       : close_grouper
        =       : equal
        + - / * : operator
        [0-9]*  : number        //Notación de regex
        \w*     : variable      //Notación de regex
    */
    /*function lexical_analyzer($input_line){
        echo "<<<".$input_line.">>>";
        $tokens = Array();
        $length = strlen($input_line);
        $type = "";
        $aux_token = "";
        for ($i=0; $i<$length ; $i++) {
            if($type === "" && $aux_token === ""){
                echo "<<".$input_line[$i].">>";
                $type = tokenize($input_line[$i]);
                if ($type===' ') continue;
                if($type === "number" || $type === "variable"){
                    $aux_token .= $input_line[$i];
                }else{
                    array_push( $tokens , $input_line[$i] );
                    array_push( $tokens , $type );
                    $type = "";
                    $aux_token = "";
                }
            }else{
                $aux_type = tokenize($input_line[$i]);
                if($type === "number"){
                    if($aux_type === "number"){
                        $aux_token .= $aux_type;
                    }
                }elseif($type === "variable"){
                    if($aux_type === "variable"){
                        $aux_token .= $aux_type;
                    }
                }else{
                    if($aux_type <> ' '){
                        array_push( $tokens , $aux_token );
                        array_push( $tokens , $type );
                        $type = "";
                        $aux_token = "";
                    }else{
                        $type = "";
                        $aux_token = "";
                    }
                }
            }
            echo "<".$input_line[$i]."><br>";
        }
        return $tokens;
    }

    function lexical_analyzer(&$line_input){
        echo "LEXICAL = ".$line_input."<br>";
        $tokens = array();
        $temp_token = "";
        $temp_type = "";
        $length = strlen($line_input);

        for ($i = 0; $i < $length; $i++) {
            $actual_char = tokenize($line_input[$i]);
            echo "ACTUAL TYPE = ".$actual_char."<br>";

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
                    array_push(
                        $tokens,
                        $line_input[$i]
                    );
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
        return $tokens;
    }

    function run_lexical_analyzer(&$line_content){
        echo "+-----+<br>";
        print_r($line_content);
        echo "<br>";
        echo "+-----+<br>";
        $length = count($line_content);
        $tokens = Array();
        for($i=0;$i<$length;$i++){
            echo "<-----><br>";
            print_r($line_content[$i]);
            echo "<br>";
            echo "<-----><br>";
            $aux = $line_content[$i];
            //$aux_array = lexical_analyzer($line_content[$i]);
            $aux_array = lexical_analyzer($aux);
            $sub_length = count($aux_array);
            for($j=0;$j<$sub_length;$j++){
                array_push( $tokens , $aux_array[$j]);
            }
        }
        return $tokens;
    }*/

    function lexical_analyzer(&$line_input){
        //echo "LEXICAL = ".$line_input."<br>";
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
        return $tokens;
    }

    function run_lexical_analyzer(&$line_content){
        //echo "+-----+<br>";
        //print_r($line_content);
        //echo "<br>";
        //echo "+-----+<br>";
        
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
        return $tokens;
    }
?>