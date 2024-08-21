<?php
require_once "../connection.php";
require('fpdf/fpdf.php');

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Data Cuti Karyawan Toko Imanuel', 0, 1, 'C');
        $this->Ln(10);
    }

    // Page footer
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

    // Table
    function LoadData($conn)
    {
        $sql = "SELECT * FROM emp_leave WHERE status = 'accepted'";
        $result = mysqli_query($conn, $sql);
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }

    function CreateTable($header, $data)
    {
        $this->SetFont('Arial', 'B', 12);
        foreach ($header as $col) {
            $this->Cell(30, 7, $col, 1);
        }
        $this->Ln();

        $this->SetFont('Arial', '', 12);
        foreach ($data as $row) {
            $this->Cell(30, 6, $row['email'], 1);
            $this->Cell(30, 6, date("jS F", strtotime($row['start_date'])), 1);
            $this->Cell(30, 6, date("jS F", strtotime($row['last_date'])), 1);
            $this->Cell(30, 6, date_diff(date_create($row['start_date']), date_create($row['last_date']))->format("%a days"), 1);
            $this->Cell(30, 6, $row['reason'], 1);
            $this->Cell(30, 6, $row['status'], 1);
            $this->Ln();
        }
    }
}

$pdf = new PDF();
$header = ['Email', 'Tgl Mulai', 'Tgl Berakhir', 'Total Hari', 'Alasan', 'Status'];
$data = $pdf->LoadData($conn);

$pdf->AddPage();
$pdf->CreateTable($header, $data);
$pdf->Output();
