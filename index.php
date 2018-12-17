<?php 

\Swoole\Coroutine::create(function () {
    echo "hello go1 \n";
});

echo "hello main \n";

