<?php

declare(strict_types=1);

namespace terpz710\pocketforms;

use pocketmine\form\Form;

use pocketmine\player\Player;

class CustomForm implements Form {

    private string $title;
    private array $elements = [];
    private ?\Closure $callback = null;

    public function setTitle(string $title) : self{
        $this->title = $title;
        return $this;
    }

    public function addElement(array $element) : self{
        $this->elements[] = $element;
        return $this;
    }

    public function setCallback(\Closure $callback) : self{
        $this->callback = $callback;
        return $this;
    }

    public function handleResponse(Player $player, $data) : void{
        if ($this->callback !== null) {
            ($this->callback)($player, $data);
        }
    }

    public function jsonSerialize() : array{
        return [
            "type" => "custom_form",
            "title" => $this->title,
            "content" => $this->elements
        ];
    }
}
