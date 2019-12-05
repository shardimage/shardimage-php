<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\models\accesstoken;

/**
 * Description of MixedShaPasswordHash
 */
class MixedShaPasswordHash implements PasswordHashInterface
{
    /**
     * @var string Encrypted password
     */
    private $encryptedPassword;

    /**
     * Construct
     * @param string $password
     */
    public function __construct(string $password)
    {
        $this->encryptedPassword = $this->encrypt($password);
    }

    /**
     * Encrypting password
     * @param string $password
     * @return string
     */
    public function encrypt(string $password): string
    {
        $passwordHash = sha1($password);
        return sha1(hex2bin($passwordHash) . $passwordHash);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return ['msha1', $this->encryptedPassword];
    }
}
