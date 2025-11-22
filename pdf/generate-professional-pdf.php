<?php

$type = isset($_GET['type']) ? $_GET['type'] : 'rekrutacja';

header('Content-Type: application/pdf; charset=utf-8');
header('Content-Disposition: attachment; filename="' . getPDFFilename($type) . '"');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

$pdf = new SimplePDFGenerator();

switch($type) {
    case 'rekrutacja':
        $pdf->generateRecruitmentPDF();
        break;
    case 'rodo':
        $pdf->generateRODOPDF();
        break;
    case 'maloletni':
        $pdf->generateChildProtectionPDF();
        break;
    case 'kalendarium':
        $pdf->generateCalendarPDF();
        break;
    case 'jadlospis':
        $pdf->generateMenuPDF();
        break;
    default:
        $pdf->generateRecruitmentPDF();
}

echo $pdf->output();

function getPDFFilename($type) {
    $filenames = [
        'rekrutacja' => 'Zasady_Rekrutacji.pdf',
        'rodo' => 'Polityka_RODO.pdf',
        'maloletni' => 'Standardy_Ochrony_Maloletnich.pdf',
        'kalendarium' => 'Kalendarium.pdf',
        'jadlospis' => 'Jadlospis.pdf'
    ];
    return $filenames[$type] ?? 'Dokument.pdf';
}

class SimplePDFGenerator {
    private $objects = [];
    private $objectCount = 5;
    private $pageContent = '';
    private $title = '';
    private $content = [];
    
    public function __construct() {
    }
    
    private function addObject($data) {
        $this->objects[] = $data;
        return $this->objectCount++;
    }
    
    private function utf8ToPDF($str) {
        $str = iconv('UTF-8', 'ISO-8859-2//TRANSLIT', $str);
        return $str;
    }
    
    private function addTitle($title) {
        $this->title = $title;
    }
    
    private function addContent($line, $isBold = false, $size = 11) {
        $this->content[] = [
            'text' => $line,
            'bold' => $isBold,
            'size' => $size
        ];
    }
    
    public function output() {
        $this->buildPDF();
        return $this->renderPDF();
    }
    
    private function buildPDF() {
        $contentStream = $this->buildContentStream();
        $streamLength = strlen($contentStream);
        
        $this->objects[1] = "1 0 obj\n<</Type /Catalog /Pages 2 0 R>>\nendobj\n";
        $this->objects[2] = "2 0 obj\n<</Type /Pages /Kids [3 0 R] /Count 1>>\nendobj\n";
        $this->objects[3] = "3 0 obj\n<</Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Contents 4 0 R /Resources <</Font <</F1 5 0 R /F2 6 0 R>>>>/PageBoxColorInfo<</CropBox[0 0 595 842]>>>>\nendobj\n";
        $this->objects[4] = "4 0 obj\n<</Length $streamLength>>\nstream\n$contentStream\nendstream\nendobj\n";
        $this->objects[5] = "5 0 obj\n<</Type /Font /Subtype /Type1 /BaseFont /Helvetica>>\nendobj\n";
        $this->objects[6] = "6 0 obj\n<</Type /Font /Subtype /Type1 /BaseFont /Helvetica-Bold>>\nendobj\n";
    }
    
    private function buildContentStream() {
        $stream = "BT\n";
        $stream .= "/F1 24 Tf\n";
        $stream .= "50 780 Td\n";
        $stream .= "(" . $this->utf8ToPDF($this->title) . ") Tj\n";
        $stream .= "ET\n";
        
        $stream .= "BT\n";
        $stream .= "/F1 11 Tf\n";
        $stream .= "50 760 Td\n";
        
        $y = 750;
        foreach ($this->content as $line) {
            $font = $line['bold'] ? '/F2' : '/F1';
            $size = $line['size'];
            $stream .= "0 -$size Td\n";
            $stream .= "$font $size Tf\n";
            $stream .= "(" . $this->utf8ToPDF($line['text']) . ") Tj\n";
            $y -= ($size + 3);
            
            if ($y < 50) {
                break;
            }
        }
        
        $stream .= "ET\n";
        return $stream;
    }
    
    private function renderPDF() {
        $pdf = "%PDF-1.4\n";
        $pdf .= "%µµµµ\n";
        
        $offsets = [];
        $currentOffset = strlen($pdf);
        
        foreach ($this->objects as $num => $obj) {
            $offsets[$num] = $currentOffset;
            $pdf .= $obj;
            $currentOffset += strlen($obj);
        }
        
        $xrefOffset = strlen($pdf);
        $pdf .= "xref\n";
        $pdf .= "0 " . (count($this->objects) + 1) . "\n";
        $pdf .= "0000000000 65535 f\n";
        
        for ($i = 1; $i <= count($this->objects); $i++) {
            if (isset($offsets[$i])) {
                $pdf .= sprintf("%010d 00000 n\n", $offsets[$i]);
            }
        }
        
        $pdf .= "trailer\n";
        $pdf .= "<</Size " . (count($this->objects) + 1) . " /Root 1 0 R>>\n";
        $pdf .= "startxref\n";
        $pdf .= $xrefOffset . "\n";
        $pdf .= "%%EOF";
        
        return $pdf;
    }
    
