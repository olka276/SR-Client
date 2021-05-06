<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UploadingController
 * @package App\Http\Controllers
 * @author Aleksandra Kowalewska <kowalewska@trui.pl>
 */
class UploadingController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function uploadView()
    {
        $files = $this->getFiles();
        return view('upload')->with([
            'data' => $files
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getFiles() {
        $response = Http::get('http://localhost:8000/api/list');
        $data = json_decode($response->body());
        return $data->file;
    }

    /**
     * @param Request $request
     */
    public function prepare(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required',
            'name' => 'required'
        ], [
            'file.required' => 'Proszę wybrać plik.',
            'name.required' => 'Proszę podać nazwę pliku bez rozszerzenia.',
        ]);

        if($validator->fails()) {
            $arr = json_decode($validator->getMessageBag());
            foreach($arr as $prop) {
                $firstProp = $prop;
                break; // exits the foreach loop
            }
            return view('upload')->with([
                'error' => $firstProp[0]
            ]);
        }

        $files = $request->file;

        foreach ($files as $file) {
            $fileData = explode('.', $file->getClientOriginalName());
            $filename = $request->name;
            $extension = $fileData[count($fileData) - 1];

            $files = $this->getFiles();

            $base = base64_encode($file->get());

            $response = Http::post('http://localhost:8000/api/upload', [
                'base64' => $base,
                'name' => $filename,
                'extension' => $extension
            ]);

            if ($response->status() != Response::HTTP_CREATED) {
                return view('upload')->with([
                    'error' => 'Dodawanie pliku się nie powiodło',
                    'data' => $files
                ]);
            }

            return back()->with([
                'message' => 'Plik został dodany',
                'data' => $files
            ]);
        }
    }
}
