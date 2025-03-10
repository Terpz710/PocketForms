<?php

declare(strict_types=1);

namespace terpz710\pocketforms;

use pocketmine\form\Form;

use pocketmine\player\Player;

class SimpleForm implements Form {
    
    private string $title = "";
    private string $content = "";
    private array $buttons = [];
    private ?\Closure $callback = null;

    public function setTitle(string $title) : self{
        $this->title = $title;
        return $this;
    }

    public function setContent(string $content) : self{
        $this->content = $content;
        return $this;
    }

    public function addButton(string $text, int $imageType = -1, string $imagePath = "") : self{
        $button = ["text" => $text];

        if ($imageType !== -1) {
            $button["image"] = [
                "type" => $imageType === 0 ? "path" : "url",
                "data" => $imagePath
            ];
        }

        $this->buttons[] = $button;
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
            "type" => "form",
            "title" => $this->title,
            "content" => $this->content,
            "buttons" => $this->buttons
        ];
    }
}
