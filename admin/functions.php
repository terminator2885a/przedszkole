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
                // '!', '@', '#', '$', '%', '^', '&', '*', '.'
            ];

            for($i=0; $i<10; $i++){
                $pass.= $chars[rand(0, count($chars)-1)];
            }
            return $pass;
        }

        function getPeselControlDigit($pesel) {
            $pesel = substr($pesel, 0, 10);
            $weights = [1, 3, 7, 9, 1, 3, 7, 9, 1, 3];
            $sum = 0;

            for($i = 0; $i < 10; $i++){
                $sum += $pesel[$i] * $weights[$i];
            }

            return (10 - ($sum % 10)) % 10;
        }

        function validatePesel($pesel){
            if(strlen($pesel)!=11 || !is_numeric($pesel))
                return false;
            if ($pesel[10] != getPeselControlDigit($pesel))
                return false;
            else
                return true;
        }

        function birthDate($pesel){
            $year = intval(substr($pesel, 0, 2));
            $month = intval(substr($pesel, 2, 2));
            $day = intval(substr($pesel, 4, 2));

            if ($month >= 1 && $month <= 12) {
                $year += 1900;
            } elseif ($month >= 21 && $month <= 32) {
                $year += 2000;
                $month -= 20;
            } elseif ($month >= 41 && $month <= 52) {
                $year += 2100;
                $month -= 40;
            } elseif ($month >= 61 && $month <= 72) {
                $year += 2200;
                $month -= 60;
            } elseif ($month >= 81 && $month <= 92) {
                $year += 1800;
                $month -= 80;
            } else {
                return null;
            }

            if (!checkdate($month, $day, $year)) {
                return null;
            }

            return sprintf("%04d-%02d-%02d", $year, $month, $day);
        }

        function getAge($birthDate){
            $today = new DateTime();
            $birthdate = new DateTime($birthDate);
            $age = $today->diff($birthdate)->y;
            return $age;
        }

        function getGender($pesel){
            $gender = intval(substr($pesel, 9, 1));
            return $gender%2==0 ? "F" : "M";
        }
?>
