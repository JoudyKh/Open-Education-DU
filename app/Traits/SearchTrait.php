<?php

namespace App\Traits;
use App\Constants\Constants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


trait SearchTrait
{
    public function applySearchAndSort(&$query, Request $request, array $searchable)
    {
        if ($request->has('search') && $request->search !== null && $request->search !== '' ) {
            $searchTerm = $request->input('search');

            if ($request->has('sort_by')) {
                $this->validateSortBy( $searchable);
                $query->where($request->sort_by, 'LIKE', "%$searchTerm%");
            } else {
                foreach ($searchable as $field) {
                    $query->orWhere($field, 'LIKE', "%$searchTerm%");
                }
            }
        }

        if ($request->has('trash') && $request->input('trash') == 1 && Auth::user()?->hasRole(Constants::SUPER_ADMIN_ROLE) ){
            $query->onlyTrashed();
        }
    }
    protected function validateSortBy( $searchable)
    {
        $validator = validator()->make(
            ['sort_by' => 'in:' . implode(',', $searchable)],
            ['sort_by.in' => 'The selected sort_by field is invalid. Please choose from data base column']
        );
    
        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }
    }
}
