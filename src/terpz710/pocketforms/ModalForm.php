<?php

declare(strict_types=1);

namespace terpz710\pocketforms;

use pocketmine\form\Form;

use pocketmine\player\Player;

class ModalForm implements Form {

    private string $title;
    private string $content;
    private string $button1;
    private string $button2;
    private \Closure $callback;

    public function __construct(string $title, string $content, string $button1, string $button2, \Closure $callback) {
        $this->setTitle($title);
        $this->setContent($content);
        $this->setButton1($button1);
        $this->setButton2($button2);
        $this->callback = $callback;
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