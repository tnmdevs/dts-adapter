<?php

namespace TNM\DTS\Http\Controllers;

use Illuminate\Http\JsonResponse;
use TNM\DTS\Models\Transaction;
use TNM\DTS\Responses\DTSResult;
use TransactionRequest;

class TransactionCallbackController extends Controller
{
    public function __invoke(string $conversation, TransactionRequest $request): JsonResponse
    {
        $now = microtime(true) * 1000;
        $result = new DTSResult($request->getContent());

        $conversation = Transaction::findById($conversation);

        $conversation->update([
            'result_at' => $now,
            'result_milliseconds' => $now - $conversation->{'requested_at'},
            'result_body' => $request->getContent(),
            'result_message' => $result->getMessage(),
            'status' => $result->status(),
            'success' => $result->success()
        ]);

        return $this->respond()->ok()->json();
    }
}