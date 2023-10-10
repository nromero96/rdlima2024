<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Work;
use App\Models\User;
use App\Models\TemporaryFile;
use Illuminate\Support\Facades\Storage;

use App\Mail\WorkCreatedMail;
use Illuminate\Support\Facades\Mail;

class WorkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userid = \Auth::user()->id;

        $data = [
            'category_name' => 'works',
            'page_name' => 'works',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];

        //show all works for role admin and user
        if (\Auth::user()->hasRole('Administrador') || \Auth::user()->hasRole('Secretaria')) {
            
            //get works join with user
            $works = Work::join('users', 'works.user_id', '=', 'users.id')
                ->select('works.*', 'users.name as user_name', 'users.lastname as user_lastname', 'users.second_lastname as user_second_lastname', 'users.country as user_country')
                ->orderBy('id', 'desc')
                ->get();
        } else {
            
            //get works by user id join with user
            $works = Work::join('users', 'works.user_id', '=', 'users.id')
                ->select('works.*', 'users.name as user_name', 'users.lastname as user_lastname', 'users.second_lastname as user_second_lastname', 'users.country as user_country')
                ->where('works.user_id', $userid)
                ->orderBy('id', 'desc')
                ->get();

        }
        return view('pages.works.index')->with($data)->with('works', $works);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id = \Auth::user()->id;

        $data = [
            'category_name' => 'works',
            'page_name' => 'works_create',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];

        $user = User::find($id);

        return view('pages.works.create')->with($data)->with('user', $user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    $id = \Auth::user()->id;

    $request->validate([
        'knowledge_area' => 'required',
        'category' => 'required',
    ]);

    $action = $request->input('action'); // Obtén el valor del botón presionado

    $workData = [
        'knowledge_area' => $request->get('knowledge_area'),
        'category' => $request->get('category'),
        'author_coauthors' => $request->get('author_coauthors'),
        'institution' => $request->get('institution'),
        'user_id' => $id,
        'title' => $request->get('title'),
        'description' => $request->get('description'),
        'status' => $action,
    ];

    $fileFields = ['file_1', 'file_2', 'file_3', 'file_4', 'file_5', 'file_6'];

    foreach ($fileFields as $fieldName) {
        $temporaryfile = TemporaryFile::where('folder', $request->input($fieldName))->first();

        if ($temporaryfile) {
            $filename = $temporaryfile->filename;
            $sourcePath = 'public/uploads/tmp/' . $request->input($fieldName) . '/' . $filename;
            $destinationPath = 'public/uploads/abstract_file/' . $filename;

            Storage::move($sourcePath, $destinationPath);
            $workData[$fieldName] = $filename;

            $temporaryfile->delete();

            $folderPath = storage_path('app/public/uploads/tmp/' . $request->input($fieldName));

            if (is_dir($folderPath)) {
                rmdir($folderPath);
            }
        }
    }

    $work = new Work($workData);
    $work->save();

    // Redirigir según el valor de $action
    if ($action == 'borrador') {
        return redirect()->route('works.edit', ['work' => $work->id])->with('success', 'Trabajo agregado exitosamente.');
    } elseif ($action == 'finalizado') {
        $work = Work::find($work->id);
        $iduser = \Auth::user()->id;
        $user = User::find($iduser);
        Mail::to($user->email)->cc(config('services.correonotificacion.trabajo'))->send(new WorkCreatedMail($work));
        return redirect()->route('works.index')->with('success', 'Trabajo agregado exitosamente.');
    }
}



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //validate if work is from user logged
        $work = Work::find($id);
        $iduser = \Auth::user()->id;

        if ($work->user_id != $iduser && !\Auth::user()->hasRole('Administrador') && !\Auth::user()->hasRole('Calificador')) {
            return redirect()->route('works.index')->with('error', 'No tienes permiso para ver este trabajo.');
        }

        $data = [
            'category_name' => 'works',
            'page_name' => 'works_edit',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];

        $user = User::find($iduser);

        //get works by id join with user
        $work = Work::join('users', 'works.user_id', '=', 'users.id')
            ->select('works.*', 'users.name', 'users.lastname', 'users.second_lastname')
            ->where('works.id', $id)
            ->first();
        return view('pages.works.show')->with($data)->with('work', $work);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        //validate if work is from user logged
        $work = Work::find($id);
        $iduser = \Auth::user()->id;

        if ($work->user_id != $iduser) {
            return redirect()->route('works.index')->with('error', 'No tienes permiso para editar este trabajo.');
        }

        $data = [
            'category_name' => 'works',
            'page_name' => 'works_edit',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];

        $user = User::find($iduser);

        //get works by id join with user
        $work = Work::join('users', 'works.user_id', '=', 'users.id')
            ->select('works.*', 'users.name', 'users.lastname', 'users.second_lastname')
            ->where('works.id', $id)
            ->first();
        return view('pages.works.edit')->with($data)->with('work', $work);
    

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
        //update work and files except knowledge_area and category
        //no validation
        $work = Work::find($id);

        $action = $request->input('action'); // Obtén el valor del botón presionado

        $work->author_coauthors = $request->get('author_coauthors');
        $work->institution = $request->get('institution');
        $work->title = $request->get('title');
        $work->description = $request->get('description');
        $work->status = $action;

        $fileFields = ['file_1', 'file_2', 'file_3', 'file_4', 'file_5', 'file_6'];

        foreach ($fileFields as $fieldName) {
            $temporaryfile = TemporaryFile::where('folder', $request->input($fieldName))->first();

            if ($temporaryfile) {
                $filename = $temporaryfile->filename;
                $sourcePath = 'public/uploads/tmp/' . $request->input($fieldName) . '/' . $filename;
                $destinationPath = 'public/uploads/abstract_file/' . $filename;

                Storage::move($sourcePath, $destinationPath);
                $work[$fieldName] = $filename;

                $temporaryfile->delete();

                $folderPath = storage_path('app/public/uploads/tmp/' . $request->input($fieldName));

                if (is_dir($folderPath)) {
                    rmdir($folderPath);
                }
            }
        }

        $work->save();

        // Redirigir según el valor de $action
        if ($action == 'borrador') {
            return redirect()->route('works.edit', ['work' => $work->id])->with('success', 'Trabajo actualizado exitosamente.');
        } elseif ($action == 'finalizado') {
            $work = Work::find($work->id);
            $iduser = \Auth::user()->id;
            $user = User::find($iduser);
            Mail::to($user->email)->cc('niltondeveloper96@gmail.com')->send(new WorkCreatedMail($work));
            return redirect()->route('works.index')->with('success', 'Trabajo actualizado exitosamente.');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
            //validate if work is from user logged
            $work = Work::find($id);
            $iduser = \Auth::user()->id;
        
            if ($work->user_id != $iduser) {
                return redirect()->route('works.index')->with('error', 'No tienes permiso para eliminar este trabajo.');
            }
            $work->delete();
            return redirect()->route('works.index')->with('success', 'Trabajo eliminado exitosamente.');
    }


    public function deleteFile(Request $request, $workId, $fileNumber)
    {
        // Encuentra el trabajo por su ID
        $work = Work::find($workId);

        if (!$work) {
            return response()->json(['success' => false, 'message' => 'Trabajo no encontrado.']);
        }

        // Verifica si el archivo existe en función del número proporcionado
        $fileColumn = 'file_' . $fileNumber;

        if (!$work->$fileColumn) {
            return response()->json(['success' => false, 'message' => 'Archivo no encontrado para este trabajo.']);
        }

        // Obtiene la ruta del archivo desde la base de datos
        $filePath = 'public/uploads/' . $work->$fileColumn;

        // Verifica si el archivo existe en el sistema de archivos
        if (Storage::exists($filePath)) {
            // Elimina el archivo del sistema de archivos
            Storage::delete($filePath);
        }

        // Luego, establece el campo del archivo en nulo en la base de datos
        $work->$fileColumn = null;
        $work->save();

        return response()->json(['success' => true, 'message' => 'Archivo eliminado con éxito.']);
    }

}