    public function generateRecruitmentPDF() {
        $this->addTitle("ZASADY REKRUTACJI");
        
        $this->addContent("Przedszkole \"Małe Skrzaty\" serdecznie zaprasza do udziału w procesie rekrutacji.");
        $this->addContent("");
        $this->addContent("WARUNKI PRZYJĘCIA:", true, 12);
        $this->addContent("• Przyjmujemy dzieci w wieku od 3 do 6 lat");
        $this->addContent("• Dziecko powinno być zarejestrowane w systemie monitorowania chorób");
        $this->addContent("• Wymagane są szczepienia zgodnie z Programem Szczepień Ochronnych");
        $this->addContent("• Dziecko powinno być zdolne do uczestniczenia w zajęciach grupowych");
        
        $this->addContent("");
        $this->addContent("WYMAGANE DOKUMENTY:", true, 12);
        $this->addContent("• Wypełniony formularz zgłoszeniowy");
        $this->addContent("• Kopia aktualnego szczepienia");
        $this->addContent("• Zaświadczenie lekarskie potwierdzające zdolność do uczęszczania");
        $this->addContent("• Oświadczenie rodzica/opiekuna o zapoznaniu się z Regulaminem");
        $this->addContent("• Dane kontaktowe osób uprawnionych do odboru dziecka");
        
        $this->addContent("");
        $this->addContent("HARMONOGRAM REKRUTACJI:", true, 12);
        $this->addContent("• Wiosna: okres rejestracji od marca do kwietnia");
        $this->addContent("• Lato: uzupełnianie wolnych miejsc w miarę potrzeb");
        $this->addContent("• Zawiadomienie o wyniku rekrutacji: w ciągu 14 dni");
        
        $this->addContent("");
        $this->addContent("OPŁATY:", true, 12);
        $this->addContent("• Miesięczna opłata: 1500 PLN (pełny etat)");
        $this->addContent("• Godzinowa opieka: 25 PLN/godzina");
        $this->addContent("• Możliwość dofinansowania z gminy");
        
        $this->addContent("");
        $this->addContent("KONTAKT:", true, 12);
        $this->addContent("Email: kontakt@maleskrzaty.pl");
        $this->addContent("Telefon: 42 678 45 32");
        $this->addContent("Adres: ul. Wesoła 12, 93-152 Łódź");
    }
    
    public function generateRODOPDF() {
        $this->addTitle("POLITYKA OCHRONY DANYCH OSOBOWYCH");
        
        $this->addContent("ADMINISTRATOR DANYCH:", true, 12);
        $this->addContent("Niepubliczne Przedszkole \"Małe Skrzaty\"");
        $this->addContent("ul. Wesoła 12, 93-152 Łódź");
        $this->addContent("kontakt@maleskrzaty.pl");
        
        $this->addContent("");
        $this->addContent("JAKIE DANE ZBIERAMY:", true, 12);
        $this->addContent("• Imię, nazwisko i wiek dziecka");
        $this->addContent("• Dane kontaktowe rodziców/opiekunów");
        $this->addContent("• Dane zdrowotne (historia szczepień, alergie, przewlekłe choroby)");
        $this->addContent("• Dane dotyczące stanu rozwojowego dziecka");
        $this->addContent("• Zdjęcia i filmy z zajęć (za uprzednią zgodą)");
        
        $this->addContent("");
        $this->addContent("CEL PRZETWARZANIA DANYCH:", true, 12);
        $this->addContent("• Realizacja umowy o świadczenie usług opieki przedszkolnej");
        $this->addContent("• Monitorowanie zdrowia i bezpieczeństwa dziecka");
        $this->addContent("• Komunikacja z rodzicami na temat postępów dziecka");
        $this->addContent("• Wykonywanie obowiązków prawnych przedszkola");
        $this->addContent("• Dokumentacja edukacyjna i rozwojowa");
        
        $this->addContent("");
        $this->addContent("PRAWA OSÓB KTÓRYCH DANE DOTYCZĄ:", true, 12);
        $this->addContent("• Prawo dostępu do swoich danych osobowych");
        $this->addContent("• Prawo do sprostowania danych");
        $this->addContent("• Prawo do usunięcia danych");
        $this->addContent("• Prawo do ograniczenia przetwarzania");
        $this->addContent("• Prawo do sprzeciwu");
        $this->addContent("• Prawo do przenoszalności danych");
    }
    
