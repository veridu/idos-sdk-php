<?php

declare(strict_types = 1);

namespace idOS\Auth;

class StringToken extends AbstractAuth {
    /**
     * The token name.
     *
     * @var string
     */
    private $name;
    /**
     * The token.
     *
     * @var string
     */
    private $token;

    /**
     * Class constructor.
     *
     * @param string $name
     * @param string $token
     *
     * @return void
     */
    public function __construct(string $name, string $token) {
        $this->name  = $name;
        $this->token = $token;
    }

    /**
     * Returns the token.
     *
     * @return string
     */
    public function getToken() : string {
        return $this->token;
    }

    /**
     * Returns the token string representation.
     *
     * @return string
     */
    public function __toString() : string {
        return sprintf('%s %s', ucfirst($this->name), $this->getToken());
    }
}
