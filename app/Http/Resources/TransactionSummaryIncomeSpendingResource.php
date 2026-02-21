<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionSummaryIncomeSpendingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'date' => Carbon::createFromFormat('Y-m-d h:i:s', $this->date)->format('Y-m-d'),
            'total_income' => $this->total_income,
            'total_spending' => $this->total_spending
        ];
    }
}
