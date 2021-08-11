<?php
    
    /*function isNumber($char){
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
        return(preg_match('/[0-9]/',$word));
    }

    function isVariableToken($word){
        return(preg_match('/\w/',$word));
    }
    //require_once "lexical_analyzer.php";
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
        }else{
            echo "Tokenize Fatal Error";
            return "ERROR";
        }
    }*/
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
?>