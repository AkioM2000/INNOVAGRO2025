<?php

require 'vendor/autoload.php';

use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\Style\Color;
use PhpOffice\PhpPresentation\Style\Alignment;
use PhpOffice\PhpPresentation\Style\Bullet;
use PhpOffice\PhpPresentation\Slide\Background\Color as BgColor;

// Create new PHPPresentation object
$objPHPPresentation = new PhpPresentation();

// Set properties
$objPHPPresentation->getDocumentProperties()
    ->setCreator("Office Archive Management")
    ->setLastModifiedBy("System")
    ->setTitle("Office Archive Management System")
    ->setSubject("Presentasi Aplikasi Manajemen Arsip")
    ->setDescription('Presentasi untuk Office Archive Management System')
    ->setKeywords('office archive management system')
    ->setCategory('Presentasi');

// Set default font
$objPHPPresentation->getDefaultStyle()
    ->getFont()->setName('Arial')
    ->setSize(10);

// Define colors
$primaryColor = new Color('2B579A');
$secondaryColor = new Color('4472C4');
$accentColor = new Color('ED7D31');

// ===== SLIDE 1: TITLE =====
$currentSlide = $objPHPPresentation->getActiveSlide();
$currentSlide->getBackground()->setFillType(new BgColor())->setColor($primaryColor);

// Add title
$shape = $currentSlide->createRichTextShape()
    ->setHeight(100)
    ->setWidth(900)
    ->setOffsetX(10)
    ->setOffsetY(150);
$shape->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$textRun = $shape->createTextRun('Office Archive Management System');
$textRun->getFont()
    ->setBold(true)
    ->setSize(36)
    ->setColor(new Color('FFFFFF'));

// Add subtitle
$shape = $currentSlide->createRichTextShape()
    ->setHeight(60)
    ->setWidth(900)
    ->setOffsetX(10)
    ->setOffsetY(250);
$shape->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$textRun = $shape->createTextRun('Solusi Digital untuk Manajemen Dokumen Perkantoran yang Efisien');
$textRun->getFont()
    ->setSize(20)
    ->setColor(new Color('FFFFFF'));

// Add footer
$shape = $currentSlide->createRichTextShape()
    ->setHeight(30)
    ->setWidth(600)
    ->setOffsetX(10)
    ->setOffsetY(500);
$textRun = $shape->createTextRun('Presentasi - ' . date('d F Y'));
$textRun->getFont()
    ->setSize(12)
    ->setColor(new Color('FFFFFF'));

// ===== SLIDE 2: AGENDA =====
$currentSlide = $objPHPPresentation->createSlide();
$this->addTitle($currentSlide, 'Agenda');

$agendaItems = [
    'Gambaran Umum Sistem',
    'Fitur Utama Aplikasi',
    'Teknologi yang Digunakan',
    'Demo Aplikasi',
    'Keunggulan Solusi',
    'Rencana Pengembangan'
];

$this->addBulletPoints($currentSlide, $agendaItems, 150);

// ===== SLIDE 3: GAMBARAN UMUM =====
$currentSlide = $objPHPPresentation->createSlide();
$this->addTitle($currentSlide, 'Gambaran Umum');

$points = [
    'Platform manajemen dokumen digital terintegrasi',
    'Menyediakan solusi pengarsipan yang terstruktur',
    'Mendukung berbagai format dokumen',
    'Memudahkan pelacakan dan pencarian dokumen',
    'Mengotomatiskan alur kerja persetujuan dokumen'
];

$this->addBulletPoints($currentSlide, $points, 150);

// ===== SLIDE 4: FITUR UTAMA 1 =====
$currentSlide = $objPHPPresentation->createSlide();
$this->addTitle($currentSlide, 'Fitur Utama - Manajemen Dokumen');

$points = [
    'Upload berbagai format file (PDF, DOC, XLS, dll)',
    'Pencarian canggih dengan filter',
    'Preview dokumen langsung di browser',
    'Riwayat perubahan dan versi dokumen',
    'Manajemen kategori terstruktur'
];

$this->addBulletPoints($currentSlide, $points, 150);

// ===== SLIDE 5: FITUR UTAMA 2 =====
$currentSlide = $objPHPPresentation->createSlide();
$this->addTitle($currentSlide, 'Fitur Utama - SPK & PPBJ');

$points = [
    'Form pengajuan online yang mudah digunakan',
    'Proses persetujuan multi-level',
    'Notifikasi real-time',
    'Pelacakan status pengajuan',
    'Arsip digital dokumen yang disetujui'
];

$this->addBulletPoints($currentSlide, $points, 150);

// ===== SLIDE 6: TEKNOLOGI =====
$currentSlide = $objPHPPresentation->createSlide();
$this->addTitle($currentSlide, 'Teknologi yang Digunakan');

$tech = [
    'Backend: PHP 8.1+, Laravel 10.x, MySQL 8.0+',
    'Frontend: Bootstrap 5, jQuery, DataTables',
    'Keamanan: Autentikasi multi-faktor, Enkripsi data, Audit log',
    'Hosting: Dapat di-host di berbagai platform cloud'
];

