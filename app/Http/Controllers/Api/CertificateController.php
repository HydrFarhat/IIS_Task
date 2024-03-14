<?php

namespace App\Http\Controllers\Api;

use App\Models\Certificate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Response;

class CertificateController
{
    public function all(): JsonResponse
    {
        $certificates = Certificate::query()->get();

        return response()->json([
            'message' =>'success',
            'data'=> $certificates
        ]);
    }

    public function create(Request $request): JsonResponse
    {
        $request->validate([
           'name' => ['required', 'string', "unique:certificates"]
        ]);

        $certificate = Certificate::query()->create([
           'name' => $request->input('name')
        ]);

        return response()->json([
            'message' =>'success',
            'data'=> $certificate
        ]);
    }

    public function delete(Certificate $certificate): JsonResponse
    {
        $certificate->delete();

        return response()->json([
            'message' =>'success',
        ]);
    }
    public function view()
    {
        $certificates = Certificate::query()
            ->withCount("users")
            ->get();

        return view('certificate', compact('certificates'));
    }

    public function export()
    {
        $certificates = Certificate::query()
            ->withCount("users")
            ->get();

        $pdf = new Dompdf();
        $pdf->loadHtml(View::make('certificate', compact('certificates'))->render());

        // (Optional) Adjust PDF settings if needed
        $pdf->setPaper('A4', 'landscape');

        $pdf->render();

        $output = $pdf->output();

        $response = new Response($output);
        $response->header('Content-Type', 'application/pdf');
        $response->header('Content-Disposition', 'attachment; filename="certificates.pdf"');

        return $response;


    }


}
