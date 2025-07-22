<?php

namespace App\Entities;

use Myth\Auth\Entities\User as MythUser;

class User extends MythUser
{
    /**
     * Returns the correct URL for a user's avatar.
     * Handles both local files and external URLs.
     *
     * @return string
     */
    // In app/Entities/User.php
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'reset_at', 'activate_expires'];

    public function getAvatar(): string
    {
        $avatar = $this->attributes['avatar'] ?? null;

        if (empty($avatar) || $avatar === 'default.jpg') {
            // You can change 'default-avatar.png' to your actual default avatar file.
            return base_url('media/photos/default.jpg'); // Ensure this is your default avatar
        }

        // Fix for malformed URLs that might be stored as "https:/" instead of "https://"
        if (strpos($avatar, 'https:/') === 0 && strpos($avatar, 'https://') !== 0) {
            $avatar = str_replace('https:/', 'https://', $avatar);
        }

        // Check if the avatar is a full URL (like from Google).
        if (filter_var($avatar, FILTER_VALIDATE_URL)) {
            return $avatar;
        }

        // Otherwise, it's a local file, so prepend the base URL.
        return base_url('media/photos/' . $avatar);
    }

    /**
     * Returns the user's total coin, defaulting to 0 if not set.
     *
     * @return int
     */
    public function getTotalCoin(): int
    {
        // Ensure that total_coin is always an integer.
        return (int) ($this->attributes['total_coin'] ?? 0);
    }
}
