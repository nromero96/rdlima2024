<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inscription;
use App\Models\Accompanist;

use TCPDF;

class GafeteController extends Controller
{
    public function index()
    {
        $data = [
            'category_name' => 'gafetes',
            'page_name' => 'gafetes',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];

        $listforpage = request()->query('listforpage') ?? 10;
        $search = request()->query('search');

        $inscriptions = Inscription::join('category_inscriptions', 'inscriptions.category_inscription_id', '=', 'category_inscriptions.id')
                ->join('users', 'inscriptions.user_id', '=', 'users.id')
                ->select('inscriptions.*', 'category_inscriptions.name as category_inscription_name', 'users.name as user_name', 'users.lastname as user_lastname', 'users.second_lastname as user_second_lastname', 'users.country as user_country', 'users.solapin_name as solapin_name')
                ->where('inscriptions.status', 'Pagado')
                ->where(function ($query) use ($search) {
                        $query->where('inscriptions.id', 'LIKE', "%{$search}%")
                            ->orWhere('users.country', 'LIKE', "%{$search}%")
                            ->orWhere('category_inscriptions.name', 'LIKE', "%{$search}%")
                            ->orWhere('inscriptions.special_code', 'LIKE', "%{$search}%")
                            ->orWhere('inscriptions.payment_method', 'LIKE', "%{$search}%")
                            ->orWhereRaw('CONCAT(COALESCE(users.name, ""), " ", COALESCE(users.lastname, ""), " ", COALESCE(users.second_lastname, "")) LIKE ?', ["%{$search}%"]);
                })
                ->orderBy('inscriptions.id', 'desc')
                ->paginate($listforpage);

        return view('pages.gafetes.index')->with($data)->with('inscriptions', $inscriptions);
    }

