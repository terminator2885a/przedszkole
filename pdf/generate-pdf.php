<?php

require_once('../vendor/autoload.php');

use TCPDF;

$type = isset($_GET['type']) ? $_GET['type'] : 'rekrutacja';

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_PAGE_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(15, 15, 15);
$pdf->AddPage();
$pdf->SetFont('helvetica', 'B', 16);
$pdf->SetTextColor(75, 127, 82);

switch($type) {
    case 'rekrutacja':
        generateRecruitmentPDF($pdf);
        $filename = 'Zasady_Rekrutacji.pdf';
        break;
    case 'rodo':
        generateRODOPDF($pdf);
        $filename = 'Polityka_RODO.pdf';
        break;
    case 'maloletni':
        generateChildProtectionPDF($pdf);
        $filename = 'Standardy_Ochrony_Maloletnich.pdf';
        break;
    case 'kalendarium':
        generateCalendarPDF($pdf);
        $filename = 'Kalendarium.pdf';
        break;
    case 'jadlospis':
        generateMenuPDF($pdf);
        $filename = 'Jadlospis.pdf';
        break;
    default:
        generateRecruitmentPDF($pdf);
        $filename = 'Dokument.pdf';
}

$pdf->Output($filename, 'D');

function generateRecruitmentPDF($pdf) {
    $pdf->Cell(0, 10, 'ZASADY REKRUTACJI', 0, 1, 'C');
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Ln(5);
    
    $content = <<<EOT
Przedszkole "Małe Skrzaty" serdecznie zaprasza do udziału w procesie rekrutacji.

WARUNKI PRZYJĘCIA:
• Przyjmujemy dzieci w wieku od 3 do 6 lat
• Dziecko powinno być zarejestrowane w systemie niebezpiecznych chorób zakaźnych
• Wymagane są szczepienia zgodnie z Programem Szczepień Ochronnych
• Dziecko powinno być zdolne do uczestniczenia w zajęciach grupowych

WYMAGANE DOKUMENTY:
• Wypełniony formularz zgłoszeniowy
• Kopia aktualnego szczepienia
• Zaświadczenie lekarskie
• Oświadczenie rodzica/opiekuna
• Dane kontaktowe osób uprawnionych do odboru dziecka

HARMONOGRAM REKRUTACJI:
• Wiosna: okres rejestracji od marca do kwietnia
• Lato: uzupełnianie wolnych miejsc w miarę potrzeb
• Zawiadomienie o wyniku: w ciągu 14 dni od zakończenia naboru

OPŁATY:
• Miesięczna opłata: 1500 PLN (pełny etat)
• Godzinowa opieka: 25 PLN/godzina
• Możliwość dofinansowania z gminy

PROCES REKRUTACJI:
Po złożeniu kompletnych dokumentów zostanie umówione spotkanie z kierownikiem przedszkola.

Kontakt:
Email: kontakt@maleskrzaty.pl
Telefon: 42 678 45 32
Adres: ul. Wesoła 12, 93-152 Łódź
EOT;
    
    $pdf->MultiCell(0, 5, $content, 0, 'L');
}

function generateRODOPDF($pdf) {
    $pdf->Cell(0, 10, 'POLITYKA OCHRONY DANYCH OSOBOWYCH (RODO)', 0, 1, 'C');
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Ln(5);
    
    $content = <<<EOT
ADMINISTRATOR DANYCH:
Niepubliczne Przedszkole "Małe Skrzaty"
ul. Wesoła 12, 93-152 Łódź
kontakt@maleskrzaty.pl

JAKIE DANE ZBIERAMY:
• Imię, nazwisko i wiek dziecka
• Dane kontaktowe rodziców/opiekunów
• Dane zdrowotne (historia szczepień, alergie)
• Dane dotyczące stanu rozwojowego dziecka
• Zdjęcia i filmy z zajęć (za uprzednią zgodą)

CEL PRZETWARZANIA DANYCH:
• Realizacja umowy o świadczenie usług opieki
• Monitorowanie zdrowia i bezpieczeństwa
• Komunikacja z rodzicami
• Wykonywanie obowiązków prawnych
• Dokumentacja edukacyjna

OKRES PRZECHOWYWANIA DANYCH:
Dane są przechowywane przez okres uczęszczania dziecka do przedszkola oraz okres wymagany przez prawo.

PRAWA OSÓB KTÓRYCH DANE DOTYCZĄ:
• Prawo dostępu do danych
• Prawo do sprostowania danych
• Prawo do usunięcia danych
• Prawo do ograniczenia przetwarzania
• Prawo do sprzeciwu
• Prawo do przenoszalności danych

JAK REALIZOWAĆ SWOJE PRAWA:
Skontaktuj się z naszym biurem mailowo lub telefonicznie.

BEZPIECZEŃSTWO DANYCH:
Przedszkole wdrożyło odpowiednie środki techniczne i organizacyjne w celu ochrony danych.
EOT;
    
    $pdf->MultiCell(0, 5, $content, 0, 'L');
}

