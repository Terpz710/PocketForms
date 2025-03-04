<?php

declare(strict_types=1);

namespace terpz710\pocketforms;

use pocketmine\form\Form;

use pocketmine\player\Player;

class ModalForm implements Form {

    private string $title = "";
    private string $content = "";
    private string $button1 = "Yes";
    private string $button2 = "No";
    private \Closure $callback;

    public function __construct() {
        $this->callback = function (Player $player, bool $data): void {};
    }

    public function setTitle(string $title) : self{
        $this->title = $title;
        return $this;
    }

    public function setContent(string $content) : self{
        $this->content = $content;
        return $this;
    }

    public function setButton1(string $button1) : self{
        $this->button1 = $button1;
        return $this;
    }

    public function setButton2(string $button2) : self{
        $this->button2 = $button2;
        return $this;
    }

    public function setCallback(\Closure $callback) : self{
        $this->callback = $callback;
        return $this;
    }

    public function handleResponse(Player $player, $data) : void{
        if (is_bool($data)) {
            ($this->callback)($player, $data);
        }
    }

    public function jsonSerialize() : array{
        return [
            "type" => "modal",
            "title" => $this->title,
            "content" => $this->content,
            "button1" => $this->button1,
            "button2" => $this->button2
        ];
    }
}
