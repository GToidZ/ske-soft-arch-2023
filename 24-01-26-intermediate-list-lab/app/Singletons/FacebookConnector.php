<?php

namespace App\Singletons;

use App\Singletons\Singleton;
use App\Models\Task;

class FacebookConnectorSingleton extends Singleton {

    private static $token = "";
    private static $state = "";

    public static function buildAuthURL(string $state) {
        self::$state = $state;
        return "https://www.facebook.com/" . $_ENV["FB_API_VERSION"] . "/dialog/oauth?" .
            "client_id=" . $_ENV["FB_APP_ID"] .
            "&redirect_url=" . $_ENV["APP_URL"] . "/fblogin" .
            "&response_type=token" .
            "&scope=user_posts" .
            "&state=" . $state;
    }

    public function isLoggedIn(): bool {
        return !(self::$token->empty());
    }

    public function login(string $token) {
        // TODO: Test with Facebook's token recognizer. If OK, set the token.
        self::$token = $token;
        return self::default();
    }

    public function logout() {
        self::$token = "";
        return self::default();
    }

    public function post(Task $task) {
        // TODO: Post a task on facebook.
        return self::default();
    }

    private function default() {
        return redirect('/tasks');
    }

}