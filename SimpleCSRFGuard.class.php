<?php

/**
 * SimpleCSRFGuard
 *
 * Auhtor: Romain GARCIA
 * GitHub: https://github.com/RomainGarcia/SimpleCSRFGuard
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */

class SimpleCSRFGuard
{
    private $m_TokenName;
    private $m_MaxTokens;
    private $m_TokenSize;

    public function __construct($tokenName = "_csrf_token", $tokenSize = 64, $maxTokens = 30)
    {
        $this->m_TokenName = preg_match('/^[a-zA-Z0-9_\-]+$/', $tokenName) ? $tokenName : "_csrf_token";
        $this->m_MaxTokens = is_integer($maxTokens) ? (int) $maxTokens : 30;
        $this->m_TokenSize = is_integer($tokenSize) ? (int) $tokenSize : 64;
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

    public function getTokenName()
    {
        return $this->m_TokenName;
    }

    public function generateToken()
    {
        $token = bin2hex(random_bytes($this->m_TokenSize));
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
