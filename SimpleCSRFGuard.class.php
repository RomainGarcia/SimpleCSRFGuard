<?php

/**
 *
 */
class SimpleCSRFGuard
{
    private $m_TokenName;
    private $m_MaxTokens;

    public function __construct($tokenName = "_csrf_token", $maxTokens = 30)
    {
        $this->m_TokenName = $tokenName;
        $this->m_MaxTokens = $maxTokens;
    }

    private function storeToken($token)
    {
        if (!isset($_SESSION[$this->m_TokenName])) {
            $_SESSION[$this->m_TokenName] = array($token);
        } else {
            if (count($_SESSION[$this->m_TokenName]) >= $this->m_MaxTokens) {
                array_shift($_SESSION[$this->m_TokenName]);
            }
            array_push($_SESSION[$this->m_TokenName], $token);
        }
    }

    private function removeToken($token)
    {
        if (isset($_SESSION[$this->m_TokenName])) {
			unset($_SESSION[$this->m_TokenName][array_search($token, $_SESSION[$this->m_TokenName])]);
        }
    }

    public function generateToken()
    {
        $token = bin2hex(random_bytes(64));
        $this->storeToken($token);
        return $token;
    }

    public function validateToken($token)
    {
        if ((!is_string($token) || !isset($_SESSION[$this->m_TokenName]))) {
            return false;
        } else {
            $result = in_array($token, $_SESSION[$this->m_TokenName]);
            $this->removeToken($token);
            return $result;
        }
    }
}
