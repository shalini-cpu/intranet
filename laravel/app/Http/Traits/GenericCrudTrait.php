<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Log;
use Throwable;

trait GenericCrudTrait
{

    /// Generic insert
    public function genericInsert($fields, array $vali_rules, Model $model)
    {
        try {

            $validator = Validator::make($fields, $vali_rules);

            if ($validator->passes()) {
                $inserted = $model->create($fields);
                return $this->responseWithSuccess("Data inserted");
            }

            return $this->responseWithError('Validation Error', [$validator->messages(), $fields]);


        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return $this->responseWithError("Internal server error", [$e->getMessage()], 400, 400);
        }
    }

    /// Generic Update
    public function genericUpdate($fields, array $vali_rules, Model $model, $id)
    {
        try {

            $fields["id"] = $id;
            $validator = Validator::make($fields, $vali_rules);
            $model = $model->find($id);

            if ($validator->passes() and $model) {
                optional($model)->update($fields);
                return $this->responseWithSuccess("Data updated successfuly");
            }

            return $this->responseWithError('ID or input is not valid', $validator->messages());

        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return $this->responseWithError("Internal server error", [], 400, 400);
        }
    }


    /// Generic Destroy
    public function genericDestroy(Model $model, $id, $vali_rules)
    {
        try {

            $validator = Validator::make(['id' => $id], $vali_rules);

            if ($validator->fails()) {
                return $this->responseWithError("Validation Error", $validator->messages(), 400);
            }

            $row_found = $model->find($id);

            if (optional($row_found)->status == 0) {
                return $this->responseWithError('Invalide ID');
            }

            if ($row_found) {
                $row_found->status = 0;
                $row_found->save();
                return $this->responseWithSuccess("deleted succesfully");
            }

            return $this->responseWithError('Please provide valid ID');

        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return $this
                ->responseWithError(
                    "Internal server error", [],
                    400,
                    400
                );
        }

    }

}
