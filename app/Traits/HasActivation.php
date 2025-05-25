<?php

namespace App\Traits;

use App\Enum\ActiveEnum;

trait HasActivation
{
    public function toggleActivation(): bool
    {
        $this->is_active = $this->isActive()
            ? ActiveEnum::INACTIVE->value
            : ActiveEnum::ACTIVE->value;

        return $this->save();
    }

    public function activate(): bool
    {
        $this->is_active = ActiveEnum::ACTIVE->value;
        return $this->save();
    }

    public function deactivate(): bool
    {
        $this->is_active = ActiveEnum::INACTIVE->value;
        return $this->save();
    }

    public function isActive(): bool
    {
        return (int)$this->is_active === ActiveEnum::ACTIVE->value;
    }

    public function getActiveStatus(): ActiveEnum
    {
        return ActiveEnum::from((int)$this->is_active);
    }
}
