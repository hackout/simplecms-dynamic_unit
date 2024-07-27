<?php
namespace SimpleCMS\DynamicUnit\Packages;

use Illuminate\Support\Collection;

class DynamicModel implements \JsonSerializable
{

    public function __construct(public int $id, public string $name, public string $value, public null|Collection $items)
    {
    }


    /**
     * toArray
     * @return array<string,null|string>>
     */
    public function toArray(): array
    {
        $data = [
            'id' => $this->id ?? 0,
            'name' => $this->name ?? null,
            'value' => $this->value ?? null,
            'items' => $this->items ? $this->items->toArray() : null
        ];

        return $data;
    }

    /**
     * jsonSerialize
     * @return mixed
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * __toString
     * @return string
     */
    public function __toString(): string
    {
        return json_encode($this->toArray());
    }
}