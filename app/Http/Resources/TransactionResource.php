<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\Period;
use Carbon\Carbon;
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
            'period' => new PeriodResource(Period::find($this->period_id)),
            'category' => new CategoryResource(Category::find($this->category_id)),
            'code' => $this->code,
            'date' => date('j F Y', strtotime($this->date)),
            'income' => $this->income,
            'spending' => $this->spending,
            'description' => $this->description,
            'created_at' => $this->created_at->format('H:i, j F Y'),
            'updated_at' => $this->updated_at->format('H:i, j F Y')
        ];
    }
}
