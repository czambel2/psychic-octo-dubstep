<?php

require_once "/../vendor/fpdf/fpdf.php";

class Diploma {
	protected $pdf;
	protected $cyclists = array();

	public function __construct() {
		$this->pdf = new FPDF();
		$this->pdf->SetFont('Arial', '', 14);
	}

	public function addCyclist($gender, $fullName, DateTime $raceDate, $circuit, $distance) {
		$this->cyclists[] = array(
			'gender' => $gender,
			'fullName' => $fullName,
			'raceDate' => $raceDate,
			'circuit' => $circuit,
			'distance' => $distance,
		);
	}

	public function get() {
		if(!empty($this->cyclists)) {
			foreach($this->cyclists as $cyclist) {
				$this->pdf->AddPage('L');
				$this->pdf->Ln(110);
				$this->pdf->Cell(0, 10, sprintf("%s a participé à l'édition %ld de la course de la Lionne qui s'est déroulée le %s.",
					$cyclist['fullName'], $cyclist['raceDate']->format('Y'), $cyclist['raceDate']->format('d/m/Y')), 0, 1, 'C');
				$this->pdf->Ln(10);
				$this->pdf->Cell(0, 10, sprintf('%s a parcouru le circuit %ld qui comportait %ld km.',
					$cyclist['gender'] == 'M' ? 'Il' : 'Elle', $cyclist['circuit'], $cyclist['distance']), 0, 1, 'C');
			}
		} else {
			$this->pdf->AddPage('L');
			$this->pdf->Ln(80);
			$this->pdf->SetFont('Arial', '', 28);
			$this->pdf->Cell(0, 10, "Aucun diplôme à imprimer", 0, 1, 'C');
		}

		return $this->pdf->Output(null, 'S');
	}
}