<?php

declare(strict_types=1);

namespace terpz710\pocketforms;

use pocketmine\form\Form;

use pocketmine\player\Player;

class SimpleForm implements Form {

    private string $title;
    private string $content;
    private array $buttons = [];
    private \Closure $callback;

    public function __construct(string $title, string $content, \Closure $callback) {
        $this->setTitle($title);
        $this->setContent($content);
        $this->callback = $callback;
    }

    public function setTitle(string $title) : self{
        $this->title = $title;
        return $this;
    }

    public function setContent(string $content) : self 
{
        $this->content = $content;
        return $this;
    }

    public function addButton(string $text, ?string $imageType = null, ?string $imagePath = null) : self{
        $button = ["text" => $text];
        if ($imageType !== null && $imagePath !== null) {
            $button["image"] = ["type" => $imageType, "data" => $imagePath];
        }
        $this->buttons[] = $button;
        return $this;
    }

    public function handleResponse(Player $player, $data) : void{
        if ($data !== null && is_int($data)) {
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