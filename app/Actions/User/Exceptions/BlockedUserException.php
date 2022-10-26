<?php

declare(strict_types=1);

namespace App\Actions\User\Exceptions;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BlockedUserException extends Exception implements Responsable
{
    /**
     * @param  Request  $request
     */
    public function toResponse($request): Response|JsonResponse
    {
        if ($request->api()) {
            return \response()->json(['message' => $this->message], 423);
        }

        return \response()->view('errors.user-blocked')->setStatusCode(423);
    }
}
