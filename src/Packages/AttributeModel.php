<?php
namespace SimpleCMS\DynamicUnit\Packages;


class AttributeModel implements \JsonSerializable
{
    protected ?string $thumbnail = null;

    public function __construct(public string $name, public string $value, array $thumbnail = [])
    {
        if (!empty($thumbnail)) {
            $this->thumbnail = $thumbnail['url'];
        }
    }


    /**
     * toArray
     * @return array<string,null|string>>
     */
    public function toArray(): array
    {
        $data = [
            'name' => $this->name ?? null,
            'value' => $this->value ?? null,
            'thumbnail' => $this->thumbnail ?? null
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