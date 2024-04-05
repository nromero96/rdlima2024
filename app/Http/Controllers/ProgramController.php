<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\ProgramSession;
use App\Models\User;
use App\Models\Inscription;

use App\Mail\IndividualExhibitorProgramMail;
use Illuminate\Support\Facades\Mail;


class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $category_name = '';
        $data = [
            'category_name' => 'programs',
            'page_name' => 'programs',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];
        
        $programs = Program::orderByRaw("CONCAT(apellido, ' ', nombre)")->get();


        return view('pages.programs.index')->with($data)->with('programs', $programs);
    }

    public function showOnlinePrograms()
    {
        // $category_name = '';
        $data = [
            'category_name' => 'programs',
            'page_name' => 'online-programs',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];
        
        $programsession = ProgramSession::orderBy('id', 'desc')->get();
        $programs = Program::orderBy('id', 'desc')->get();

        return view('pages.programs.online-program')->with($data)->with('programsession', $programsession)->with('programs', $programs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function sendMailExhibitor($id){
        if(\Auth::user()->hasRole('Administrador')){
            $program = Program::find($id);

            echo 'Programa: '.$program->id.'<br>';

            $insc_id = $program->insc_id;

            echo 'Su Inscripcion es: '.$insc_id.'<br>';
            
            if($insc_id != null || $insc_id != ''){
                //buscar inscripcion
                $inscription = Inscription::where('id', $insc_id)->first();
                
                if($inscription != null){
                    echo 'Inscripcion econtrada: '.$inscription->id.'<br>';
                    
                    $user = User::where('id', $inscription->user_id)->first();

                    if($user != null){
                        echo 'Usuario econtrado: '.$user->id.'<br>';
                        echo 'Su nombre es: '.$user->name.' '.$user->lastname.' '.$user->second_lastname.'<br>';
                        echo 'Enviar a su correo: '.$user->email.'<br>';

                        try {
                            $cooreotest = 'diseno@exceldata.pe';
                            Mail::to($cooreotest)->send(new IndividualExhibitorProgramMail($inscription, $user));
                            echo 'Correo enviado exitosamente<br>';

                            //update program notificado = si
                            $program->notificado = 'si';
                            $program->save();

                        } catch (\Throwable $th) {
                            echo 'Error al enviar correo: '.$th->getMessage().'<br>';
                        }
                    }

                    exit;
                }

                echo 'Inscripcion no econtrada: '.$insc_id.'<br>';

                exit;
            }

            return 'No se encontro inscripcion';

            //Mail::to($user->email)->cc(config('services.correonotificacion.trabajoaceptado'))->send(new IndividualExhibitorProgramMail($program));
            //return redirect()->route('works.index')->with('success', 'Correo enviado exitosamente.');
            exit;
        }else{
            echo 'No tiene permisos para enviar correo';
            exit;
        }
    }

}