    public function gafeteForParticipant($id)
    {

        // verificar si el usuario logueado es su inscripción
        $myinscriptions = Inscription::where('id', $id)
            ->where('user_id', auth()->user()->id)
            ->first();

        //validar si es $myinscriptions o tengo rol de Administrador, Secretaria o Coordinador
        if (!$myinscriptions && !auth()->user()->hasRole(['Administrador', 'Secretaria', 'Check-in'])) {
            echo "La inscripción no pertenece al usuario actual o no tiene permisos para ver este gafete.";
            return false;
        }

        // Validar si la inscripción está pagada y pertenece al usuario logueado
        $inscripcionpagado = Inscription::where('id', $id)
            ->where('status', 'Pagado')
            ->first();

        if (!$inscripcionpagado) {
            echo "La inscripción no está pagada y no se puede generar el gafete.";
            return false;
        }

        //GET path logo and firma
        $bgimage = public_path('assets/img/bg-gafete.png');

        $inscriptions = Inscription::join('category_inscriptions', 'inscriptions.category_inscription_id', '=', 'category_inscriptions.id')
                ->join('users', 'inscriptions.user_id', '=', 'users.id')
                ->select('inscriptions.*', 'category_inscriptions.name as category_inscription_name', 'users.name as user_name', 'users.lastname as user_lastname', 'users.second_lastname as user_second_lastname', 'users.country as user_country', 'users.solapin_name as solapin_name')
                ->where('inscriptions.id', $id)
                ->first();

        //de esto $inscriptions->solapin_name extrar hasta el primer espacio
        $pdfsolapin_name = explode(' ', $inscriptions->solapin_name);
        //de esto $inscriptions->solapin_name extraer despues del primer espacio
        $pdfsolapin_lastname = substr($inscriptions->solapin_name, strpos($inscriptions->solapin_name, ' ') + 1);

        $rolparticipante = 'PARTICIPANTE';

        $nombresolapin = <<<EOD
            <h2 style="text-align: center; font-size: 24px; color:#000000;letter-spacing:-0.30mm;">{$pdfsolapin_name[0]}</h2>
        EOD;

        $apellidosopalin = <<<EOD
            <h2 style="text-align: center; font-size: 22px; color:#000000;letter-spacing:-0.30mm;">{$pdfsolapin_lastname}</h2>
        EOD;

        $pais = <<<EOD
            <h2 style="text-align: center; font-size: 18px; text-transform: uppercase; color:#094a91; letter-spacing:-0.30mm;">{$inscriptions->user_country}</h2>
        EOD;

        $idinscripcion = <<<EOD
            <h2 style="text-align: center; font-size: 18px; color:#000000;">{$inscriptions->id}</h2>
        EOD;

        $nivelparticipante = <<<EOD
            <h2 style="text-align: center; font-size: 16px; color:#bd3529;">{$rolparticipante}</h2>
        EOD;

        $pdf = new TCPDF();
        $pdf->SetCreator('XLI Reunión Anual de Dermatólogos Latinoamericanos');
        $pdf->SetAuthor('XLI Reunión Anual de Dermatólogos Latinoamericanos');
        $pdf->SetTitle('GAFETE: '.$inscriptions->id.'-'. $inscriptions->solapin_name);
        $pdf->SetSubject('GAFETE: '.$inscriptions->id.'-'. $inscriptions->solapin_name);
        $pdf->SetKeywords('GAFETE, XLI Reunión Anual de Dermatólogos Latinoamericanos, Swissôtel Lima, 8 al 11 de Mayo de 2024');
        $pdf->SetAutoPageBreak(TRUE, 0);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(0, 0, 0);
        $pdf->AddPage();

        //font
        $pdf->SetFont('dejavusans', '', 12);


        $pdf->Image($bgimage, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
        //nombresolapin centro en solo una cuarta parte de la hoja
        
        $pdf->writeHTMLCell(96, 0, 5, 67, $nombresolapin, 0, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(96, 0, 5, 80, $apellidosopalin, 0, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(96, 0, 5, 100, $pais, 0, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(96, 0, 5, 110, $idinscripcion, 0, 1, 0, true, 'C', true);
        //$pdf->writeHTMLCell(96, 0, 5, 125, $nivelparticipante, 0, 1, 0, true, 'C', true);
                        //anchos, alto, x, y, html, borde, salto de linea, ajuste, relleno, alineacion, fondo, link, estilo, orientacion
        $pdf->Output('GAFETE-'.$inscriptions->id.'-'.$inscriptions->solapin_name.'.pdf', 'I');

        return $pdf->Output('gafete.pdf', 'I');

    }

    public function gafeteForAccompanist($id)
    {

        // verificar si el usuario logueado es su inscripción
        $myinscriptions = Inscription::where('id', $id)
            ->where('user_id', auth()->user()->id)
            ->first();

        //validar si es $myinscriptions o tengo rol de Administrador, Secretaria o Coordinador
        if (!$myinscriptions && !auth()->user()->hasRole(['Administrador', 'Secretaria', 'Check-in'])) {
            echo "La inscripción no pertenece al usuario actual o no tiene permisos para ver este gafete.";
            return false;
        }

        // Validar si la inscripción está pagada y pertenece al usuario logueado
        $inscripcionpagado = Inscription::where('id', $id)
            ->where('status', 'Pagado')
            ->first();

        if (!$inscripcionpagado) {
            echo "La inscripción no está pagada y no se puede generar el gafete.";
            return false;
        }

        //verificar si la inscripción tiene acompañante
        $inscripacompanist = Inscription::where('id', $id)
            ->where('accompanist_id', '!=', null)
            ->first();

        if (!$inscripacompanist) {
            echo "La inscripción no tiene acompañante y no se puede generar el gafete.";
            return false;
        }

        //GET path logo and firma
        $bgimage = public_path('assets/img/bg-gafete.png');

        $inscriptions = Inscription::join('category_inscriptions', 'inscriptions.category_inscription_id', '=', 'category_inscriptions.id')
                ->join('users', 'inscriptions.user_id', '=', 'users.id')
                ->select('inscriptions.*', 'category_inscriptions.name as category_inscription_name', 'users.name as user_name', 'users.lastname as user_lastname', 'users.second_lastname as user_second_lastname', 'users.country as user_country', 'users.solapin_name as solapin_name')
                ->where('inscriptions.id', $id)
                ->first();

        $accompanist = Accompanist::where('id', $inscriptions->accompanist_id)
            ->first();

        //de esto $inscriptions->solapin_name extrar hasta el primer espacio
        $pdfsolapin_name = explode(' ', $accompanist->accompanist_solapin);
        //de esto $inscriptions->solapin_name extraer despues del primer espacio
        $pdfsolapin_lastname = substr($accompanist->accompanist_solapin, strpos($accompanist->accompanist_solapin, ' ') + 1);

        $rolparticipante = 'ACOMPAÑANTE';

        $nombresolapin = <<<EOD
            <h2 style="text-align: center; font-size: 24px; color:#000000;letter-spacing:-0.30mm;">{$pdfsolapin_name[0]}</h2>
        EOD;

        $apellidosopalin = <<<EOD
            <h2 style="text-align: center; font-size: 22px; color:#000000;letter-spacing:-0.30mm;">{$pdfsolapin_lastname}</h2>
        EOD;

        $pais = <<<EOD
            <h2 style="text-align: center; font-size: 18px; text-transform: uppercase; color:#094a91; letter-spacing:-0.30mm;">{$inscriptions->user_country}</h2>
        EOD;

        $idinscripcion = <<<EOD
            <h2 style="text-align: center; font-size: 18px; color:#000000;">{$inscriptions->id}</h2>
        EOD;

        $nivelparticipante = <<<EOD
            <h2 style="text-align: center; font-size: 16px; color:#bd3529;">{$rolparticipante}</h2>
        EOD;

        $pdf = new TCPDF();
        $pdf->SetCreator('XLI Reunión Anual de Dermatólogos Latinoamericanos');
        $pdf->SetAuthor('XLI Reunión Anual de Dermatólogos Latinoamericanos');
        $pdf->SetTitle('GAFETE: '.$inscriptions->id.'-'. $inscriptions->solapin_name);
        $pdf->SetSubject('GAFETE: '.$inscriptions->id.'-'. $inscriptions->solapin_name);
        $pdf->SetKeywords('GAFETE, XLI Reunión Anual de Dermatólogos Latinoamericanos, Swissôtel Lima, 8 al 11 de Mayo de 2024');
        $pdf->SetAutoPageBreak(TRUE, 0);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(0, 0, 0);
        $pdf->AddPage();

        //font
        $pdf->SetFont('dejavusans', '', 12);


        $pdf->Image($bgimage, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
        //nombresolapin centro en solo una cuarta parte de la hoja
        
        $pdf->writeHTMLCell(96, 0, 5, 67, $nombresolapin, 0, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(96, 0, 5, 80, $apellidosopalin, 0, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(96, 0, 5, 100, $pais, 0, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(96, 0, 5, 110, $idinscripcion, 0, 1, 0, true, 'C', true);
        $pdf->writeHTMLCell(96, 0, 5, 125, $nivelparticipante, 0, 1, 0, true, 'C', true);
                        //anchos, alto, x, y, html, borde, salto de linea, ajuste, relleno, alineacion, fondo, link, estilo, orientacion
        $pdf->Output('GAFETE-'.$inscriptions->id.'-'.$inscriptions->solapin_name.'.pdf', 'I');

        return $pdf->Output('gafete.pdf', 'I');

    }

}
