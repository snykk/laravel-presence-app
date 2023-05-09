<?php

namespace App\Http\Requests\Concerns;

trait DefaultAppends
{
    abstract protected function getDefaultAppends(): array;

    public function prepareForValidation()
    {
        $currAppend = $this['append'];
        $this['append'] = implode(',', $this->getDefaultAppends());
        if ($currAppend && $currAppend !== '') {
            $this['append'] .= ','.$currAppend;
        }
    }
}