$this->addBulletPoints($currentSlide, $tech, 150);

// ===== SLIDE 7: DEMO =====
$currentSlide = $objPHPPresentation->createSlide();
$this->addTitle($currentSlide, 'Demo Aplikasi');

$points = [
    'Login dan Dashboard',
    'Manajemen Dokumen',
    'Pengajuan SPK & PPBJ',
    'Manajemen Pengguna',
    'Laporan dan Analitik'
];

$this->addBulletPoints($currentSlide, $points, 150, 32);

// ===== SLIDE 8: KEUNGGULAN =====
$currentSlide = $objPHPPresentation->createSlide();
$this->addTitle($currentSlide, 'Keunggulan Solusi');

$points = [
    'Efisiensi waktu dengan pengelolaan dokumen terpusat',
    'Akses mudah kapan saja, di mana saja',
    'Keamanan data terjamin dengan enkripsi',
    'Antarmuka yang ramah pengguna',
    'Dapat disesuaikan dengan kebutuhan bisnis'
];

$this->addBulletPoints($currentSlide, $points, 150);

// ===== SLIDE 9: RENCANA PENGEMBANGAN =====
$currentSlide = $objPHPPresentation->createSlide();
$this->addTitle($currentSlide, 'Rencana Pengembangan');

$points = [
    'Integrasi dengan layanan cloud storage',
    'Pengembangan aplikasi mobile',
    'Fitur tanda tangan digital',
    'Analitik dan pelaporan yang lebih canggih',
    'Integrasi dengan sistem eksternal'
];

$this->addBulletPoints($currentSlide, $points, 150);

// ===== SLIDE 10: PENUTUP =====
$currentSlide = $objPHPPresentation->createSlide();
$currentSlide->getBackground()->setFillType(new BgColor())->setColor($primaryColor);

// Add title
$shape = $currentSlide->createRichTextShape()
    ->setHeight(100)
    ->setWidth(900)
    ->setOffsetX(10)
    ->setOffsetY(150);
$shape->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$textRun = $shape->createTextRun('Terima Kasih');
$textRun->getFont()
    ->setBold(true)
    ->setSize(48)
    ->setColor(new Color('FFFFFF'));

// Add subtitle
$shape = $currentSlide->createRichTextShape()
    ->setHeight(60)
    ->setWidth(900)
    ->setOffsetX(10)
    ->setOffsetY(250);
$shape->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$textRun = $shape->createTextRun('Ada pertanyaan?');
$textRun->getFont()
    ->setSize(28)
    ->setColor(new Color('FFFFFF'));

// Add contact info
$contacts = [
    '📧 info@perusahaananda.com',
    '📱 +62 822-8721-8274',
    '🌐 www.perusahaananda.com'
];

$yPos = 350;
foreach ($contacts as $contact) {
    $shape = $currentSlide->createRichTextShape()
        ->setHeight(40)
        ->setWidth(600)
        ->setOffsetX(160)
        ->setOffsetY($yPos);
    $shape->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $textRun = $shape->createTextRun($contact);
    $textRun->getFont()
        ->setSize(20)
        ->setColor(new Color('FFFFFF'));
    
    $yPos += 50;
}

// Add footer
$shape = $currentSlide->createRichTextShape()
    ->setHeight(20)
    ->setWidth(900)
    ->setOffsetX(10)
    ->setOffsetY(550);
$shape->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$textRun = $shape->createTextRun('© 2024 Office Archive Management System. All rights reserved.');
$textRun->getFont()
    ->setSize(10)
    ->setColor(new Color('CCCCCC'));

// Save file
$oWriterPPTX = IOFactory::createWriter($objPHPPresentation, 'PowerPoint2007');
$oWriterPPTX->save('presentasi_office_archive.pptx');

echo "Presentasi berhasil dibuat: presentasi_office_archive.pptx";

/**
 * Helper function to add title to slide
 */
function addTitle($slide, $title) {
    $shape = $slide->createRichTextShape()
        ->setHeight(50)
        ->setWidth(900)
        ->setOffsetX(10)
        ->setOffsetY(50);
    $shape->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $textRun = $shape->createTextRun($title);
    $textRun->getFont()
        ->setBold(true)
        ->setSize(32)
        ->setColor(new Color('2B579A'));
}

/**
 * Helper function to add bullet points to slide
 */
function addBulletPoints($slide, $items, $yStart = 100, $fontSize = 24) {
    $yPos = $yStart;
    
    foreach ($items as $item) {
        $shape = $slide->createRichTextShape()
            ->setHeight(40)
            ->setWidth(800)
            ->setOffsetX(100)
            ->setOffsetY($yPos);
        
        $shape->getActiveParagraph()
            ->getBulletStyle()
            ->setBulletType(Bullet::TYPE_BULLET)
            ->setBulletChar('•');
            
        $textRun = $shape->createTextRun($item);
        $textRun->getFont()
            ->setSize($fontSize)
            ->setColor(new Color('000000'));
        
        $yPos += 50;
    }
}
