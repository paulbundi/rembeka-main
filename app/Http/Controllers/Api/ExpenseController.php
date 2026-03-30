<?php

namespace App\Http\Controllers\Api;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return Expense::class;
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'user', 'expenseType'
        ];
    }

    /**
     * Create a new Record.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'expense' => 'required',
        ]);

        $data =  $request->all();

        foreach ($data['expense']['expenseItems'] as $item) {
            $item['user_id'] = $data['user_id'];
            $item['total'] = $item['quantity'] * $item['amount'];

            Expense::create($item);
        }

        return response()->json();
    }
}
