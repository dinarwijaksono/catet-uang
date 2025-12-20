<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FileResource;
use App\Service\FileUploadService;
use App\Service\TransactionService;
use App\Service\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UploadFileControllerApi extends Controller
{
    protected UserService $userService;
    protected FileUploadService $fileUploadService;
    protected TransactionService $transactionService;

    public function __construct(
        UserService $userService,
        FileUploadService $fileUploadService,
        TransactionService $transactionService
    ) {
        $this->userService = $userService;
        $this->fileUploadService = $fileUploadService;
        $this->transactionService = $transactionService;
    }

    public function uploadCsv(Request $request): ?JsonResponse
    {
        $token = $request->header('api-token');
        $user = $this->userService->findByToken($token);

        $validate = Validator::make($request->all(), [
            'file' => 'required|file|max:5120|extensions:csv'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors()
            ], 422);
        }

        $file = $this->fileUploadService->create($user->user_id, $request->file->getClientOriginalName());

        $request->file->storeAs('file_for_import', $file->file_name, 'public-custom');

        return response()->json([
            'message' => "File berhasil diupload."
        ], 201);
    }

    public function getAll(Request $request): ?JsonResponse
    {
        $token = $request->header('api-token');
        $user = $this->userService->findByToken($token);

        $file = $this->fileUploadService->getAll($user->user_id);

        return response()->json([
            "data" => FileResource::collection($file)
        ], 200);
    }

    public function generatCsv(Request $request, int $fileId)
    {
        $api = $request->header('api-token');
        $token = $this->userService->findByToken($api);

        $fileUpload = $this->fileUploadService->findById($fileId);
        if (!$fileUpload) {
            return response()->json([
                'message' => "File rusak."
            ], 400);
        }

        $storage = Storage::disk('public-custom');
        $path = 'file_for_import/' . $fileUpload->file_name;

        if (!$storage->exists($path)) {
            return response()->json([
                'message' => "File rusak."
            ], 400);
        }

        if ($fileUpload->is_generate) {
            return response()->json([
                'message' => "File sudah digenerate."
            ], 400);
        }

        $transaction = $this->fileUploadService->parseCsvToArray($storage->get($path));

        if (!empty($transaction['errors'])) {
            $this->fileUploadService->update($token->user_id, $fileUpload->file_name, $transaction['errors'][0]);
            return response()->json([
                'message' => $transaction['errors'][0]
            ], 422);
        }

        if (empty($transaction['result'])) {
            $this->fileUploadService->update($token->user_id, $fileUpload->file_name, "isi file kosong");
            return response()->json([
                'message' => "Isi file kosong."
            ], 422);
        }

        $this->transactionService->createFromArray($token->user_id, $transaction['result']);
        $this->fileUploadService->update($token->user_id, $fileUpload->file_name, "Generate success");

        return response()->json([
            'message' => "File berhasil digenerate."
        ], 200);
    }
}
