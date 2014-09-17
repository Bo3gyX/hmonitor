<?php
namespace core\traits;

trait Properties
{
    public function initProperties(array $properties, $modifiers = \ReflectionProperty::IS_PUBLIC)
    {
        return $this->setProperties($properties, false, $modifiers);
    }

    public function setProperties(array $properties, $is_null = true, $modifiers = \ReflectionProperty::IS_PUBLIC)
    {
        $this_class = new \ReflectionClass($this);

        $public_properties = $this_class->getProperties($modifiers);

        foreach ($public_properties as $property) {

            $name = $property->getName();

            if (isset($properties[$name])) {

                if ($is_null && !is_null($this->$name)) {
                    continue;
                }

                $this->$name = $properties[$name];
                unset($properties[$name]);
            }
        }

        return $properties;
    }

    public function getProperties($modifiers = \ReflectionProperty::IS_PUBLIC)
    {
        $this_class = new \ReflectionClass($this);

        $public_properties = $this_class->getProperties($modifiers);

        $properties = array();
        foreach ($public_properties as $property) {

            $name = $property->getName();
            $value = $property->getValue($this);

            $properties[$name] = $value;
        }

        return $properties;
    }
}

