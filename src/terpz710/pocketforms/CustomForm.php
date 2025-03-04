<?php

declare(strict_types=1);

namespace terpz710\pocketforms;

use pocketmine\form\Form;

use pocketmine\player\Player;

class CustomForm implements Form {

    private string $title;
    private array $elements = [];
    private \Closure $callback;

    public function __construct(string $title, \Closure $callback) {
        $this->setTitle($title);
        $this->callback = $callback;
    }

    public function setTitle(string $title) : self{
        $this->title = $title;
        return $this;
    }

    public function addLabel(string $text) : self{
        $this->elements[] = ["type" => "label", "text" => $text];
        return $this;
    }

    public function addInput(string $text, string $placeholder = "", string $default = "") : self{
        $this->elements[] = ["type" => "input", "text" => $text, "placeholder" => $placeholder, "default" => $default];
        return $this;
    }

    public function addDropdown(string $text, array $options, int $default = 0) : self{
        $this->elements[] = ["type" => "dropdown", "text" => $text, "options" => $options, "default" => $default];
        return $this;
    }

    public function addToggle(string $text, bool $default = false) : self{
        $this->elements[] = ["type" => "toggle", "text" => $text, "default" => $default];
        return $this;
    }

    public function addSlider(string $text, float $min, float $max, float $step = 1.0, float $default = 0) : self{
        $this->elements[] = ["type" => "slider", "text" => $text, "min" => $min, "max" => $max, "step" => $step, "default" => $default];
        return $this;
    }

    public function addStepSlider(string $text, array $steps, int $default = 0) : self{
        $this->elements[] = ["type" => "step_slider", "text" => $text, "steps" => $steps, "default" => $default];
        return $this;
    }

    public function addContent(string $text) : self{
        return $this->addLabel($text);
    }

    public function handleResponse(Player $player, $data) : void{
        if ($data !== null) {
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