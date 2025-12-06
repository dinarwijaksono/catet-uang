<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,
            'period' => new PeriodResource(Period::find($this->period_id)),
            'date' => $this->created_at->format('d-m-Y'),
            'income' => $this->income,
            'spending' => $this->spending,
            'description' => $this->description,
            'category' => new CategoryResource(Category::find($this->category_id)),
            'created_at' => $this->created_at->format('H:i, j F Y'),
            'updated_at' => $this->updated_at->format('H:i, j F Y')
        ];
    }
}
