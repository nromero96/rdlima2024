<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poster;
use App\Models\Work;
use App\Models\TemporaryFile;
use Illuminate\Support\Facades\Storage;

//log
use Illuminate\Support\Facades\Log;

class PosterController extends Controller
{
    public function index()
    {
        // $category_name = '';
        $data = [
            'category_name' => 'posters',
            'page_name' => 'posters',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
        ];

        //if user is logged role is Administator
        if (\Auth::user()->hasRole('Administrador') || \Auth::user()->hasRole('Secretaria') || \Auth::user()->id == '1849') {
            
            $search = request()->query('search');

            if($search){
                $posters = Work::join('users', 'works.user_id', '=', 'users.id')
                ->where('works.status', 'aceptado')
                ->where(function ($query) use ($search) {
                    $query->orWhereRaw('CONCAT(users.name, " ", users.lastname, " ", COALESCE(users.second_lastname, "")) LIKE ?', ["%{$search}%"])
                          ->orWhere('works.category', 'LIKE', "%{$search}%")
                          ->orWhere('works.knowledge_area', 'LIKE', "%{$search}%")
                          ->orWhere('works.id', 'LIKE', "%{$search}%")
                          ->orWhere('users.country', 'LIKE', "%{$search}%");
                })
                ->selectRaw('works.*, CONCAT(users.name, " ", users.lastname, " ", users.second_lastname) AS author, users.country')
                ->get();
            } else {
                $posters = Work::join('users', 'works.user_id', '=', 'users.id')
                ->where('works.status', 'aceptado')
                ->selectRaw('works.*, CONCAT(users.name, " ", users.lastname, " ", COALESCE(users.second_lastname, "")) AS author, users.country')
                ->get();
            }
        } else {
            $posters = Work::join('users', 'works.user_id', '=', 'users.id')
            ->where('works.status', 'aceptado')
            ->where('works.user_id', auth()->user()->id)
            ->selectRaw('works.*, CONCAT(users.name, " ", users.lastname, " ", users.second_lastname) AS author, users.country')
            ->get();
        }


        return view('pages.posters.index')->with($data)->with('posters', $posters);
    }

    public function uploadPosterFile(Request $request)
    {

        // Verificar si el usuario tiene acceso al trabajo
        $work = Work::where('user_id', auth()->id())->find($request->idposter);

        $temporaryfile_poster = TemporaryFile::where('folder', $request->poster)->first();

        // Comprobación de roles de administrador o secretaria
        $user = \Auth::user();
        if ($work || $user->hasRole('Administrador') || $user->hasRole('Secretaria')) {
            
            if($temporaryfile_poster){
                $work = Work::Where('id', $request->idposter)->first();
                Storage::move('public/uploads/tmp/'.$request->poster.'/'.$temporaryfile_poster->filename, 'public/uploads/poster_files/'.$temporaryfile_poster->filename);
                $work->poster_file = $temporaryfile_poster->filename;
                $work->poster_date_uploaded = now();
                $work->save();
                rmdir(storage_path('app/public/uploads/tmp/'.$request->poster));
                $temporaryfile_poster->delete();
            }
            return redirect()->route('posters.index')->with('success', 'Poster # '.$request->idposter.' subido correctamente, verificaremos su contenido.');
        } else {

            if($temporaryfile_poster){
                // Eliminar archivo temporal
                Storage::delete('public/uploads/tmp/'.$request->poster.'/'.$temporaryfile_poster->filename);
                $temporaryfile_poster->delete();
                rmdir(storage_path('app/public/uploads/tmp/'.$request->poster));
            }

            return redirect()->route('posters.index')->with('error', 'No tienes permisos para subir el poster # '.$request->idposter);
        }

    }

    public function deletePosterFile($id)
    {
        $miwork = Work::where('user_id', auth()->id())->find($id);
        $user = \Auth::user();

        if($miwork || $user->hasRole('Administrador') || $user->hasRole('Secretaria') || \Auth::user()->id == '1849'){
            $work = Work::find($id);
            $work->poster_file = null;
            $work->poster_date_uploaded = null;
            $work->save();
            return redirect()->route('posters.index')->with('success', 'El archivo del poster # '.$id.' ha sido eliminado.');
        } else {
            return redirect()->route('posters.index')->with('error', 'No tienes permisos para eliminar el archivo del poster # '.$id);
        }
    }

    public function confirmPosterFile($id)
    {
        $user = \Auth::user();
        if($user->hasRole('Administrador') || $user->hasRole('Secretaria') || \Auth::user()->id == '1849'){
            $work = Work::find($id);
            $work->poster_verification_status = 'si';
            $work->save();
            return redirect()->route('posters.index')->with('success', 'El archivo del poster # '.$id.' ha sido confirmado.');
        } else {
            return redirect()->route('posters.index')->with('error', 'No tienes permisos para confirmar el archivo del poster # '.$id);
        }
    }

}
