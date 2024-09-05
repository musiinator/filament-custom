<?php

namespace Filament\Forms\Components\Concerns;

trait HasCharacterSubstitute
{
    protected array $sourceCharacters = [];
    protected array $destinationCharacters = [];

    public function characterSubstitution(array $source, array $destination): static
    {
        $this->sourceCharacters = $source;
        $this->destinationCharacters = $destination;
        return $this;
    }

    public function getSourceCharacters(): array
    {
        return $this->sourceCharacters;
    }

    public function getDestinationCharacters(): array
    {
        return $this->destinationCharacters;
    }

    public function hasCharacterSubstitution(): bool
    {
        return !empty($this->sourceCharacters) && !empty($this->destinationCharacters);
    }

    protected function applyCharacterSubstitution(string $value): string
    {
        if (!$this->hasCharacterSubstitution()) {
            return $value;
        }

        $result = '';
        $chars = mb_str_split($value);
        foreach ($chars as $char) {
            $index = array_search($char, $this->sourceCharacters, true);
            if ($index !== false && isset($this->destinationCharacters[$index])) {
                $result .= $this->destinationCharacters[$index];
            } else {
                $result .= $char;
            }
        }
        return $result;
    }
}