    public function generateChildProtectionPDF() {
        $this->addTitle("STANDARDY OCHRONY MALOLETNICH");
        
        $this->addContent("BEZPIECZEŃSTWO FIZYCZNE:", true, 12);
        $this->addContent("• Wszystkie pomieszczenia przedszkola regularnie sprawdzane");
        $this->addContent("• Dostęp do przedszkola kontrolowany i ograniczony");
        $this->addContent("• Urządzenia na placu zabaw regularnie konserwowane");
        $this->addContent("• System nadzoru kamerowego w pomieszczeniach wspólnych");
        $this->addContent("• Personel przeszkolony w udzielaniu pierwszej pomocy");
        
        $this->addContent("");
        $this->addContent("OCHRONA PRZED NADUŻYCIAMI:", true, 12);
        $this->addContent("• Wszystkie pracownice poddawane ścisłej weryfikacji");
        $this->addContent("• Sprawdzanie rejestru sprawców przestępstw seksualnych");
        $this->addContent("• Regularne szkolenia personelu");
        $this->addContent("• Polityka zerowej tolerancji wobec wszelkich form nadużyć");
        $this->addContent("• Procedury zgłaszania podejrzanych przypadków");
        
        $this->addContent("");
        $this->addContent("OCENA ZDROWIA I DOBROSTANU:", true, 12);
        $this->addContent("• Obserwacja zmian w zachowaniu lub wyglądzie dziecka");
        $this->addContent("• Personel przeszkolony w rozpoznawaniu oznak zaniedbania");
        $this->addContent("• Wspieranie dzieci w budowaniu zaufania");
        $this->addContent("• Dostępna wsparcie psychologiczne");
    }
    
    public function generateCalendarPDF() {
        $this->addTitle("KALENDARIUM PRZEDSZKOLA");
        
        $this->addContent("ROK SZKOLNY 2024/2025", true, 12);
        
        $this->addContent("");
        $this->addContent("PIERWSZY SEMESTR:", true, 12);
        $this->addContent("1 września - Początek roku szkolnego");
        $this->addContent("28 września - Dzień Mózgu");
        $this->addContent("11 października - Dzień Polskiego Nauczyciela");
        $this->addContent("31 października - Halloween");
        $this->addContent("11 listopada - Dzień Niepodległości");
        $this->addContent("19 grudnia - Mikołajki");
        $this->addContent("23 grudnia - Koniec semestru zimowego");
        
        $this->addContent("");
        $this->addContent("DRUGI SEMESTR:", true, 12);
        $this->addContent("9 stycznia - Powrót do przedszkola");
        $this->addContent("14 lutego - Dzień Walentynki");
        $this->addContent("9 marca - Dzień Kobiet");
        $this->addContent("30 marca - Wielkanoc");
        $this->addContent("23 kwietnia - Światowy Dzień Książki");
        $this->addContent("1 maja - Dzień Pracy");
        $this->addContent("19 maja - Dzień Matki");
        $this->addContent("30 maja - Pożegnanie przedszkolakiów");
        $this->addContent("31 czerwca - Koniec roku szkolnego");
    }
    
    public function generateMenuPDF() {
        $this->addTitle("JADŁOSPIS");
        
        $this->addContent("ZASADY ŻYWIENIA:", true, 12);
        $this->addContent("• Posiłki przygotowywane we własnej kuchni");
        $this->addContent("• Świeże produkty wysokiej jakości");
        $this->addContent("• Zbilansowana dieta");
        $this->addContent("• Opcje bez glutenu dostępne");
        $this->addContent("• Indywidualne ograniczenia dietetyczne możliwe");
        
        $this->addContent("");
        $this->addContent("HARMONOGRAM POSIŁKÓW:", true, 12);
        $this->addContent("7:30-8:30 - Śniadanie");
        $this->addContent("9:00-9:30 - Śniadanie główne");
        $this->addContent("11:30-12:00 - Drugie śniadanie");
        $this->addContent("12:00-13:00 - Obiad");
        $this->addContent("15:00-15:30 - Podwieczorek");
        
        $this->addContent("");
        $this->addContent("PRZYKŁADOWY JADŁOSPIS:", true, 12);
        $this->addContent("PONIEDZIAŁEK: rosół, klopsiki, surówka");
        $this->addContent("WTOREK: żurek ze słonką, żytni");
        $this->addContent("ŚRODA: mielone mięso, marchewka, brukselka");
        $this->addContent("CZWARTEK: kurczak, ziemniaki, mizeria");
        $this->addContent("PIĄTEK: pierś z kurczaka, makaron, sałata");
        
        $this->addContent("");
        $this->addContent("ALERGENY:", true, 12);
        $this->addContent("Informuj nas o alergach i nietolerancjach");
        $this->addContent("Wymagane zaświadczenie lekarskie");
    }
}

?>
