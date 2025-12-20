<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\FileUploadService;
use App\Service\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UploadFileControllerApi extends Controller
{
    protected UserService $userService;
    protected FileUploadService $fileUploadService;

    public function __construct(UserService $userService, FileUploadService $fileUploadService)
    {
        $this->userService = $userService;
        $this->fileUploadService = $fileUploadService;
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
}
