<?php

$type = isset($_GET['type']) ? $_GET['type'] : 'rekrutacja';

switch($type) {
    case 'rekrutacja':
        generateRecruitmentPDF();
        $filename = 'Zasady_Rekrutacji.pdf';
        break;
    case 'rodo':
        generateRODOPDF();
        $filename = 'Polityka_RODO.pdf';
        break;
    case 'maloletni':
        generateChildProtectionPDF();
        $filename = 'Standardy_Ochrony_Maloletnich.pdf';
        break;
    case 'kalendarium':
        generateCalendarPDF();
        $filename = 'Kalendarium.pdf';
        break;
    case 'jadlospis':
        generateMenuPDF();
        $filename = 'Jadlospis.pdf';
        break;
    default:
        generateRecruitmentPDF();
        $filename = 'Dokument.pdf';
}

function startPDF(&$pdf) {
    $pdf = "%PDF-1.4\n";
    $pdf .= "1 0 obj\n";
    $pdf .= "<< /Type /Catalog /Pages 2 0 R >>\n";
    $pdf .= "endobj\n";
    $pdf .= "2 0 obj\n";
    $pdf .= "<< /Type /Pages /Kids [3 0 R] /Count 1 >>\n";
    $pdf .= "endobj\n";
    $pdf .= "3 0 obj\n";
    $pdf .= "<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >>\n";
    $pdf .= "endobj\n";
    $pdf .= "5 0 obj\n";
    $pdf .= "<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\n";
    $pdf .= "endobj\n";
    return $pdf;
}

function generateRecruitmentPDF() {
    $content = <<<EOT
ZASADY REKRUTACJI

Przedszkole "Małe Skrzaty" serdecznie zaprasza do udziału w procesie rekrutacji.

WARUNKI PRZYJĘCIA:
- Przyjmujemy dzieci w wieku od 3 do 6 lat
- Dziecko powinno być zarejestrowane w systemie
- Wymagane są szczepienia zgodnie z Programem Szczepień Ochronnych
- Dziecko powinno być zdolne do uczestniczenia w zajęciach grupowych

WYMAGANE DOKUMENTY:
- Wypełniony formularz zgłoszeniowy
- Kopia aktualnego szczepienia
- Zaświadczenie lekarskie potwierdzające zdolność do uczęszczania
- Oświadczenie rodzica/opiekuna o zapoznaniu się z Regulaminem
- Dane kontaktowe osób uprawnionych do odboru dziecka

HARMONOGRAM REKRUTACJI:
- Wiosna: okres rejestracji od marca do kwietnia
- Lato: uzupełnianie wolnych miejsc w miarę potrzeb
- Zawiadomienie o wyniku rekrutacji: w ciągu 14 dni

OPŁATY:
- Miesięczna opłata: 1500 PLN (pełny etat)
- Godzinowa opieka: 25 PLN/godzina
- Możliwość udzielenia dofinansowania z gminy

KONTAKT:
Email: kontakt@maleskrzaty.pl
Telefon: 42 678 45 32
Adres: ul. Wesoła 12, 93-152 Łódź
EOT;
    
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="Zasady_Rekrutacji.pdf"');
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
    
    echo generateSimplePDF('ZASADY REKRUTACJI', $content);
}

function generateRODOPDF() {
    $content = <<<EOT
POLITYKA OCHRONY DANYCH OSOBOWYCH (RODO)

ADMINISTRATOR DANYCH:
Niepubliczne Przedszkole "Małe Skrzaty"
ul. Wesoła 12, 93-152 Łódź
kontakt@maleskrzaty.pl

JAKIE DANE ZBIERAMY:
- Imię, nazwisko i wiek dziecka
- Dane kontaktowe rodziców/opiekunów
- Dane zdrowotne (historia szczepień, alergie)
- Dane dotyczące stanu rozwojowego dziecka
- Zdjęcia i filmy z zajęć (za uprzednią zgodą)

CEL PRZETWARZANIA DANYCH:
- Realizacja umowy o świadczenie usług opieki
- Monitorowanie zdrowia i bezpieczeństwa dziecka
- Komunikacja z rodzicami
- Wykonywanie obowiązków prawnych
- Dokumentacja edukacyjna

PRAWA OSÓB KTÓRYCH DANE DOTYCZĄ:
- Prawo dostępu do swoich danych osobowych
- Prawo do sprostowania danych
- Prawo do usunięcia danych
- Prawo do ograniczenia przetwarzania
- Prawo do sprzeciwu
- Prawo do przenoszalności danych

JAK REALIZOWAĆ SWOJE PRAWA:
Skontaktuj się z naszym biurem mailowo lub telefonicznie.

BEZPIECZEŃSTWO DANYCH:
Przedszkole wdrożyło odpowiednie środki techniczne i organizacyjne w celu ochrony danych.
EOT;
    
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="Polityka_RODO.pdf"');
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
    
    echo generateSimplePDF('POLITYKA RODO', $content);
}

