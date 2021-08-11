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
?>