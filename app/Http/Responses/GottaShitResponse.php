<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

abstract class GottaShitResponse implements Responsable
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        return request()->ajax()
            ? $this->toJson()
            : $this->toView();
    }

    abstract protected function toJson();

    abstract protected function toView();
}