function generateChildProtectionPDF() {
    $content = <<<EOT
STANDARDY OCHRONY MALOLETNICH

BEZPIECZEŃSTWO FIZYCZNE:
- Wszystkie pomieszczenia regularnie sprawdzane
- Dostęp do przedszkola kontrolowany i ograniczony
- Urządzenia na placu zabaw regularnie konserwowane
- System nadzoru kamerowego
- Personel przeszkolony w udzielaniu pierwszej pomocy

OCHRONA PRZED NADUŻYCIAMI:
- Ścisła weryfikacja pracownic przed zatrudnieniem
- Sprawdzanie rejestru sprawców przestępstw seksualnych
- Regularne szkolenia personelu
- Polityka zerowej tolerancji wobec nadużyć
- Procedury zgłaszania podejrzanych przypadków

OCENA ZDROWIA I DOBROSTANU:
- Obserwacja zmian w zachowaniu dziecka
- Personel przeszkolony w rozpoznawaniu oznak zaniedbania
- Wspieranie dzieci w budowaniu zaufania
- Wsparcie psychologiczne dla potrzebujących

KOMUNIKACJA Z RODZICAMI:
- Otwarta komunikacja o postępach dziecka
- Powiadomienie o zmianach w sytuacji domowej
- Spotkania z rodzicami
- Dokumentacja bezpieczeństwa

PROCEDURY W SYTUACJACH KRYZYSOWYCH:
- Plan ewakuacji i regularne ćwiczenia
- Procedury reagowania na zagrożenia
- Procedury postępowania przy zaginięciu dziecka
- Współpraca z organami ścigania

EDUKACJA DZIECI:
- Nauczanie bezpiecznego zachowania
- Wspieranie wyrażania uczuć
- Zajęcia z pierwszej pomocy
EOT;
    
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="Standardy_Ochrony_Maloletnich.pdf"');
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
    
    echo generateSimplePDF('STANDARDY OCHRONY MALOLETNICH', $content);
}

function generateCalendarPDF() {
    $content = <<<EOT
KALENDARIUM PRZEDSZKOLA - ROK SZKOLNY 2024/2025

PIERWSZY SEMESTR:
1 września - Początek roku szkolnego
28 września - Dzień Mózgu
11 października - Dzień Polskiego Nauczyciela
31 października - Halloween
11 listopada - Dzień Niepodległości
1 grudnia - Przygotowania zimowe
19 grudnia - Mikołajki
23 grudnia - Koniec semestru zimowego

DRUGI SEMESTR:
9 stycznia - Powrót do przedszkola
14 lutego - Dzień Walentynki
9 marca - Dzień Kobiet
30 marca - Wielkanoc
23 kwietnia - Światowy Dzień Książki
1 maja - Dzień Pracy
2-3 maja - Dni Łodzi
19 maja - Dzień Matki
30 maja - Pożegnanie przedszkolakiów
31 czerwca - Koniec roku szkolnego

DNI WOLNE:
Przerwa bożonarodzeniowa: 24 grudnia - 8 stycznia
Ferie zimowe: 17-28 lutego
Przerwa wielkanocna: 17 kwietnia
Długi weekend majowy: 1-4 maja

RODZICIELSKIE DNI UDZIAŁU:
Każdy miesiąc - spotkania z nauczycielem
Kwiecień - relacja szkolna
Maj - koncert i gala pożegnalna

WYCIECZKI:
Wizyta w bibliotece, muzeum, zoo i na farmie
Szczegóły będą komunikowane z wyprzedzeniem
EOT;
    
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="Kalendarium.pdf"');
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
    
    echo generateSimplePDF('KALENDARIUM', $content);
}

