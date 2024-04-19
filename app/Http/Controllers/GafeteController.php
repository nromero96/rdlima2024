<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inscription;

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
                ->select('inscriptions.*', 'category_inscriptions.name as category_inscription_name', 'users.name as user_name', 'users.lastname as user_lastname', 'users.second_lastname as user_second_lastname', 'users.country as user_country')
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

        //GET path logo and firma
        $bgimage = public_path('assets/img/90x90.jpg');

        $inscriptions = Inscription::join('category_inscriptions', 'inscriptions.category_inscription_id', '=', 'category_inscriptions.id')
                ->join('users', 'inscriptions.user_id', '=', 'users.id')
                ->select('inscriptions.*', 'category_inscriptions.name as category_inscription_name', 'users.name as user_name', 'users.lastname as user_lastname', 'users.second_lastname as user_second_lastname', 'users.country as user_country', 'users.solapin_name as solapin_name')
                ->where('inscriptions.id', $id)
                ->first();


        $nombresolapin = <<<EOD
            <h2 style="text-align: center;">{$inscriptions->solapin_name}</h2>
        EOD;

        $pdf = new TCPDF();
        $pdf->SetCreator('XLI Reunión Anual de Dermatólogos Latinoamericanos');
        $pdf->SetAuthor('XLI Reunión Anual de Dermatólogos Latinoamericanos');
        $pdf->SetTitle('Gafete');
        $pdf->SetSubject('Gafete');
        $pdf->SetKeywords('Gafete, XLI Reunión Anual de Dermatólogos Latinoamericanos, Swissôtel Lima, 8 al 11 de Mayo de 2024');
        $pdf->SetAutoPageBreak(TRUE, 0);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(0, 0, 0);
        $pdf->AddPage();

        $pdf->Image($bgimage, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
        //nombresolapin centro en solo una cuarta parte de la hoja
        
        $pdf->writeHTMLCell(40, 0, 10, 50, $nombresolapin, 0, 1, 0, true, 'C', true);

        $pdf->Output('gafete.pdf', 'I');

        return $pdf->Output('gafete.pdf', 'I');

    }

    public function gafeteForAccompanist($id)
    {
        echo "Se generará el gafe para el acompañante con id: $id";
    }

}
