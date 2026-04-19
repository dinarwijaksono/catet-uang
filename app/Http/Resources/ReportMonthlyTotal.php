<?php

namespace App\Http\Resources;

use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportMonthlyTotal extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'period' => new PeriodResource(Period::find($this->period)),
            'data' => [
                'total_income' => $this->total_income,
                'total_spending' => $this->total_spending,
                'difference' => $this->total_income - $this->total_spending
            ]
        ];
    }
}