function generateMenuPDF() {
    $content = <<<EOT
JADŁOSPIS

ZASADY ŻYWIENIA:
- Posiłki przygotowywane we własnej kuchni
- Świeże produkty wysokiej jakości
- Zbilansowana dieta
- Opcje bez glutenu dostępne
- Indywidualne ograniczenia dietetyczne możliwe

HARMONOGRAM POSIŁKÓW:
7:30-8:30 - Śniadanie
9:00-9:30 - Śniadanie główne
11:30-12:00 - Drugie śniadanie
12:00-13:00 - Obiad
15:00-15:30 - Podwieczorek

PRZYKŁADOWY JADŁOSPIS:

PONIEDZIAŁEK:
Śniadanie: kaszka mleczna
Drugie śniadanie: owoce
Obiad: rosół z makaronem, klopsiki, surówka
Podwieczorek: ciasto drożdżowe

WTOREK:
Śniadanie: jajecznica
Drugie śniadanie: jogurt z muesli
Obiad: żurek ze słonką
Podwieczorek: czekoladowe maluchy

ŚRODA:
Śniadanie: bułka z masłem i dżemem
Drugie śniadanie: banan, ciastko
Obiad: mielone mięso, marchewka, brukselka
Podwieczorek: wypieki

CZWARTEK:
Śniadanie: kaszka perlista
Drugie śniadanie: jabłko, baton
Obiad: kurczak, ziemniaki, mizeria
Podwieczorek: sernik, kompot

PIĄTEK:
Śniadanie: naleśniki ze słodkim sosem
Drugie śniadanie: owoce, jogurt
Obiad: pierś z kurczaka, makaron, sałata
Podwieczorek: bułki

ALERGENY I OGRANICZENIA:
Informuj nas o alergach i nietolerancjach
Wymagane zaświadczenie lekarskie

NAPOJE:
- Woda dostępna przez cały dzień
- Mleko lub mleko roślinne przy posiłkach
- Soki naturalne i kompoty

BEZPIECZEŃSTWO ŻYWNOŚCI:
- Prawidłowe opakowania i daty ważności
- Przechowywanie w odpowiednich warunkach temperaturowych
- Regularne audyty czystości
- Personel przeszkolony w zakresie higieny żywności
EOT;
    
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="Jadlospis.pdf"');
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
    
    echo generateSimplePDF('JADŁOSPIS', $content);
}

function generateSimplePDF($title, $content) {
    $pdf = "";
    
    $objects = array();
    $pages = array();
    $contents = "";
    $streams = array();
    
    $objects[1] = "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n";
    $objects[2] = "2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n";
    
    $lines = explode("\n", $content);
    $textContent = "BT /F1 12 Tf 50 700 Td\n";
    $y = 700;
    
    foreach ($lines as $line) {
        if (!empty(trim($line))) {
            $line = str_replace('(', '\\(', str_replace(')', '\\)', $line));
            $textContent .= "(". trim($line) .") Tj\n";
            $textContent .= "0 -20 Td\n";
            $y -= 20;
            if ($y < 50) {
                break;
            }
        }
    }
    
    $textContent .= "ET\n";
    
    $objects[4] = "4 0 obj\n<< /Length " . strlen($textContent) . " >>\nstream\n" . $textContent . "endstream\nendobj\n";
    $objects[3] = "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >>\nendobj\n";
    $objects[5] = "5 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n";
    
    $pdf = "%PDF-1.4\n";
    
    $offsets = array();
    $currentOffset = strlen($pdf);
    
    foreach ($objects as $num => $obj) {
        $offsets[$num] = $currentOffset;
        $pdf .= $obj;
        $currentOffset += strlen($obj);
    }
    
    $xrefOffset = strlen($pdf);
    $pdf .= "xref\n";
    $pdf .= "0 " . (count($objects) + 1) . "\n";
    $pdf .= "0000000000 65535 f\n";
    
    for ($i = 1; $i <= count($objects); $i++) {
        $pdf .= sprintf("%010d 00000 n\n", $offsets[$i]);
    }
    
    $pdf .= "trailer\n";
    $pdf .= "<< /Size " . (count($objects) + 1) . " /Root 1 0 R >>\n";
    $pdf .= "startxref\n";
    $pdf .= $xrefOffset . "\n";
    $pdf .= "%%EOF";
    
    return $pdf;
}

?>