function generateChildProtectionPDF($pdf) {
    $pdf->Cell(0, 10, 'STANDARDY OCHRONY MALOLETNICH', 0, 1, 'C');
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Ln(5);
    
    $content = <<<EOT
BEZPIECZEŃSTWO FIZYCZNE:
• Wszystkie pomieszczenia są regularnie sprawdzane
• Dostęp do przedszkola kontrolowany
• Urządzenia na placu zabaw regularnie konserwowane
• System nadzoru kamerowego w pomieszczeniach wspólnych
• Personel przeszkolony w udzielaniu pierwszej pomocy

OCHRONA PRZED NADUŻYCIAMI:
• Ścisła weryfikacja pracownic przed zatrudnieniem
• Sprawdzanie rejestru sprawców przestępstw seksualnych
• Regularne szkolenia personelu
• Polityka zerowej tolerancji wobec nadużyć
• Procedury zgłaszania podejrzanych przypadków

OCENA ZDROWIA I DOBROSTANU:
• Obserwacja zmian w zachowaniu dziecka
• Personel przeszkolony w rozpoznawaniu oznak zaniedbania
• Nauczanie dzieci praw i budowanie zaufania
• Wsparcie psychologiczne dla potrzebujących

KOMUNIKACJA Z RODZICAMI:
• Otwarta komunikacja o postępach dziecka
• Powiadomienie o zmianach w sytuacji domowej
• Spotkania z rodzicami
• Dokumentacja incydentów bezpieczeństwa

PROCEDURY W SYTUACJACH KRYZYSOWYCH:
• Plan ewakuacji i ćwiczenia
• Procedury reagowania na zagrożenia
• Procedury postępowania przy zaginięciu dziecka
• Współpraca z organami ścigania

EDUKACJA DZIECI:
• Nauczanie bezpiecznego zachowania
• Wspieranie wyrażania uczuć i potrzeb
• Zajęcia z pierwszej pomocy
EOT;
    
    $pdf->MultiCell(0, 5, $content, 0, 'L');
}

function generateCalendarPDF($pdf) {
    $pdf->Cell(0, 10, 'KALENDARIUM PRZEDSZKOLA', 0, 1, 'C');
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Ln(5);
    
    $content = <<<EOT
ROK SZKOLNY 2024/2025

PIERWSZY SEMESTR:
1 września - Początek roku szkolnego
28 września - Dzień Mózgu
11 października - Dzień Polskiego Nauczyciela
31 października - Halloween
11 listopada - Dzień Niepodległości
1 grudnia - Początek przygotowań zimowych
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
Wizyta w bibliotece, muzeum, zoo i na farmie.
Szczegóły będą komunikowane z wyprzedzeniem.
EOT;
    
    $pdf->MultiCell(0, 5, $content, 0, 'L');
}

function generateMenuPDF($pdf) {
    $pdf->Cell(0, 10, 'JADŁOSPIS', 0, 1, 'C');
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Ln(5);
    
    $content = <<<EOT
ZASADY ŻYWIENIA:
• Posiłki przygotowywane we własnej kuchni
• Świeże produkty wysokiej jakości
• Zbilansowana dieta
• Opcje bez glutenu dostępne
• Indywidualne ograniczenia dietetyczne możliwe
• Brak produktów ultraprzetworowanych

HARMONOGRAM POSIŁKÓW:
7:30-8:30 - Śniadanie
9:00-9:30 - Śniadanie główne
11:30-12:00 - Drugie śniadanie
12:00-13:00 - Obiad
15:00-15:30 - Podwieczorek

PRZYKŁADOWY JADŁOSPIS:

PONIEDZIAŁEK:
Śniadanie: kaszka
Drugie śniadanie: owoce
Obiad: rosół z makaronem, klopsiki
Podwieczorek: ciasto

WTOREK:
Śniadanie: jajecznica
Drugie śniadanie: jogurt z muesli
Obiad: żurek ze słonką
Podwieczorek: maluchy

ŚRODA:
Śniadanie: bułka z masłem
Drugie śniadanie: banan
Obiad: mielone mięso, marchewka
Podwieczorek: wypieki

CZWARTEK:
Śniadanie: kaszka perlista
Drugie śniadanie: jabłko
Obiad: kurczak, ziemniaki
Podwieczorek: sernik

PIĄTEK:
Śniadanie: naleśniki
Drugie śniadanie: owoce, jogurt
Obiad: pierś z kurczaka, makaron
Podwieczorek: bułki

ALERGENY I OGRANICZENIA:
Informuj nas o alergach i nietolerancjach.
Wymagane zaświadczenie lekarskie.

NAPOJE:
• Woda dostępna przez cały dzień
• Mleko przy posiłkach
• Soki naturalne i kompoty

BEZPIECZEŃSTWO ŻYWNOŚCI:
• Prawidłowe opakowania i daty ważności
• Przechowywanie w odpowiednich warunkach
• Audyty czystości kuchni
• Personel przeszkolony
EOT;
    
    $pdf->MultiCell(0, 5, $content, 0, 'L');
}

?>
