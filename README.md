# simple-rest-api-core

```php
  $app = new App();

  $app->route("/users/{id}", ['GET', 'POST', 'PUT'], User::class, 'getUser');

  $app->route("/index/index/{id}/{d}", ['GET'], User::class, 'getUser');

  $app->run();

```

<script>alert("hello")</script>
