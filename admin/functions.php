<?php
        function removePolishCharacters($text) {
            $map = [
                'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l',
                'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ż' => 'z', 'ź' => 'z',
                'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'E', 'Ł' => 'L',
                'Ń' => 'N', 'Ó' => 'O', 'Ś' => 'S', 'Ż' => 'Z', 'Ź' => 'Z'
            ];
            return strtr($text, $map);
        }

        function generatePassword(){
            $pass = '';
            $chars = [
                //Lower
                'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j' , 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
                //Upper
                'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
                //Nums
                '1', '2', '3', '4', '5', '6', '7', '8', '9', '0',
                //Special
                '!', '@', '#', '$', '%', '^', '&', '*', '.'
            ];

            for($i=0; $i<10; $i++){
                $pass.= $chars[rand(0, count($chars)-1)];
            }
            return $pass;
        }
?>
